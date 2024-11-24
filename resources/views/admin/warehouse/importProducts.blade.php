@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Nhập kho</h1>
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
										<button onclick="window.location.href='{{ route('warehouse.import')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
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
										<tr >
											<th>Mã SP</th>
											<th>Tên sản phẩm</th>
											<th>Số lượng nhập</th>
											<th>Số lượng còn lại</th>
											<th>Đã bán</th>
                                            <th>Ngày nhập</th>
											<th style="text-align: center;">Trạng thái</th>
										</tr>
									</thead>
									<tbody>
                                        @if ($products->isNotEmpty())
                                            @foreach ($products as $item)
                                                <tr>
                                                    <td>{{ $item->id}}</td>
                                                    <td>{{ $item->name}}</td>
													<td>{{ $item->import_qty}}</td>
													<td>{{ $item->qty}}</td>
													<td>{{   ($item->import_qty) -  ($item->qty) }}</td>
                                                    <td> {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y')}}</td>
                                                    <td style="text-align: center;">
                                                        @if (($item->status == 1) and ($item->qty > 0))
                                                            <div clas="text-center">
                                                                <i class="fa-solid fa-square-check text-success h-6 w-6 "></i>
                                                            </div>
                                                        @else
                                                              <p class="text-danger">Hết hàng</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            
                                        @else
                                            <td colspan="5" class="text-center">Danh mục sản phẩm trống!!</td>
                                        @endif
										
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
                                {{ $products->links() }}
							</div>
						</div>
					</div>
					<!-- /.card -->
	</section>
				<!-- /.content -->
@endsection

@section('js')
<script>
	function deleteCategory(id){
		var url = '{{ route("categories.destroy", "ID") }}';
		var newUrl = url.replace("ID", id)

		if(confirm("Bạn có chắc chắn muốn xóa sản phẩm này")){
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
						 window.location.href  = "{{route('categories.index')}}";
				
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