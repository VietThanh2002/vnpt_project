@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Phí vận chuyển</h1>
        		</div>
        		<div class="col-sm-6 text-right">
        			<a href="{{ route('shipping.create') }}" class="btn btn-primary">Thêm phí vận chuyển</a>
        		</div>
        	</div>
        </div>
        <!-- /.container-fluid -->
	</section>
				<!-- Main content -->
    <section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						<div class="card">
							<form action="" method="get">
								<div class="card-header">
									<div class="float-right">
										<button onclick="window.location.href='{{ route('shipping.index')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
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
											<th>Tên Tỉnh / Thành phố</th>
											<th>Phí vận chuyển</th>
											<th>Thao tác</th>
										</tr>
									</thead>
									<tbody>
                                        @if ($shippings->isNotEmpty())
                                            @foreach ($shippings as $item)
                                                <tr>
                                                    <td>{{ $item->id}}</td>
                                                    <td>{{ $item->city_province}}</td>
                                                    <td data-order="{{ $item->shipping_fee }}">{{ formatPriceVND($item->shipping_fee)}}</td>
                                                    <td>
                                                        <a href="{{ route('shipping.edit', $item->id) }}" class="btn btn-sm">
															<i class='btn-sm bx bxs-edit'></i>
                                                        </a>
                                                        <a href="#" onclick="deleteShipping( {{ $item->id}} )" class="text-danger w-4 h-4 mr-1">
															<i class='btn-sm bx bx-trash-alt'></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        @else
                                            <td colspan="5" class="text-center">Danh sách phí vận chuyển trống!!</td>
                                        @endif
										
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
                                {{ $shippings->links() }}
							</div>
						</div>
					</div>
					<!-- /.card -->
	</section>
				<!-- /.content -->
@endsection

@section('js')
<script>
	function deleteShipping(id){
		var url = '{{ route("shipping.destroy", "ID") }}';
		var newUrl = url.replace("ID", id)

		if(confirm("Bạn có chắc chắn muốn xóa giá vận chuyển này")){
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
						 window.location.href  = "{{route('shipping.index')}}";
				
					}
				}
			});
		}
	}

	$(document).ready( function () {
        $('#myTable').DataTable({
			"paging": false,
			"searching": false,
			"info": true
		});
    });
</script>
@endsection