@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">	
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
                <h1>Tạo phiếu giảm giá</h1>
			</div>
			<div class="col-sm-6 text-right">
                <a href="{{route('discount.index')}}" class="btn btn-primary">Trở về</a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<form action="" id="discountForm" id="discountForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Mã giảm giá</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="Nhập mã giảm giá">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Tên mã giảm giá</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Tên mã giảm giá">	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Mô tả</label>
                                <input type="text" name="des" id="des" class="form-control" placeholder="Mô tả">	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Số lần sử dụng mã</label>
                                <input type="text" name="des" id="des" class="form-control" placeholder="Nhập số lần sử dụng">	
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Số lần khách hàng có thể sử dụng</label>
                                <input type="text" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Nhập số lần sử dụng">	
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Kiểu mã giảm giá</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="percent">Giảm theo phần trăm</option>
                                    <option value="fixed">Giảm mặc định</option>
                                </select>
                                
                            </div>
                        </div>

                        
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Số tiền giảm giá</label>
                                <input type="text" name="discount_amount" id="discount_amount" class="form-control" placeholder="Nhập số tiền">	
                                <p></p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Giá sản phẩm tối thiểu có thể giảm</label>
                                <input type="text" name="min_amount" id="min_amount" class="form-control" placeholder="Nhập số tiền">	
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Ngày bắt đầu</label>
                                <input type="datetime-local" name="start_day" id="start_day" class="form-control">
                                <p></p>	
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code">Ngày kết thúc</label>
                                <input type="datetime-local" name="end_day" id="end_day" class="form-control">	
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Trạng thái</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Action</option>
                                    <option value="0">Block</option>
                                </select>
                                
                            </div>
                        </div>      
                    </div>
                </div>			
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Tạo</button>
                <a href="{{route('discount.index')}}" class="btn btn-outline-dark ml-3">Trở về</a>
            </div>
        </form>
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('js')
<script>

    $("#discountForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true); //sử dụng để tắt khả năng kích hoạt nút "submit" trong biểu mẫu (form) sau khi người dùng đã nhấp vào nút "Create".
        $.ajax({

            url: '{{ route("discount.store") }}',
            type: 'post',
            data: element.serializeArray(), //chuyển dữ liệu thành 1 đối tượng json và gửi đi
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){

                    window.location.href  = "{{route('discount.index')}}";

                    $('#code').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#discount_amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#start_day').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#end_day').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    
                }else{
                    var errors = response['errors'];

                    if(errors['code']){
                        $('#code').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['code']);
                    }else{
                        $('#code').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['discount_amount']){
                        $('#discount_amount').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['discount_amount']);
                    }else{
                        $('#discount_amount').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['start_day']){
                        $('#start_day').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['start_day']);
                    }else{
                        $('#start_day').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['end_day']){
                        $('#end_day').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['end_day']);
                    }else{
                        $('#end_day').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    

                }

            }, error: function(jqXHR, exception){

                console.log("Xảy ra lỗi!!");
            }
        })
    });

</script>
@endsection