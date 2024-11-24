@extends('user.layouts.app')

@section('content')
<section class="contact" id="contact">
    <div class="container">
        <div class="heading text-center m-4 p-4">
            <h2 class="bd-title d-flex justify-content-center mt-4">LIÊN HỆ VỚI CHÚNG TÔI</h2>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="title">
                    <h3>Thông tin liên hệ</h3>
                 
                </div>
                <div class="content">
                    <!-- Info-1 -->
                    <div class="info">
                        <i class="fas fa-mobile-alt"></i>
                        <h4 class="d-inline-block">PHONE :
                            <br>
                            <span>0767957642 , 0916657222</span></h4>
                    </div>
                    <!-- Info-2 -->
                    <div class="info">
                        <i class="far fa-envelope"></i>
                        <h4 class="d-inline-block">EMAIL :
                            <br>
                            <span>thanhb2014610@gmail.com</span></h4>
                    </div>
                    <!-- Info-3 -->
                    <div class="info">
                        <i class="fas fa-map-marker-alt"></i>
                        <h4 class="d-inline-block">Địa chỉ :<br>
                            <span>642/2 Tân Mỹ, Lai Vung, Đồng Tháp</span></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                @include('user.message')
                <form method="post" id="contactForm"  name="contactForm">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Họ và tên">
                            <p></p>
                        </div>
                        <div class="col-sm-6">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            <p></p>
                        </div>
                        <div class="col-sm-12">
                            <input type="text" name="subject"  id="subject" class="form-control" placeholder="Chủ đề">
                            <p></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="5" name="content" id="content" placeholder="Nội dung bạn cần hỏi đáp"></textarea>
                        <p></p>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-block" type="submit">Gửi ngay!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
    <script>
        $('#contactForm').submit(function(event){
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("user.sendContactEmail") }}',
                type: 'post',
                data: $(this).serializeArray(),
                dataType: 'json',
                success: function(response){
                    if(response.status == true){
                        $("button[type=submit]").prop('disabled', false);

                        $('#user_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#subject').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#content').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                        window.location.href = '{{ route("user.contact")}}'
                    }else{
                        var errors = response['errors'];

                        if(errors['user_name']){
                            $('#user_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['user_name']);
                        }else{
                            $('#user_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if(errors['email']){
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                        }else{
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if(errors['subject']){
                            $('#subject').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['subject']);
                        }else{
                            $('#subject').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                        if(errors['content']){
                            $('#content').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['content']);
                        }else{
                            $('#content').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }
                }
            });
        });
    </script>
@endsection