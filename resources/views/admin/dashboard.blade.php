@extends('admin.layouts.app')

@section('content')
    <section class="content-header">	
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bảng điều khiển</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('users.index') }}" class="text-dark">
                        <div class="card card-outline card-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Tổng số khách hàng</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $totalUser }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('orders.complete') }}" class="text-dark">
                        <div class="card card-outline card-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Đơn hàng đã giao thành công</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $totalOrderComplete }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('orders.index') }}" class="text-dark">
                        <div class="card card-outline card-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Tổng số đơn hàng</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{  $totalOrder }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('orders.cancel') }}" class="text-dark">
                        <div class="card card-outline card-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Tổng số đơn hàng đã hủy</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCancelOrders }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-ban text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('products.index') }}" class="text-dark">
                        <div class="card card-outline card-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Tổng số sản phẩm</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProduct }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-box-open fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('orders.getUserVip') }}" class="text-dark">
                        <div class="card card-outline card-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                           Khách hàng thân thiết</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersVipCount }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-box-open fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <hr><h2>Thống kê doanh thu</h2><hr>
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card card-outline card-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Tổng thu nhập</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenue) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingWeek')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Thu nhập (hàng tuần)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{  formatPriceVND($totalRevenueWeek) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingMonth')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Thu nhập (hàng tháng)</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenueMonth) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingLastMonth')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Thu nhập tháng trước</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenueLastMonth) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingYear')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Thu nhập năm-<?= date('Y'); ?> </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenueYear) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            {{-- Thống kê theo quý --}}
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingQuarter1')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Doanh thu quý 1-<?= date('Y'); ?></div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenueQuarter1) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingQuarter2')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Doanh thu quý 2-<?= date('Y'); ?></div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenueQuarter2) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingQuarter3')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Doanh thu quý 3-<?= date('Y'); ?></div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenueQuarter3) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <a class="text-dark" href="{{ route('admin.sellingQuarter4')}}">
                        <div class="card card-outline card-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Doanh thu quý 4-<?= date('Y'); ?></div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatPriceVND($totalRevenueQuarter4) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa-solid fa-dong-sign fa-2x text-danger"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> 
                </div>
            </div>
        </div>	
    </section>
@endsection

@section('js')
   <script>
     console.log("Hello Fen")
   </script>
@endsection