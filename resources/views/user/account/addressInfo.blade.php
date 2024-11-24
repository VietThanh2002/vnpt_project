@extends('user.layouts.app')

@section('content')

<section class="section-11" style="margin-top: 200px; margin-bottom: 30px">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @include('user.component.sidebar')
            </div>
            <div class="col-md-9">
                @include('user.message')
                <div class="card" style="left: 50px; top: 0px;">
                    <div class="card-body p-4">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2 text-center">Thông tin nhận hàng</h2>
                        </div>
                        <div class="card-body p-4">
                        <form action="" method="post" id="updateAddressForm" name="updateAddressForm">
                                <div class="row">
                                    <div class="mb-3">               
                                        <label for="name">Tên</label>
                                        <input value="{{ (!empty($userAddress)) ? $userAddress->name : '' }}"  type="text" name="name" id="name" placeholder="Nhập họ và tên" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">            
                                        <label for="email">Email</label>
                                        <input value="{{ (!empty($userAddress)) ? $userAddress->email : '' }}"   type="text" name="email" id="email" placeholder="Nhập email" class="form-control">
                                        <p></p>
                                    </div>
                                    <div class="mb-3">                                    
                                        <label for="phone">Số điện thoại</label>
                                        <input value="{{ (!empty($userAddress)) ? $userAddress->mobile : '' }}" type="text" name="mobile" id="mobile" placeholder="nhập số điện thoại" class="form-control">
                                        <p></p>
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
                                    <hr>
                                    <div class="col-md-4 col-lg-12">
                                        <div class="m-2 p-1">
                                                <p>Thông tin địa chỉ nhận hàng hiện tại:
                                                    @if((!empty($userAddress)))
                                                       <strong> <span>{{$userAddress->ward}}</span>-<span>{{$userAddress->district}}</span>-<span>{{$userAddress->city}}</span></strong>
                                                    @else
                                                        <span class="text-center fw-bold">Bạn chưa có địa chỉ nhận hàng</span>
                                                    @endif
                                                </p>
                                        </div>
                                    </div>

                                    <div class="mb-3">                                    
                                        <label for="phone">Địa chỉ</label>
                                        <textarea name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Nhập địa chỉ">{{ !empty($userAddress->address) ? ($userAddress->address) : null  }}</textarea>
                                        <p></p>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section('js')
    <script>
        $("#updateAddressForm").submit(function(event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true); //sử dụng để tắt khả năng kích hoạt nút "submit" trong biểu mẫu (form) sau khi người dùng đã nhấp vào nút "Create".
    
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

                url: '{{ route("user.updateUserAddress") }}',
                type: 'put',
                data: formData, //chuyển dữ liệu thành 1 đối tượng json và gửi đi
                dataType: 'json',
                success: function(response){
                    $("#button[type=submit]").prop('disabled', false);
                    if(response["status"] == true){

                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#city').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#district').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#ward').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                        window.location.href = "{{ route('user.addressInfo') }}";
    
                    }else{
                        var errors = response['errors'];

                        if(errors['name']){
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        }else{
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if(errors['email']){
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                        }else{
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
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

                        if(errors['address']){
                            $('#address').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['address']);
                        }else{
                            $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if(errors['mobile']){
                            $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['mobile']);
                        }else{
                            $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }

            },
                error: function (jQHR, execption) {
                    consolog.log('Xảy ra lỗi');
                }
            })
        });
    </script>
@endsection