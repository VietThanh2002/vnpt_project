@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Danh sách khách hàng</h1>
        		</div>
        		{{-- <div class="col-sm-6 text-right">
        			<a href="{{ route('categories.create') }}" class="btn btn-primary">New Category</a>
        		</div> --}}
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
										<button onclick="window.location.href='{{ route('users.index')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
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
											<th>Tên</th>
											<th>Email</th>
											<th>Số điện thoại</th>
										</tr>
									</thead>
									<tbody>
                                        @if ($users->isNotEmpty())
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id}}</td>
                                                    <td>{{ $user->name}}</td>
													<td>{{ $user->email}}</td>
													<td>{{ $user->phone_number}}</td>
                                                </tr>
                                            @endforeach
                                            
                                        @else
                                            <td colspan="5" class="text-center">Danh mục sản phẩm trống!!</td>
                                        @endif
										
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
                                {{ $users->links() }}
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