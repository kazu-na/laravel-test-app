@extends('common.layout')

@section('order')
  <div>
    <p>ログイン: {{ $user }} さん</p>
  </div>

  <div>
    <h1>注文</h1>
  </div>

  <div>
    <h2>商品一覧</h2>

    @foreach ($products as $product)
      {{ $product }}<br>
    @endforeach
  </div>

  <div>
    <h2>注文履歴</h2>

    @foreach ($orders as $order)
      {{ $order }}<br>
    @endforeach
  </div>
@endsection