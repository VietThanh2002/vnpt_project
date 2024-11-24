@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">	
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
                <h1>Cập nhật thông tin nhân viên</h1>
			</div>
			<div class="col-sm-6 text-right">
                <a href="{{ route('staffs.index')}}" class="btn btn-primary"><i class='bx bx-arrow-back'></i></a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<form action="" id="StaffsUpdateForm" id="StaffsUpdateForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Tên nhân viên</label>
                                <input value="{{$staff->name}}" type="text" name="name" id="name" class="form-control" placeholder="Nhập tên nhân viên">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input value="{{$staff->email}}" type="text" name="email" id="email" class="form-control" placeholder="Nhập email">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="login_name">Tên đăng nhập</label>
                                <input value="{{$staff->login_name}}" type="text" name="login_name" id="login_name" class="form-control" placeholder="Tên đăng nhập">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email">Mật khẩu</label>
                                <input value="" type="text" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 form-group">
                            <label for="Province">Tỉnh/Thành Phố</label>
                            <select id="Province" class="form-control"></select>
                            <p></p>       
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="District">Quận/Huyện</label>
                            <select  id="District"  class="form-control"></select>
                            <p></p>       
                        </div>

                        <div class="col-md-4 col-sm-12">
                            <label for="Ward">Xã/Phường</label>
                            <select id="Ward"  class="form-control"></select>
                            <p></p>       
                        </div>
                        <div class="col-md-4 col-lg-12">
                            <div class="m-2 p-1">
                                    <p>Thông tin địa chỉ:
                                        @if((!empty($staff)))
                                           <strong> <span>{{$staff->ward}}</span>-<span>{{$staff->district}}</span>-<span>{{$staff->city}}</span></strong>
                                        @else
                                            <span class="text-center fw-bold">Bạn chưa có địa chỉ nhận hàng</span>
                                        @endif
                                    </p>
                            </div>
                        </div>
                        <div class="col-md-6">                                    
                            <label for="address">Địa chỉ</label>
                            <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Nhập địa chỉ">{{$staff->address}}</textarea>
                            <p></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address">Số điện thoại</label>
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Số điện thoại" value="{{ (!empty($staff)) ? $staff->mobile : '' }}">
                                <p></p>
                            </div>            
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position">Vị trí</label>
                                <select name="position" id="position" class="form-control">
                                    <option {{ ($staff->position == 'Nhân viên bán hàng') ? 'selected' : ''}} value="Nhân viên bán hàng">Nhân viên giao hàng</option>
                                    <option {{ ($staff->status == 'Nhân viên giao hàng') ? 'selected' : ''}} value="Nhân viên giao hàng">Nhân viên bán hàng</option>
                                </select>                                
                            </div>
                        </div>      
                    </div>
                </div>			
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('staffs.index')}}" class="btn btn-outline-dark ml-3">Trở về</a>
            </div>
        </form>
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('js')
<script>

    $("#StaffsUpdateForm").submit(function(event){
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);

            // Lấy giá trị tên của tỉnh/thành phố, quận/huyện, và xã/phường
            var cityName = $('#Province').find("option:selected").text();
            var districtName = $('#District').find("option:selected").text();
            var wardName = $('#Ward').find("option:selected").text();

            // Tạo một đối tượng dữ liệu để gửi lên server
            var formData = $(this).serializeArray();
            // Thêm giá trị tên của tỉnh/thành phố, quận/huyện, và xã/phường vào đối tượng dữ liệu
            formData.push({ name: "city", value: cityName });
            formData.push({ name: "district", value: districtName });
            formData.push({ name: "ward", value: wardName });

        $.ajax({

            url: '{{ route("staffs.update", $staff->id) }}',
            type: 'put',
            data: formData, //chuyển dữ liệu thành 1 đối tượng json và gửi đi
            dataType: 'json',
            success: function(response){
                if(response["status"] == true){

                      // $("button[type=submit]").prop('disabled', false);
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#login_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#positon').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#city').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#district').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#ward').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                        window.location.href  = "{{route('staffs.index')}}";
                }else{
                    var errors = response['errors'];

                        $("button[type=submit]").prop('disabled', false);

                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['email']) {
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['login_name']) {
                            $('#login_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['login_name']);
                        } else {
                            $('#login_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['password']) {
                            $('#password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password']);
                        } else {
                            $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['position']) {
                            $('#position').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['position']);
                        } else {
                            $('#position').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['city']) {
                            $('#Province').addClass('is-invalid'); // Thêm class 'is-invalid' vào thẻ select
                            $('#Province').siblings('p').addClass('invalid-feedback').html(errors['city']);
                        } else {
                            $('#Province').removeClass('is-invalid');
                            $('#Province').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['district']) {
                            $('#District').addClass('is-invalid');
                            $('#District').siblings('p').addClass('invalid-feedback').html(errors['district']);
                        } else {
                            $('#District').removeClass('is-invalid');
                            $('#District').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['ward']) {
                            $('#Ward').addClass('is-invalid');
                            $('#Ward').siblings('p').addClass('invalid-feedback').html(errors['ward']);
                        } else {
                            $('#Ward').removeClass('is-invalid');
                            $('#Ward').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['address']) {
                            $('#address').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['address']);
                        } else {
                            $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['mobile']) {
                            $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['mobile']);
                        } else {
                            $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }
                },
                error: function (jQHR, exception) {
                    console.log('Xảy ra lỗi');
                }
            });
        });

</script>
@endsection