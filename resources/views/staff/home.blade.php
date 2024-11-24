@extends('staff.layouts.app')

@section('content')
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Bảng điều khiển</h1>
                <ul class="breadcrumb">
                    <li>
                        <a class="active" href="{{route('staff.home')}}">Trang chủ</a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="box-info">
            <li>
                <i class='bx bxs-calendar-check' ></i>
                <span class="text">
                    <p>Số đơn hàng</p>
                    <h3>{{$totalOrders}}</h3>
                </span>
            </li>
            <li>
                <i class='bx bxs-calendar-check' ></i>
                <span class="text">
                    <p>Đơn hàng đang giao</p>
                    <h3>{{$beingTransported}}</h3>
                </span>
            </li>
            <li>
                <i class='bx bxs-calendar-check'></i>
                <span class="text">
                    <p>Đơn hàng hoàn thành</p>
                    <h3>{{$ordersComplete}}</h3>
                </span>
            </li>
        </ul>

    </main>
@endsection

@section('js')
    <script>
     console.log("Hello Fen")
   </script>
@endsection