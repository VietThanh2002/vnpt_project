@extends('admin.layouts.app')

@section('content')
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Đánh giá sản phẩm</h1>
							</div>
						</div>
					</div>
				</section>
				<section class="content">
					<div class="container-fluid">
						@include('admin.message')
						<div class="card">
							<form action="" method="get">
								<div class="card-header">
									<div class="float-right">
										<button onclick="window.location.href='{{ route('products.productRating')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
									</div>
									<div class="card-tools float-left">
										<div class="input-group input-group" style="width: 250px;">
											<input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control" placeholder="Search">
						
											<div class="input-group-append">
											<button type="submit" class="btn btn-default">
												<i class="fas fa-search"></i>
											</button>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="card-body p-0">								
								<table id="myTable" class="table table-hover text-nowrap">
									<thead>
										<tr>
											<th width="60">ID</th>
											<th width="80">Tên sản phẩm</th>
											<th>Tên khách hàng</th>
											<th>Email</th>
											<th>Nội dung đánh giá</th>
											<th width="100">Duyệt</th>
										</tr>
									</thead>
									<tbody>
                                        @if($ratings->isNotEmpty())
                                            @foreach ($ratings as $rating)
                                            {{-- @php
                                                $productImage =  $rating->product_images->first(); //load từ model product
                                            @endphp --}}
                                                    <tr>
                                                        <td>{{ $rating->id }}</td>
                                                        {{-- <td>
                                                            @if (!empty($productImage->image))
                                                                <img src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="50"> 
															@else
																<img src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
                                                            @endif
                                                        </td> --}}
                                                        <td>{{ $rating->productName }}</td>
														<td>{{ $rating->user_name }}</td>	
                                                        <td>{{ $rating->email }}</td>
                                                        <td>{{ $rating->comment }}</td>										
                                                        <td style="text-align: center;">
                                                            @if ($rating->status == 1)
                                                                <a href="javascript:void(0);" onclick="changeStatus(0, '{{ $rating->id}}');">
                                                                    <div clas="text-center">
                                                                        <i class="fa-solid fa-square-check text-success h-6 w-6 "></i>
                                                                    </div>
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0);" onclick="changeStatus(0, '{{ $rating->id}}');">
                                                                    <div class="">
                                                                        <i class="fa-solid fa-square-xmark text-danger h-6 w-6"></i>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>    
                                            @endforeach
                                        @else
                                           <tr>
                                                <td colspan="8">Không có đánh giá sản phẩm nào!</td>
                                           </tr>
                                        @endif
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
								<ul class="pagination pagination m-0 float-right">
                                    {{ $ratings->links() }}
								</ul>
							</div>
						</div>
					</div>
				</section>
@endsection

@section('js')
<script>
	function deleteProduct(id){
		var url = '{{ route("products.destroy", "ID") }}';
		var newUrl = url.replace("ID", id)

		if(confirm("Bạn có chắc chắn muốn xóa dịch vụ này")){
				$.ajax({
				url: newUrl,
				type: 'delete',
				data: {}, 
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response){
					if(response['status'] == true){
						 window.location.href  = "{{route('products.index')}}";
				
					}else{
						window.location.href  = "{{route('products.index')}}";
					}
				}
			});
		}
	};

    function changeStatus(status, id){
        if(confirm("Bạn có chắc chắn muốn ẩn bình luận này !")){
				$.ajax({
				url: '{{ route("products.changeRatingStatus") }}',
				type: 'post',
				data: {status:status, id:id}, 
				dataType: 'json',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: function(response){
					if(response['status'] == true){
						 window.location.href  = "{{route('products.productRating')}}";
				
					}else{
						window.location.href  = "{{route('products.productRating')}}";
					}
				}
			});
		}
    }
	$(document).ready( function () {
        $('#myTable').DataTable({
			"paging": false,
			"searching": false,
			"info": false
		});
    });

</script>
@endsection