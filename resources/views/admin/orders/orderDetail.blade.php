@extends('admin.layouts.app')

@section('content')
    <section class=" section-11 ">
        <div class="container-fluid" style="margin-top: 50px">
            <div class="mt-5 d-flex justify-content-start">
                <div class="w-50">
                    @include('admin.message')
                </div>	
            </div>
            <div class="m-1 p-1 text-right">
                <a href="{{ url('admin/invoice', $order->id) }}" class="m-1 p-1 text-dark bg-warning border rounded-3"><i class="fa-regular fa-eye m-1 p-1"></i>Xem hóa đơn</a>
                <a href="{{ url('admin/invoice/' . $order->id . '/exportPdf') }}" class="m-1 p-1 text-dark bg-danger border rounded-3"> <i class='bx bx-export m-1 p-1'></i>Xuất hóa đơn</a>
            </div>
            <div class="row">
                <div class="col-md-12"> 
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row m-1">
                                <div class="col-6 col-lg-3">
                                    <h6 class="heading-xxxs text-muted">Mã đơn hàng:</h6>
                                    <p class="mb-lg-0 fs-sm fw-bold">
                                        {{ $order->id}}
                                    </p>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <h6 class="heading-xxxs text-muted">Ngày đặt hàng:</h6>
                                    <!-- Text -->
                                    <p class="mb-lg-0 fs-sm fw-bold">
                                        <time datetime="2019-10-01">
                                            {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}
                                        </time>
                                    </p>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <h6 class="heading-xxxs text-muted">Trạng thái đơn hàng:</h6>
                                    <p class="mb-0 fs-sm fw-bold">
                                        @if ($order->status == 'Chờ xử lý')  
                                            <span class="badge bg-danger">Chờ xử lý</span>
                                        @elseif($order->status == 'Đang vận chuyển') 
                                            <span class="badge bg-info">Đang vận chuyển</span>
                                        @elseif($order->status == 'Đã giao hàng') 
                                            <span class="badge bg-success">Đã giao hàng</span>
                                        @else
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <!-- Heading -->
                                    <h6 class="heading-xxxs text-muted">Tổng tiền:</h6>
                                    <!-- Text -->
                                    <p class="mb-0 fs-sm fw-bold">{{  formatPriceVND($order->grand_total) }}</p>
                                </div>
                            </div>
                            <hr>
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <td>Hình ảnh</td>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (!empty ($orderDetail))
                                        @foreach ($orderDetail as $item)
                                            @php
                                                $productImage =  $item->product->product_images->first();
                                            @endphp
                                                <td>
                                                    <div class="d-flex mb-2">
                                                        @if (!empty($productImage->image))
                                                            <img clas="card-img-top" src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="50" > 
                                                        @else
                                                            <img clas="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex mb-2">
                                                        <div class="flex-lg-grow-1 ms-3">
                                                            <p class="small mb-0">{{$item->name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{$item->qty}}</td>
                                                <td class="text-end">{{  formatPriceVND($item->price) }}</td>
                                            </tr>
                                        @endforeach
                                @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Tạm tính</td>
                                        <td class="text-end">{{ formatPriceVND($order->subtotal) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Áp dụng giảm giá</td>
                                        <td class="text-end">{{ formatPriceVND($discountAmount) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Phí vận chuyển</td>
                                        <td class="text-end">{{ formatPriceVND($order->shipping) }}</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td colspan="2">Tổng</td>
                                        <td class="text-end">{{ formatPriceVND($order->grand_total) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <!-- Payment -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-6">
                                    <h3 class="h6">Trạng thái thanh toán</h3>
                                    <hr>
                                    <span>Trạng thái: 
                                        @if ($order->payment_status == 'Chưa thanh toán')  
                                            <span class="badge bg-danger">Chưa thanh toán</span>
                                        @else
                                            <span class="badge bg-success">Đã thanh toán</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="col-lg-6">
                                    <h3 class="h6">Thông tin nhận hàng</h3>
                                    <hr>
                                    <p>Tên khách hàng: <span class="fw-bold">{{$order->name}}</span></p>
                                    <p>Địa chỉ: <span class="fw-bold"> {{$order->address}}-{{$order->ward }}-{{$order->district }}-{{$order->city }}</span></p>
                                    <p title="Phone">Số điện thoại: <span class="fw-bold">{{$order->mobile }}</span></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    <div class="card mb-4">
                        <form action="" method="post" name="changeOrderStatusForm" id="changeOrderStatusForm">
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div clas="card">
                                            <h2 class="h4 mb-3">Trạng thái đơn hàng</h2>
                                            <div class="mb-3">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="Chờ xử lý" {{ ($order->status == 'Chờ xử lý') ? 'selected' : '' }} >Chờ xử lý</option>
                                                    <option value="Đang vận chuyển"  {{ ($order->status == 'Đang vận chuyển') ? 'selected' : '' }} >Đang vận chuyển</option>
                                                    <option value="Đã giao hàng"  {{ ($order->status == 'Đã giao hàng') ? 'selected' : '' }} >Đã giao hàng</option>
                                                    <option value="Hủy đơn"  {{ ($order->status == 'Hủy đơn') ? 'selected' : '' }} >Hủy đơn</option>
                                                </select>
                                            </div>
                                            <h2 class="h4 mb-3">Ngày giao hàng dự kiến</h2>
                                            <div class="mb-3">
                                                <input type="datetime-local" name="shipped_date" id="shipped_date">
                                                <p class="mb-lg-0 fs-sm fw-bold">
                                                    <time datetime="2019-10-01">
                                                        @if (!empty($order->shipped_date))
                                                            <p class="m-1">Ngày vận chuyển hiện tại: <strong>{{ \Carbon\Carbon::parse($order->shipped_date)->format('d/m/Y')}}</strong></p>
                                                        @else
                                                            <p class="m-1 text-center">Chưa cập nhật</p>
                                                        @endif
                                                    </time>
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-success">Cập nhật</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                    <div class="col-sm-12 col-lg-6">
                                        <form  method="post" name="sendEmail" id="sendEmail">
                                            <h2 class="h4 mb-3">Gửi đơn hàng qua email</h2>
                                            <div class="h4 mb-3">
                                                <select name="userType" id="userType" class="form-control">
                                                    <option value="user">Khách hàng</option>
                                                    <option value="admin">Quản trị viên</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary">Gửi</button>
                                            </div>
                                        </form>
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
        $("#changeOrderStatusForm").submit(function(event){
            event.preventDefault();
            if(confirm("Cập nhật trạng thái đơn hàng")){
                $.ajax({
                    url : '{{ route("orders.changeOrderStatus", $order->id) }}',
                    type: 'post',
                    data: $(this).serializeArray(),
                    dataType: 'json',
                    success: function(response){
                        window.location.href = '{{ route("orders.detailOrder", $order->id) }}';
                    }
                });
            }
        });

        $("#sendEmail").submit(function(event){
            event.preventDefault();
            
           if(confirm("Gửi đơn hàng qua email?")){
                $.ajax({
                    url : '{{ route("orders.sendEmailOrder", $order->id) }}',
                    type: 'post',
                    data: $(this).serializeArray(),
                    dataType: 'json',
                    success: function(response){
                        window.location.href = '{{ route("orders.detailOrder", $order->id) }}';
                    }
                });
           }
        });

    </script>
@endsection