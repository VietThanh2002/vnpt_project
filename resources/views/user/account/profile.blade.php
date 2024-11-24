@extends('user.layouts.app')

@section('content')
<section class=" section-11" style="margin-top: 200px; margin-bottom: 30px">
    <div class="container  mt-5">
        <div class="row">
            <div class="col-md-3">
                @include('user.component.sidebar')
            </div>
            <div class="col-md-9">
                @include('user.message')
                <div class="card w-50" style="left: 150px; top: 0px;">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2 text-center">Thông tin cá nhân</h2>
                    </div>
                    <div class="card-body p-4">
                       <form action="" method="post" id="updatepProfileForm" id="updatepProfileForm">
                            <div class="row">
                                <div class="mb-3">               
                                    <label for="name">Tên</label>
                                    <input value="{{ (!empty($user)) ? $user->name : '' }}"  type="text" name="name" id="name" placeholder="Nhập họ và tên" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-3">            
                                    <label for="email">Email</label>
                                    <input value="{{ (!empty($user)) ? $user->email : '' }}"   type="text" name="email" id="email" placeholder="Nhập email" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-3">                                    
                                    <label for="phone">Phone</label>
                                    <input value="{{ (!empty($user)) ? $user->phone_number : '' }}" type="text" name="phone_number" id="phone_number" placeholder="nhập số điện thoại" class="form-control">
                                    <p></p>
                                </div>
                                {{-- <div class="mb-3">                                    
                                    <label for="phone">Address</label>
                                    <textarea value="{{ (!empty($userAddress)) ? $userAddress->city : '' }}" name="address" id="address" class="form-control" cols="30" rows="5" placeholder="Nhập địa chỉ"></textarea>
                                </div> --}}
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
</section>   
@endsection

@section('js')
    <script>
        $("#updatepProfileForm").submit(function(event){
            event.preventDefault();
            var element = $(this);
            $("button[type=submit]").prop('disabled', true); //sử dụng để tắt khả năng kích hoạt nút "submit" trong biểu mẫu (form) sau khi người dùng đã nhấp vào nút "Create".
            $.ajax({

                url: '{{ route("user.updateProfile", $user->id) }}',
                type: 'put',
                data: element.serializeArray(), //chuyển dữ liệu thành 1 đối tượng json và gửi đi
                dataType: 'json',
                success: function(response){

                    $("button[type=submit]").prop('disabled', false);

                    if(response["status"] == true){

                        window.location.href  = "{{route('user.profile')}}";

                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#phone_number').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

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
                    }

                }, error: function(jqXHR, exception){

                    console.log("Xảy ra lỗi!!");
                }
            })
        });

    </script>
@endsection