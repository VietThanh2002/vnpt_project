@extends('admin.layouts.app')

@section('content')
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Danh sách dịch vụ Internet</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('products.create') }}" class="btn btn-primary">Thêm dịch vụ</a>
							</div>
						</div>
					</div>
				</section>
				<section class="content">
					<div class="container-fluid">
						<div class="card">
							{{-- gửi dữ liệu tìm kiếm thông qua URL --}}
							<form action="" method="get">  
								<div class="card-header">
									<div class="float-right">
										<button onclick="window.location.href='{{ route('products.index')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
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
							<div class="m-3 d-flex justify-content-end">
								<div class="w-25">
									@include('admin.message')
								</div>	
							</div>
							<div class="card-body p-2">									
								<table id="myTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>ID</th>
											<th>Hình ảnh</th>
											<th>Tên</th>
											<th>Giá dịch vụ / 1 tháng</th>
											<th>Trạng thái</th>
											<th>Hành động</th>
										</tr>
									</thead>
									<tbody>
                                        @if($products->isNotEmpty())
                                            @foreach ($products as $item)
													@php
														$productImage =  $item->product_images->first(); //load từ model product
													@endphp
                                                    <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>
                                                            @if (!empty($productImage->image))
                                                                <img src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="50"> 
															@else
																<img src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
                                                            @endif
                                                        </td>
                                                        <td style= "width: 200px;">{{ $item->name }}</td>
                                                        <td data-order="{{ $item->price}}">{{  formatPriceVND($item->price) }}</td>								
                                                        <td style="text-align: center;">
                                                            @if (($item->status = 1))
																<div clas="text-center">
																	<i class="fa-regular fa-circle-check btn btn-success btn-sm"></i>
																</div>
															@else
																<p class="text-danger">Ngưng kinh doanh</p>
															@endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('products.edit', $item->id) }}" class="btn btn-sm">
																<i class='btn-sm bx bxs-edit'></i>
                                                            </a>
                                                            <a href="#" onclick="deleteProduct( {{ $item->id}} )" class="text-danger w-4 h-4 mr-1">
																<i class='btn-sm bx bx-trash-alt'></i>
                                                            </a>
                                                        </td>
                                                    </tr>    
                                            @endforeach
                                        @else
                                           <tr>
                                                <td class="text-center" colspan="8">Danh sách sản phẩm trống!</td>
                                           </tr>
                                        @endif
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
								<ul class="pagination pagination m-0 float-right">
                                    {{ $products->links() }}
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

		if(confirm("Bạn có chắc chắn muốn xóa sản phẩm này ?")){
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