@extends('user.layouts.app')

@section('content')

    <section class=" section-11" style="margin-top: 200px; margin-bottom: 30px;">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('user.component.sidebar')
                </div>
                <div class="col-md-9">
                    @include('user.message')
                    <div class="card">
                        <div class="card-header m-2 text-center">Lịch sử đặt hàng</div>
                        <div class="bg-light">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button" role="tab" aria-controls="orders" aria-selected="true">Đơn hàng</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="cancelOrders-tab" data-bs-toggle="tab" data-bs-target="#cancelOrders" type="button" role="tab" aria-controls="cancelOrders" aria-selected="false">Đơn hàng đã hủy</button>
                                </li>
                            </ul>
                            <div class="tab-content m-2 p-" id="myTabContent">
                                <div class="tab-pane fade show active" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                    <div class="card-body p-0">
                                        <!-- Billing history table-->
                                        <div class=" table-billing-history">
                                            <table id="myTable" class="table mb-0 shadow">
                                                <thead>
                                                    <tr> 
                                                        <th class="border-gray-200" scope="col">STT</th>
                                                        <th class="border-gray-200" scope="col">Mã đơn hàng</th>
                                                        <th class="border-gray-200" scope="col">Ngày đặt</th>
                                                        <th class="border-gray-200" scope="col">Tổng</th>
                                                        <th class="border-gray-200" scope="col">Trạng thái</th>
                                                        <th class="border-gray-200" scope="col">Chi tiết đơn hàng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($orders))
                                                        @foreach ($orders as $key => $item)
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{ $item->id}}</td>
                                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                                                <td>{{ formatPriceVND($item->grand_total) }}</td>
                                                                <td>
                                                                    @if ($item->status == 'Chờ xử lý')  
                                                                        <span class="badge bg-danger">Chờ xử lý</span>
                                                                    @elseif($item->status == 'Đang vận chuyển') 
                                                                        <span class="badge bg-info">Đang vận chuyển</span>
                                                                    @else
                                                                        <span class="badge bg-success">Đã giao hàng</span>
                                                                    @endif
                                                                </td>
                                                                <td><div class="text-center"><a href="{{ route('user.getOrderDetail', $item->id) }}"><i class="fa-regular fa-eye "></i></a></div></td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr><p>Bạn chưa có đơn hàng nào !</p></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer clearfix">
                                            {{ $orders->links() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="cancelOrders" role="tabpanel" aria-labelledby="cancelOrders-tab">
                                    <div class="card-body p-0">
                                        <!-- Billing history table-->
                                        <div class=" table-billing-history">
                                            <table id="cancelledOrdersTable" class="table mb-0 shadow">
                                                <thead>
                                                    <tr>
                                                        <th class="border-gray-200" scope="col">STT</th>
                                                        <th class="border-gray-200" scope="col">Mã đơn hàng</th>
                                                        <th class="border-gray-200" scope="col">Ngày đặt</th>
                                                        <th class="border-gray-200" scope="col">Tổng</th>
                                                        <th class="border-gray-200" scope="col">Trạng thái</th>
                                                        <th class="border-gray-200" scope="col">Chi tiết đơn hàng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($cancelOrders))
                                                        @foreach ($cancelOrders as $key => $item)
                                                            <tr>
                                                                <td>{{ $key+1; }}</td>
                                                                <td>{{ $item->id}}</td>
                                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                                                <td>{{ formatPriceVND($item->grand_total) }}</td>
                                                                <td>
                                                                    @if ($item->status == 'Chờ xử lý')  
                                                                        <span class="badge bg-danger">Chờ xử lý</span>
                                                                    @elseif($item->status == 'Đang vận chuyển') 
                                                                        <span class="badge bg-info">Đang vận chuyển</span>
                                                                    @elseif($item->status == 'Đang giao hàng') 
                                                                        <span class="badge bg-success">Đã giao hàng</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Đã hủy</span>
                                                                    @endif
                                                                </td>
                                                                <td><div class="text-center"><a href="{{ route('user.getOrderDetail', $item->id) }}"><i class="fa-regular fa-eye "></i></a></div></td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr><p>Bạn chưa có đơn hàng nào !</p></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer clearfix">
                                            {{$cancelOrders->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
             </div>
    </section>
    
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#cancelledOrdersTable').DataTable({
            "paging": false,
            "searching": true,
            "info": false,
            "language": {
                "search": "Tìm kiếm:",
            },
        });
    });
</script>
@endsection