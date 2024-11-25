@extends('user.layouts.app')

@section('content')
    <section class=" section-11" style="margin-top: 200px; margin-bottom: 30px;">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    @include('user.component.sidebar')
                </div>
                <div class="col-md-9"> 
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
                                    <h6 class="heading-xxxs text-muted">Trạng thái đơn hàng:</h6>
                                    <p class="mb-0 fs-sm fw-bold">
                                        @if ($order->status == 'Chờ xử lý')  
                                            <span class="badge bg-danger">Chờ xử lý</span>
                                        @elseif($order->status == 'Đang vận chuyển') 
                                            <span class="badge bg-info">Đang vận chuyển</span>
                                        @elseif($order->status == 'Đang giao hàng') 
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
                                    <tr class="text-center">
                                        <th>Dịch vụ</th>
                                        <th>Giá</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if (!empty($orderDetail))
                                        @foreach ($orderDetail as $item)
                                            <tr class="text-center">
                                                <td class="">{{$item->name }} </td>
                                                <td class="">{{  formatPriceVND($item->price) }}</td>
                                            </tr>
                                        @endforeach
                                   @endif
                                </tbody>
                                <tfoot>
                                    <tr class="fw-bold">
                                        <td colspan="1">Tổng thanh toán: <span class="fw-bold">{{ formatPriceVND($order->grand_total) }}</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <!-- Payment -->
                    <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-lg-4">
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
                        <div class="col-lg-4">
                            <h3 class="h6">Địa chỉ nhận hàng</h3>
                            <hr>
                            <address>
                            <strong>{{$order->name}}</strong><br>
                                {{ $order->address}}<br>
                                {{ $order->ward }}<br>
                                {{ $order->district }}<br>
                                {{ $order->city }}<br>
                                <p>Số điện thoại: <strong>{{ $order->mobile }}</strong></p>
                            </address>
                        </div>
                        <div class="col-6 col-lg-4">
                          <form action="" method="post" name="cancelOrderForm" id="cancelOrderForm">
                                  <!-- Heading -->
                                <h6 class="heading-xxxs text-muted">Hủy đơn hàng:</h6><hr>
                                <!-- Text -->
                                @if ($order->status != 'Hủy đơn')
                                    <button onclick="cancelOrder( {{ $order->id}} )" class="btn bg-danger text-white w-4 h-4 mr-1">
                                        Hủy 
                                    </button>   
                                @else
                                   <span>Bạn đã hủy đơn hàng này vào ngày: {{ \Carbon\Carbon::parse($order->updated_at)->format('d/m/Y') }}</span> --
                                   <span>Thời gian hủy: {{ \Carbon\Carbon::parse($order->updated_at)->format('H:i:s') }}</span><br>
                                @endif                            
                          </form>
                        </div>
                        </div>
                    </div>
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
    //     function cancelOrder(id){
	// 	var url = '{{ route("user.cancelOrder", "ID") }}';
	// 	var newUrl = url.replace("ID", id)

	// 	if(confirm("Bạn có chắc chắn muốn hủy đơn hàng này ?")){
	// 			$.ajax({
	// 			url: newUrl,
	// 			type: 'delete',
	// 			data: {}, 
	// 			dataType: 'json',
	// 			headers: {
	// 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 			},
	// 			success: function(response){
	// 				if(response['status'] == true){
	// 					 window.location.href  = "{{route('user.getOrder')}}";
				
	// 				}else{
	// 					window.location.href  = "{{route('user.getOrder')}}";
	// 				}
	// 			}
	// 		});
	// 	}
	// }
        $("#cancelOrderForm").submit(function(event){
            event.preventDefault();
            if(confirm("Bạn có chắc chắn muốn hủy đơn hàng này ?")){
                $.ajax({
                    url : '{{ route("user.cancelOrder", $order->id) }}',
                    type: 'post',
                    data: {},
                    dataType: 'json',
                    // headers: {
	 				//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 			    // },
                     success: function(response){
                        if(response['status'] == true){
                            window.location.href  = "{{route('user.getOrder')}}";
                    
                        }else{
                            window.location.href  = "{{route('user.getOrder')}}";
                        }
                    }
                });
            }
        });
    </script>
@endsection