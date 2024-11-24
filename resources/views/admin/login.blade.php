<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Đăng nhập quản trị viên</title>
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{asset ('admin-assets/plugins/fontawesome-free/css/all.min.css')}}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{asset ('admin-assets/css/adminlte.min.css')}}">
		<link rel="stylesheet" href="{{asset ('admin-assets/css/custom.css')}}">
	</head>
	<body class="hold-transition login-page" style="background-color: lightskyblue">
		<div class="login-box">
			<!-- /.login-logo -->
            @include('admin.message')
			<div class="card card-outline card-primary">
			  	<div class="m-2 p-2 card-header text-center bg-white shadow rounded-3">
					<p class="h3">Đăng nhập</p>
			  	</div>
			  	<div class="card-body">
					<form action="{{ route ('admin.authenticate') }}" method="post">
                        @csrf
				  		<div class="input-group mb-3">
							<div class="input-group-append">
								<div class="input-group-text">
								  <span class="fas fa-envelope"></span>
								</div>
						  	</div>
							<input type="email" value="{{ old('email')}}" name="email" id="name" class="form-control   @error('email') is-invalid @enderror"  placeholder="Nhập email">
				  		</div>
                        @error('email')
                            <p class="invaild-feedback text-red">{{ $message}}</p>
                        @enderror
				  		<div class="input-group mb-3">
							<div class="input-group-append">
								<div class="input-group-text">
								  <span class="fas fa-lock"></span>
								</div>
						  	</div>
							<input type="password"  name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu">
				  		</div>
                        @error('password')
                            <p class="invaild-feedback text-red">{{ $message}}</p>
                        @enderror
				  	
						<div class="text-center">
                                <button type="submit" class="btn btn-sm btn-primary mt-1">Đăng nhập</button>
						</div>
							<!-- /.col -->
					</form>
			  	</div>
			  	<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{asset ('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{asset ('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script src="{{asset ('admin-assets/js/adminlte.min.js')}}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{asset ('admin-assets/js/demo.js')}}"></script>
	</body>
</html>