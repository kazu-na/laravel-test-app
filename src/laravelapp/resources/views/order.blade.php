@extends('common.layout')

@section('order')
<div style="float: right; margin-right:20px">
  <p>ログイン: {{ $user->name }} さん</p>
</div>

<div class="ml-12">
  <h1>注文</h1>
</div>

@if (session('msg_success'))
    <div class="bg-success text-center py-3 my-0">
        {{ session('msg_success') }}
    </div>
@endif

@if (session('msg_danger'))
    <div class="alert alert-danger text-center py-3 my-0">
        {{ session('msg_danger') }}
    </div>
@endif

<div class="relative flex bg-gray-100 dark:bg-gray-900">
  <div class="ml-12" style="margin-bottom: 100px">
    <h2>商品一覧</h2>
    @foreach ($products as $product)
      <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg" style="float: left; margin-right:20px">
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
                <input type='submit' value='商品を選択'>
              </form>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="ml-12" style="margin-bottom: 100px">
  <h2>注文内容</h2>
  @if ($pending_orders->count() == 0)
    <p>選択された商品はありません。</p>
  @else
    <p>この内容でよろしければ「注文する」ボタンを押してください。</p>
    <table width="100%">
      <thead>
        <tr>
          <th style="text-align: left;">店舗名</th>
          <th style="text-align: left;">商品名</th>
          <th style="text-align: left;">注文日</th>
          <th style="text-align: left;">商品受取日</th>
          <th style="text-align: left;">注文ステータス</th>
          <th>注文金額</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pending_orders as $pending_order)
          <tr>
            <td>{{$pending_order->shop->name}}</td>
            <td>{{$pending_order->product->product_name}}</td>
            <td>{{$pending_order->order_date}}</td>
            <td>{{$pending_order->receive_date}}</td>
            <td>{{$pending_order->order_state_text}}</td>
            <td style="text-align: right;">{{$pending_order->order_amount}}円</td>
            <td class="text-center">
              <form action="{{route('order_delete')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$pending_order->id}}">
                <input type="submit" value="選択キャンセル">
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div style="margin-top: 30px">
      <form action='{{ route('order_update') }}' method='post'>
        @csrf
        <input type="hidden" name="user_id" value="{{$user->id}}">
        <input type='submit' value='注文する'>
      </form>
    </div>
  @endif
</div>

<div class="bg-gray-100 dark:bg-gray-900">
  <div class="ml-12" style="margin-bottom: 100px">
    <h2>購入履歴</h2>

    <table width="100%">
      <thead>
        <tr>
          <th style="text-align: left;">店舗名</th>
          <th style="text-align: left;">商品名</th>
          <th style="text-align: left;">注文日</th>
          <th style="text-align: left;">商品受取日</th>
          <th style="text-align: left;">注文ステータス</th>
          <th>注文金額</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)
          <tr>
            <td>{{$order->shop->name}}</td>
            <td>{{$order->product->product_name}}</td>
            <td>{{$order->order_date}}</td>
            <td>{{$order->receive_date}}</td>
            <td>{{$order->order_state_text}}</td>
            <td style="text-align: right;">{{$order->order_amount}}円</td>
            <td class="text-center">
              @if ($order->order_state == 2)
                <form action="{{route('order_delete')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{$order->id}}">
                  <input type="submit" value="注文キャンセル">
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection