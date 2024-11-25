@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Sản phẩm bán trong quý 1 năm <?= date('Y'); ?></h1>
        		</div>
        		<div class="col-sm-6 text-right">
        			<a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Trở về</a>
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
							{{-- <form action="" method="get">
								<div class="card-header">
									<div class="float-right">
										<button onclick="window.location.href='{{ route('admin.dashboard')}}'" type="button" class="btn btn-sm btn-default"><i class='bx bx-refresh'></i></button>
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
							</form> --}}
							<div class="card-body p-0">								
								<table id="myTable" class="table table-bordered table-hover">
									<thead>
										<tr class="text-center">
											<th width="10%">Mã SP</th>
											<th width="30%">Tên sản phẩm</th>
											<th width="20%">Số lượng bán ra</th>
											<th with="20%">Giá bán</th>
											<th with="20%">Tổng</th>
										</tr>
									</thead>
									<tbody>
                                        @if (!empty($SellingProductsQuarter1))
                                            @foreach ($SellingProductsQuarter1 as $item)
												<tr>
													<td>{{ $item->product_id}}</td>
													@if ($item->name == null)
														<td>{{ $item->sim_number}}</td>
													@else
														<td>{{ $item->name}}</td>
													@endif
													<td>{{ $item->total_qty}}</td> 
													<td>{{formatPriceVND($item->price)}}</td> 
													<td>{{ formatPriceVND(($item->price)*($item->total_qty)) }}</td> 
												</tr>
                                            @endforeach
                                            
                                        @else
                                            <td colspan="5" class="text-center">Danh mục sản phẩm trống!!</td>
                                        @endif
										
									</tbody>
								</table>										
							</div>
							<div class="card-footer clearfix">
								{{$SellingProductsQuarter1->links()}}
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