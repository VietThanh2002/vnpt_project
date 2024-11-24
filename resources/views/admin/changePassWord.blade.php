@extends('admin.layouts.app')

@section('content')
<section class="" >
    <div class="card w-50 shadow" style="top: 50px; left: 340px;">
        <div class="card-header text-center">
            <div class="m-3 d-flex justify-content-end">
                <div class="w-25">
                    @include('admin.message')
                </div>	
            </div>
        </div>
        <div class="card-header text-center">
            <h3 class="mb-0">Thay đổi mật khẩu</h3>
        </div>
        <div class="card-body">
            <form method="post" id="changePassWordForm" name="changePassWordForm">
                <div class="form-group">
                    <label for="old_password">Mật khẩu hiện tại</label>
                    <input type="password" name="old_password" id="old_password" class="form-control">
                    <p></p>
                </div>
                <div class="form-group">
                    <label for="new_password">Mật khẩu mới</label>
                    <input type="password" name="new_password" id="new_password" class="form-control">
                    <p></p>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Nhập lại mật khẩu</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                    <p></p>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-sm ">Cập nhật</button>
                    <a class="btn btn-secondary btn-sm" href="{{ route('admin.dashboard')}}">Trở về</a>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- /form card change password -->
@endsection

@section('js')
    <script>
        $("#changePassWordForm").submit(function(event){
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("admin.changePassWord") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                        $("button[type=submit]").prop('disabled', false);
                        if(response["status"] == true){
                             window.location.href = "{{ route('admin.changePassWord') }}";
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