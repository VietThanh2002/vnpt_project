<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="chrome=latest">
		<title>Quản trị viên</title>
		<link rel="icon" href="{{ asset('public/favicon.ico')}}" type="image/x-icon">
		<!-- Google Font: Source Sans Pro -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
		<!-- Theme style -->
		<link rel="stylesheet" href="{{asset ('admin-assets/css/adminlte.min.css')}}">
		<link rel="stylesheet" href="{{asset ('admin-assets/css/custom.css')}}">
		<link rel="stylesheet" href="{{asset ('admin-assets/css/jquery.dataTables.css')}}">



		<link rel="stylesheet" href="{{asset ('admin-assets/plugins/select2/css/select2.min.css')}}">
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

		<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

		
		<meta name="csrf-token" content="{{ csrf_token() }}">

	</head>
	<body class="hold-transition sidebar-mini">
		<!-- Site wrapper -->
		<div class="wrapper">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Right navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
					  	<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>					
				</ul>
				<div class="navbar-nav pl-2">
					<ol class="breadcrumb p-0 m-0 bg-white">
						<li class="breadcrumb-item active">Bảng điều khiển</li>
					</ol> 
				</div>
				
				<ul class="navbar-nav ml-auto">
					{{-- <li class="nav-item">
						<a class="nav-link" data-widget="fullscreen" href="#" role="button">
							<i class="fas fa-expand-arrows-alt"></i>
						</a>
					</li> --}}
					<li class="nav-item dropdown">
						<a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
							<h4 class="h4 mb-0 text-center"><span class="p-3">Xin chào:</span><strong>{{Auth::guard('admin')->user()->name}}</strong></h4>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
							<div class="mb-3 text-center">{{Auth::guard('admin')->user()->email}}</div>
							<div class="dropdown-divider"></div>
							{{-- <a href="#" class="dropdown-item">
								<i class="fas fa-user-cog mr-2"></i> Cài đặt								
							</a> --}}
							<div class="dropdown-divider"></div>
							<a href="{{ route('admin.changePassWordForm') }}" class="dropdown-item">
								<i class="fas fa-lock mr-2"></i> Đổi mật khẩu
							</a>
							<div class="dropdown-divider"></div>
							<a href="{{ route('admin.logout')}}" class="dropdown-item text-danger"> 
                                {{-- load route logout --}}
								<i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất							
							</a>							
						</div>
					</li>
				</ul>
			</nav>
			<!-- /.navbar -->
			<!-- Main Sidebar Container -->
            @include('admin.layouts.sidebar')
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
                @yield('content')
			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				
				<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2); text-color: #E0E0E0">
					© <?= date('Y'); ?> Copyright: <span>B2014610</span> 
				</div>
			</footer>
			
		</div>
		

		<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
		
		<script src="{{asset ('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{asset ('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
		<!-- AdminLTE App -->
		<script src="{{asset ('admin-assets/js/adminlte.min.js')}}"></script>

		{{-- <script  src="{{ asset ('admin-assets/plugins/dropzone/min/dropzone.min.js')}}"></script> --}}
		<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
		
		<script  src="{{ asset ('admin-assets/plugins/select2/js/select2.min.js')}}"></script> 
		{{-- dùng để làm sản phẩm liên quan --}}

		{{-- <script src=" {{ asset('admin-assets/plugins/summernote/summernote.min.js') }}"> --}}

		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.js"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{asset ('admin-assets/js/demo.js')}}"></script>

		{{-- datatables --}}


		<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

		<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
	
		<!-- Api province -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>

   		<script src="{{ asset('user-assets/js/api/apiprovince.js') }}"></script>

		<script type="text/javascript">
			$.ajaxSetup({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

		</script>

		<script>
			$(document).ready(function() {
				$('.summernote').summernote({
					height: 200,
					placeholder: 'Nhập nội dung của bạn ở đây...',
					toolbar: [
						['style', ['style']],
						['font', ['bold', 'italic', 'underline', 'clear']],
						['fontname', ['fontname']],
						['fontsize', ['fontsize']],
						['color', ['color']],
						['para', ['ul', 'ol', 'paragraph']],
						['height', ['height']],
						['table', ['table']],
						['insert', ['link']],
						['view', ['fullscreen', 'codeview']]
					],
					styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
					fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
					fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36'],
					focus: true
				});
			});
		</script>
		
        @yield('js')
	</body>
</html>