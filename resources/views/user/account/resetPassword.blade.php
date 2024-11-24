@extends('user.layouts.app')

@section('content')
<div class="login-page bg-light" style="margin-top: 100px">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-sm-12 col-md-8 col-lg-6 d-flex justify-content-center align-items-center bg-white shadow rounded">
                <div class="w-75 pe-0">
                    <div class="h-100 m-5">
                       <div class="d-flex justify-content-center">
                            @include('user.message')
                       </div>
                            <h3 class="mt-3 text-center">Đặt lại mật khẩu</h3>
                                <form action="{{ route('user.processResetPassword') }}" method="post" class="row g-4">
                                    @csrf
                                        <input type="text" name="token" value="{{ $token }}">
                                        <div class="col-12">
                                            <label>Mật khẩu<span class="text-danger m-1">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class='bx bxs-user'></i></div>
                                                <input type="password" name="new_password" class="form-control  @error('new_password') is-invalid @enderror" placeholder="Nhập mật khẩu mới">
                                                @error('new_password')
                                                    <p class="invalid-feedback">{{ $message}}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Nhập lại mật khẩu<span class="text-danger m-1">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class='bx bxs-user'></i></div>
                                                <input type="password" name="confirm_password" class="form-control  @error('confirm_password') is-invalid @enderror" placeholder="Nhập lại mật khẩu">
                                                @error('confirm_password')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">
                                            <input type="submit" class="btn btn-primary px-4 mt-4" value="Cập nhật">
                                        </div>
                                </form>
                                <p class="text-center m-2"><a href="{{ route('user.login') }}">Đăng nhập</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
@endsection

@section('js')
    
@endsection