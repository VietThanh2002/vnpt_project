@extends('user.layouts.app')

@section('content')
    <div style="margin-top: 200px; margin-bottom: 100px">
        <p class="fs-4 text-center">Thành công <i class="rounded-1 fa-solid fa-check text-success"></i></p>
        <p class="fs-4 text-center">Nhân viên hỗ trợ sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
        <div class="text-center">
            <img class="img-thumbnail shadow w-25 h-25" src="{{ asset('user-assets/image/lienhe.png')}}" alt="">
            <p class="fs-4 text-center"> Mã đơn hàng là: {{ $id }} </p>
        </div>
    </div>
@endsection