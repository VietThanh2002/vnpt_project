@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Nhân viên</h1>
        		</div>
        		<div class="col-sm-6 text-right">
        			<a href="{{ route('staffs.create') }}" class="btn btn-primary">Thêm nhân viên</a>
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
										<button onclick="window.location.href='{{ route('staffs.index')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
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
											<th>Mã NV</th>
											<th>Tên nhân viên</th>
											<th>Thông tin liên lạc</th>
											<th>Quên quán</th>
                                            <th>Chức vụ</th>
											<th>Thao tác</th>
										</tr>
									</thead>
									<tbody>
										@if ($staffs->isNotEmpty())
											@foreach ($staffs as $staff)
											<tr>
												<td>{{ $staff->id}}</td>
												<td>{{ $staff->name}}</td>
												<td>{{ $staff->email}}<br>{{ $staff->mobile}}</td>
												<td>{{ $staff->address}}-{{ $staff->ward}}-{{ $staff->district}}-{{ $staff->city}}</td>
												<td>{{ $staff->position}}</td>
												<td>
													<a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-sm">
														<i class='btn-sm bx bxs-edit'></i>
													</a>
													<a href="#" onclick="deleteStaff( {{ $staff->id}} )" class="text-danger w-4 h-4 mr-1">
														<i class='btn-sm bx bx-trash-alt'></i>
													</a>
												</td>
											</tr>
											@endforeach
										@else
											<td colspan="6" class="text-center">Rỗng</td>
										@endif
										
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
                              
							</div>
						</div>
					</div>
					<!-- /.card -->
	</section>
				<!-- /.content -->
@endsection

@section('js')
<script>

	function deleteStaff(id){
			if(confirm("Bạn có chắc chắn xóa nhân viên này ?")){

				var url = '{{ route("staffs.destroy", "staffId") }}';
				var newUrl = url.replace("staffId", id)

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
							window.location.href  = "{{route('staffs.index')}}";
					
						}else{
							window.location.href  = "{{route('staffs.index')}}";
						}
					}
				});
			}
		}

</script>
@endsection