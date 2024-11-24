<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
		<link rel="stylesheet" href="{{asset ('admin-assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset ('admin-assets/css/adminlte.min.css')}}">
    <title>Đăng nhập</title>
</head>
<body>
	<body class="hold-transition login-page" style="background-color: rgb(192, 129, 29)">
		<div class="login-box">
        @include('staff.message')
        <div class="card card-outline card-primary">
              <div class="m-2 p-2 card-header text-center bg-white rounded-3">
                <p class="h3">Đăng nhập</p>
              </div>
              <div class="card-body">
                <form action="{{ route('staff.authenticate')}}" method="post">
                    @csrf
                      <div class="input-group flex-nowrap">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-square-envelope"></i></span>
                        <input type="text" value="" name="login_name" id="login_name" class="form-control   @error('login_name') is-invalid @enderror"  placeholder="Tên đăng nhập">
                      </div>
                      @error('login_name')
                          <p class="invaild-feedback text-red">{{ $message}}</p>
                      @enderror
                    <div class="input-group flex-nowrap mt-3">
                        <span class="input-group-text" id="addon-wrapping"><i class="fa-solid fa-key"></i></span>
                        <input type="password"  name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu">
                      </div>
                    @error('password')
                        <p class="invaild-feedback text-red">{{ $message}}</p>
                    @enderror
                    <div class="text-center mt-4">
                          <button type="submit" class="btn btn-sm btn-primary mt-1">Đăng nhập</button>
                    </div>
                        <!-- /.col -->
                </form>
              </div>
              <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
     <!-- Bootstrap 4 -->

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>