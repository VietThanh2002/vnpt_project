@extends('user.layouts.app')

@section('content')
<div class="register-page bg-light"  style="margin-top: 100px">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-sm-12 col-md-8 col-lg-6 d-flex justify-content-center align-items-center bg-white shadow rounded">
                <div class="w-75 pe-0">
                    <div class="h-100 m-5">
                        <h3 class="m-4 text-center">Đăng ký tài khoản</h3>
                            <form action="" method="post" class="row g-4" name="registerForm" id="registerForm">
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class='bx bxs-user'></i></div>
                                        <input type="text" name="name" id="name" class="form-control rounded-1" placeholder="Nhập họ và tên">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fa-solid fa-square-envelope"></i></div>
                                        <input type="text" name="email" id="email" class="form-control rounded-1" placeholder="Nhập email">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fa-solid fa-phone"></i></div>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control rounded-1" placeholder="Số điện thoại">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class='bx bxs-lock-alt' ></i></div>
                                        <input type="password" name="password" id="password"  class="form-control rounded-1" placeholder="Nhập mật khẩu">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class='bx bxs-lock-alt' ></i></div>
                                        <input type="password" name="password_confirmation"  id="password_confirmation" class="form-control rounded-1" placeholder="Xác nhận mật khẩu">
                                        <p></p>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" name="btn_submit" class="btn btn-primary px-4 mt-4">Đăng ký</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
@endsection

@section('js')
    <script type="text/javascript">

        $("#registerForm").submit(function (event) {
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '{{ route("account.processRegister") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    $("button[type=submit]").prop('disabled', false);
                    if(response["status"] == true){

                       
                        $('#name').addClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#phone_number').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#password_confirmation').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

            
                        window.location.href = "{{ route('user.login') }}";


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

                        if(errors['phone_number']){
                            $('#phone_number').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['phone_number']);
                        }else{
                            $('#phone_number').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if(errors['password']){
                            $('#password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password']);
                        }else{
                            $('#password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if(errors['password_confirmation']){
                            $('#password_confirmation').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['password_confirmation']);
                        }else{
                            $('#password_confirmation').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }

            },
                error: function (jQHR, execption) {
                    consolog.log('Xảy ra lỗi');
                }
            });
        });
    </script>

@endsection