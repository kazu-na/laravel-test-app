@extends('common.layout')

@section('order')
  <div>
    <p>ログイン: {{ $user->name }} さん</p>
  </div>

  <div>
    <h1>注文</h1>
  </div>

  <div>
    <h2>商品一覧</h2>
  </div>
  </div style="display: flex;">
    @foreach ($products as $product)
      <p>店舗名: {{$product->shop->name}}</p>
      <p>商品名: {{$product->product_name}}</p>
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
    @endforeach
  </div>

  <div>
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
            <td>{{$order->order_amount}}</td>
            <td>{{$order->order_date}}</td>
            <td>{{$order->receive_date}}</td>
            <td>{{$order->order_state}}</td>
            <td>
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