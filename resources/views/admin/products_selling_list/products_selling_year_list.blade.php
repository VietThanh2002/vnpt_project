@extends('admin.layouts.app')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">					
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h5 class="fw-bold">Sản phẩm bán trong năm</h1>
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
							<div class="card-body p-3">								
								<table id="myTable" class="table table-bordered table-hover">
									<thead>
										<tr class="text-center">
											<th>Mã SP</th>
											<th>Tên sản phẩm</th>
											<th>Số lượng bán ra</th>
											<th>Giá bán</th>
											<th>Tổng</th>
										</tr>
									</thead>
									<tbody>
                                        @if (!empty($SellingProductsYear))
                                            @foreach ($SellingProductsYear as $item)
                                                <tr>
                                                    <td>{{ $item->product_id}}</td>
                                                    <td>{{ $item->name}}</td>
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
                                {{$SellingProductsYear->links()}}
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
			"info": false,
            "language": {
                "search": "Tìm kiếm:",
            },
		});
    });

</script>
@endsection