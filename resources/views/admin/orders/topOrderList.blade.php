@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Khách hàng thân thiết</h1>
        		</div>
        		<div class="col-sm-6 text-right">
        			<a href="{{ route('categories.create') }}" class="btn btn-primary">Trở về</a>
        		</div>
        	</div>
        </div>
        <!-- /.container-fluid -->
	</section>
				<!-- Main content -->
    <section class="content">
					<!-- Default box -->
					<div class="container-fluid">
						@include('admin.message')
						<div class="card">
							<div class="card-body p-0">								
								<table id="myTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th width="60">ID</th>
											<th>Tên</th>
											<th>Email</th>
											<th>Số điện thoại</th>
                                            <th>Số đơn hàng</th>
										</tr>
									</thead>
									<tbody>
                                        @if ($usersVip->isNotEmpty())
                                            @foreach ($usersVip as $user)
                                                <tr>
                                                    <td>{{ $user->id}}</td>
                                                    <td>{{ $user->name}}</td>
													<td>{{ $user->email}}</td>
													<td>{{ $user->phone_number}}</td>
                                                    <td>{{ $user->order_count}}</td>
                                                </tr>
                                            @endforeach
                                            
                                        @else
                                            <td colspan="5" class="text-center">Danh mục sản phẩm trống!!</td>
                                        @endif
										
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
                                {{ $usersVip->links() }}
							</div>
						</div>
					</div>
					<!-- /.card -->
	</section>
				<!-- /.content -->
@endsection

@section('js')
<script>

	$(document).ready( function () {
        $('#myTable').DataTable({
			"paging": false,
			"searching": false,
			"info": false
		});
    });
</script>
@endsection