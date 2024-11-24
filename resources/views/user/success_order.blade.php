@extends('user.layouts.app')

@section('content')
    <div style="margin-top: 200px; margin-bottom: 100px">
        <p class="fs-4 text-center">Đặt hàng thành công <i class="rounded-1 fa-solid fa-check text-success"></i></p>
        <div class="text-center">
            <img class="img-thumbnail shadow" src="{{ asset('user-assets/image/order_success.png')}}" alt="">
            <p class="fs-4 text-center"> Mã đơn hàng là: {{ $id }} </p>
        </div>
    </div>
@endsection