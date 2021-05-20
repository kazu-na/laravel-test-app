<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

// use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index () 
    {
        $user = User::find(1);

        // N+1を避ける為にall()ではなくwithを使用しeager_loadする
        $products = Product::with('shop')->get();
        $orders = Order::with('user', 'shop', 'product')->get();

        return view('order', compact('user', 'products', 'orders'));
    }

    public function create(Request $request)
    {
        $order = new Order;
        $order->user_id = $request->user_id;
        $order->shop_id = $request->shop_id;
        $order->product_id = $request->product_id;
        $order->order_amount = $request->product_amount;
        $order->order_date = now()->format('y/m/d');
        $order->receive_date = now()->format('y/m/d');
        $order->save();
        return redirect('order');
    }

    public function delete(Request $request)
    {
        $order = Order::find($request->id)->delete();
        return redirect('order');
    }
}
