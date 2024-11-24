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
                        <h3 class="mb-1 text-center">Đăng nhập</h3>
                        <form action="{{ route('user.authenticate') }}" method="post" class="row g-4">
                            @csrf
                            <div class="col-12">
                                <label>Email<span class="text-danger m-1"></span></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="fa-solid fa-square-envelope"></i></div>
                                    <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Tên đăng nhập">
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                              {{-- $message được lấy từ session và chứa thông báo lỗi hoặc thông báo thành công để hiển thị cho người dùng. --}}
                            <div class="col-12">
                                <label>Mật khẩu<span class="text-danger m-1"></span></label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class='bx bxs-lock-alt' ></i></div>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu">
                                    @error('password')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Ghi nhớ tôi</label>
                                </div>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <a href="{{ route('user.forgotPassword') }}" class="float-end text-primary">Quên mật khẩu</a>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary px-4 mt-4">Đăng nhập</button>
                            </div>
                                </form>
                                <p class="text-center m-2">Bạn chưa có tài khoản? <a href="{{ route('user.register') }}">Đăng ký ngay</a></p>
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