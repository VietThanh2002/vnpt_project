@extends('staff.layouts.app')
@section('content')
    <div style="margin-top: 10px; margin-bottom: 20px">
        <p class="text-secondary fs-4 text-center">Giao hàng thành công<i class="rounded-1 fa-solid fa-check text-success"></i></p>
        <div class="text-center">
            <img class="img-thumbnail shadow w-25 h-25" src="{{ asset('admin-assets/img/successful_delivery.png')}}" alt="">
            <p class="text-secondary fs-4 text-center"> Mã đơn hàng vừa giao là: {{ $id }} </p>
        </div>
    </div>
@endsection