@extends('user.layouts.app')

@section('content')

<section class="section-11" style="margin-top: 200px; margin-bottom: 30px;">
    <div class="container  mt-5">
        <div class="row gx-5">
            <div class="col-md-3">
                @include('user.component.sidebar')
            </div>
            <div class="col-md-9">
                @include('user.message')
                <div class="card w-50" style="left: 150px; top: 0px;">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2 text-center">Thay đổi mật khẩu</h2>
                    </div>
                    <form action="" method="post" id="changePassWordForm">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="mb-3">               
                                    <label for="name">Mật khẩu cũ</label>
                                    <input type="password" name="old_password" id="old_password" placeholder="Nhập mật khẩu cũ" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-3">               
                                    <label for="name">Mật khẩu mới</label>
                                    <input type="password" name="new_password" id="new_password" placeholder="Nhập mật khẩu mới" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-3">               
                                    <label for="name">Nhập lại mật khẩu</label>
                                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Nhập lại mật khẩu" class="form-control">
                                    <p></p>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>   
@endsection

@section('js')
    <script>
        $("#changePassWordForm").submit(function(event){
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("user.changePassWord") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                        $("button[type=submit]").prop('disabled', false);
                        if(response["status"] == true){
                             window.location.href = "{{ route('user.changePassWordForm') }}";
                            $('#old_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                            $('#new_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                            $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');


                        }else{
                            var errors = response['errors'];

                            if(errors['old_password']){
                                $('#old_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['old_password']);
                            }else{
                                $('#old_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                            }

                            if(errors['new_password']){
                                $('#new_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['new_password']);
                            }else{
                                $('#new_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                            }

                            if(errors['confirm_password']){
                                $('#confirm_password').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['confirm_password']);
                            }else{
                                $('#confirm_password').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
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