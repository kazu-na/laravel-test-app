<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    // 注文ステータスが'未注文'の値
    public const PENDING_STATUS = 1;

    // 注文ステータスが'注文中'の値
    public const ORDERING_STATUS = 2;

    public function index()
    {
        // ログイン機能未実装のため、userテーブルの1レコード目を取得
        $user = User::find(1);

        // N+1を避ける為にall()ではなくwithを使用しeager_loadする
        $products = Product::with('shop')->get();
        $pending_orders = Order::with('user', 'shop', 'product')
                                ->where('user_id', $user->id)
                                ->where('order_state', self::PENDING_STATUS)
                                ->get();
        $orders = Order::with('user', 'shop', 'product')
                        ->where('user_id', $user->id)
                        ->where('order_state', '!=', self::PENDING_STATUS)
                        ->get();
        // dd(toArray($orders));

        return view('order', compact('user', 'products', 'pending_orders', 'orders'));
    }

    public function create(Request $request)
    {
        // 注文合計金額が5,000円を超える場合は注文不可にする
        $total_order_amount = Order::where('user_id', $request->user_id)
                                    ->where('order_state', self::PENDING_STATUS)
                                    ->pluck('order_amount')
                                    ->toArray();
        $total_order_amount = array_sum($total_order_amount);
        $total_order_amount += $request->product_amount;

        if ($total_order_amount > 5000) {
            return redirect('order')->with('msg_danger', '注文合計金額が5,000円を超えてしまうため注文できません');
        }

        $order = new Order();
        $order->user_id = $request->user_id;
        $order->shop_id = $request->shop_id;
        $order->product_id = $request->product_id;
        $order->order_amount = $request->product_amount;
        $order->order_date = now()->format('Y/m/d');
        $order->receive_date = now()->format('Y/m/d');
        $order->save();

        return redirect('order')->with('msg_success', '商品を選択しました');
    }

    public function update(Request $request)
    {
        $orders = Order::where('user_id', $request->user_id)
                        ->where('order_state', self::PENDING_STATUS)
                        ->update(['order_state' => self::ORDERING_STATUS]);

        return redirect('order')->with('msg_success', '注文が完了しました');
    }

    public function delete(Request $request)
    {
        $order = Order::find($request->id)->delete();

        return redirect('order')->with('msg_success', '注文をキャンセルしました');
    }

    // バリデーション
    public function store(Request $request)
    {
    }
}
