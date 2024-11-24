@extends('user.layouts.app')

@section('content')
<div class="login-page bg-light" style="margin-top: 20px">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-sm-12 col-md-8 col-lg-6 d-flex justify-content-center align-items-center bg-white shadow rounded">
                <div class="w-75 pe-0">
                    <div class="h-100 m-5">
                        <div class="d-flex justify-content-center">
                            @include('user.message')
                        </div>
                        <h3 class="mb-1 text-center">Lấy lại mật khẩu</h3>
                            <form action="{{ route('user.executeResetPassword') }}" method="post" class="row">
                                @csrf
                                    <div class="col-12">
                                        <label>Email<span class="text-danger m-1"></span></label>
                                        <div class="input-group">
                                            <div class="input-group-text"><i class="fa-solid fa-square-envelope"></i></div>
                                            <input type="text" name="email"  value="{{ old('email') }}" class="form-control  @error('email') is-invalid @enderror" placeholder="Nhập email">
                                            @error('email')
                                                <p class="invalid-feedback">{{ $message}}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <input type="submit" class="btn btn-primary px-4 mt-4" value="Gửi">
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
</div>   
@endsection

@section('js')
    
@endsection