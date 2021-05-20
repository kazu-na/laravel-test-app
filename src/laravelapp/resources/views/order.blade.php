@extends('common.layout')

@section('order')
<div class="ml-12">
  <p>ログイン: {{ $user->name }} さん</p>
</div>

<div class="ml-12">
  <h1>注文</h1>
</div>

<div class="relative flex bg-gray-100 dark:bg-gray-900">
  <div class="ml-12">
    <h2>商品一覧</h2>
    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
      @foreach ($products as $product)
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
          <div class="p-6">
            <p>{{$product->product_name}}</p>
            <div class="ml-12">
              <div class="mt-2 text-gray-600 dark:text-gray-400">
                <p>店舗名: {{$product->shop->name}}</p>
                <p>商品概要: {{$product->product_description}}</p>
                <p>商品金額: {{$product->product_amount}}円</p>
                <form action='{{ route('order_create') }}' method='post'>
                  @csrf
                  <input type="hidden" name="user_id" value="{{$user->id}}">
                  <input type="hidden" name="shop_id" value="{{$product->shop_id}}">
                  <input type="hidden" name="product_id" value="{{$product->id}}">
                  <input type="hidden" name="product_amount" value="{{$product->product_amount}}">
                  <input type='submit' value='注文する'>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<div class="ml-12">
  <h2>注文履歴</h2>

  <table width="100%">
    <thead>
      <tr>
        <th>店舗名</th>
        <th>商品名</th>
        <th>注文金額</th>
        <th>注文日</th>
        <th>商品受取日</th>
        <th>注文ステータス</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($orders as $order)
        <tr>
          <td>{{$order->shop->name}}</td>
          <td>{{$order->product->product_name}}</td>
          <td>{{$order->order_amount}}円</td>
          <td class="text-center">{{$order->order_date}}</td>
          <td class="text-center">{{$order->receive_date}}</td>
          <td class="text-center">{{$order->order_state}}</td>
          <td class="text-center">
            <form action="{{route('order_delete')}}" method="post">
              @csrf
              <input type="hidden" name="id" value="{{$order->id}}">
              <input type="submit" value="注文キャンセル">
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection