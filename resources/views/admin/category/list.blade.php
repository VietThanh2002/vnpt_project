@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Danh mục</h1>
        		</div>
        		<div class="col-sm-6 text-right">
        			<a href="{{ route('categories.create') }}" class="btn btn-primary">Thêm danh mục</a>
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
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary"></h6>
							</div>
							<form action="" method="get">
								<div class="card-header">
									<div class="float-right">
										<button onclick="window.location.href='{{ route('categories.index')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
									</div>
									<div class="card-tools float-left">
										<div class="input-group input-group" style="width: 250px;">
											<input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control" placeholder="Tìm kiếm">
						
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
											<th>Tên danh mục</th>
											<th>Tên không dấu</th>
											<th>Trạng thái</th>
											<th>Hành động</th>
										</tr>
									</thead>
									<tbody>
                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $item)
                                                <tr>
                                                    <td>{{ $item->id}}</td>
                                                    <td>{{ $item->name}}</td>
                                                    <td>{{ $item->slug}}</td>
													<td style="text-align: center;">
                                                        @if ($item->status==1)
															<div clas="text-center">
																<i class="fa-regular fa-circle-check btn btn-success btn-sm"></i>
															</div>
                                                        @else
															<div class="">
																<i class="fa-solid fa-circle-xmark text-danger h-6 w-6 rounded-circle"></i>
															</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('categories.edit', $item->id) }}" class="btn btn-sm">
															<i class='btn-sm bx bxs-edit'></i>
                                                        </a>
                                                        <a href="#" onclick="deleteCategory( {{ $item->id}} )" class="text-danger w-4 h-4 mr-1">
															<i class='btn-sm bx bx-trash-alt'></i>
                                                        </a>
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
                                {{ $categories->links() }}
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