<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VNPT Đồng Tháp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300&family=Inter:wght@100..900&family=Roboto+Mono:ital@1&family=Work+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset ('admin-assets/plugins/select2/css/select2.min.css')}}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
    {{-- carousel --}}
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset ('admin-assets/css/jquery.dataTables.css')}}">
   
    <link rel="stylesheet" href="{{ asset('user-assets/css/style.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body data-instant-intensity="mousedown">
    <a id="button-top"></a>
    
    <div class="header">
        <header class="header" style="background-color: white;">
            <a href="{{ route('user.home')}}"><img class="logo" src="{{ asset('user-assets/image/Logo-VNPT.png')}}" alt=""></a>
            <div class="nav-icon">
                <div class="search_click">
                    <form class="form-search" action="{{ route('user.shop')}}" method="get">
                        <input name="search" id="search" value="{{ Request::get('search') }}" class="search__input" type="text" name="search" placeholder="  Nhập tên dịch vụ">
                        <button type="submit" class='btn bx bx-search'></button>
                    </form>
                </div>
            </div>
        </header>

        <header class="header bg-white" style="margin-top: 85px">
            <div class="container">
                <nav class="navbar navbar-expand-xl" id="navbar">
                    <button class="navbar-toggler menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                         <span class="navbar-toggler-icon icon-menu"></span> 
                    </button>
                    <div class="collapse navbar-collapse" id="navbarContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fw-bold" aria-current="page" href="{{ route('user.home')}}" >Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="{{ route('user.introduce')}}">Giới thiệu</a>
                            </li>
                            {{-- <li class="nav-item dropdown">
                              <a class="nav-link fw-bold dropdown-toggle" href="#" data-bs-toggle="dropdown"> Danh mục danh vụ</a>
                                <ul class="dropdown-menu">
                                  <li><a class="dropdown-item" href="{{ route('user.shop') }}"> TẤT CẢ</a></li>
                                  @if (getCategories()->isNotEmpty())
                                    @foreach (getCategories() as $category)
                                      <li><a class="dropdown-item" href="{{ route('user.shop', [$category->slug])}}">{{$category->name}}</a></li>
                                    @endforeach    
                                  @endif
                                </ul>
                            </li> --}}
                            <li>
                                <a class="nav-link fw-bold" href="{{ route('user.shop')}}">Dịch vụ Internet</a>
                            </li>
                            <li>
                                <a class="nav-link fw-bold" href="{{ route('user.simSo')}}">Sim số</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="{{ route('user.contact')}}">Liên hệ</a>
                            </li>
                        </ul>      			
                    </div>   
                    <div class="right-nav py-0">
                        <div class="nav-icon">
                            <div class="dropdown-center">
                            <i class=" bx bx-user dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            </i>
                            <ul class="dropdown-menu">
                                @if (Auth::check())
                                    <li><a class="dropdown-item" href="{{ route('user.profile') }}">Thông tin cá nhân</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.getOrder') }}">Xem đơn hàng</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.logout') }}"><span><i class='bx bx-log-out text-danger'></i>Đăng xuất</span></a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.login')}}">Đăng nhập</a></li>
                                @endif
                            </ul>
                            </div>
                            {{-- <a href="{{ route('user.cart') }}">
                                <i class='bx bx-cart-alt'></i>
                                <span class="cart-quantity">( {{ Cart::count() }} )</span>
                            </a> --}}
                        </div>
                    </div> 		
                </nav>
            </div>
        </header>
    </div>
    <main>
        @yield('content')
    </main>
    <footer class="text-white text-center text-lg-start" style="background-color: rgb(16, 85, 122)">
        <!-- Grid container -->
        <div class="container-fluid">
          <!--Grid row-->
          <div class="row">
            <!--Grid column-->
            <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
              <h5 class="text-uppercase mb-4 mt-3">Về công ty</h5>
              <p style="text-align: justify;">
                Chào mừng bạn đến với VNPT! Tại đây, chúng tôi cam kết mang đến những trải nghiệm dịch vụ viễn thông và công nghệ thông tin độc đáo cho khách hàng. VNPT không chỉ xem chất lượng là một cam kết mà còn là sứ mệnh của chúng tôi, nhằm xây dựng niềm tin vững chắc từ phía khách hàng. Chúng tôi nỗ lực không ngừng để phát triển các sản phẩm và dịch vụ công nghệ hiện đại, 
                phục vụ tốt nhất cho nhu cầu của người tiêu dùng và góp phần vào sự phát triển của nền kinh tế số quốc gia.
              </p>
      
              <div class="mt-4">
                <!-- Facebook -->
                <a type="button" class="btn btn-floating btn-secondary btn-warning"><i class="fa-brands fa-square-facebook text-white"></i></a>
                <!-- Dribbble -->
                <a type="button" class="btn btn-floating btn-secondary btn-warning"><i class="fab fa-dribbble text-white"></i></a>
                <!-- Twitter -->
                <a type="button" class="btn btn-floating btn-secondary btn-warning"><i class="fab fa-twitter text-white"></i></a>
                <!-- Google + -->
                <a type="button" class="btn btn-floating btn-secondary btn-warning"><i class="fab fa-google-plus-g text-white"></i></a>
                <!-- Linkedin -->
              </div>
            </div>
            <!--Grid column-->
      
            <!--Grid column-->
            <div class="col-lg-4 col-md-6" style="margin-bottom: 20px">
                <h5 class="text-uppercase mb-4 mt-3">Địa chỉ</h5>
              <ul class="fa-ul mt-3" style="margin-left: 1.65em;">
                <li class="mb-3">
                  <span class="fa-li"><i class="fas fa-envelope"></i></span><span class="ms-2">cskh@vnpt.vn</span>
                </li>
                <li class="mb-3">
                  <span class="fa-li"><i class="fas fa-phone"></i></span><span class="ms-2">1800 1091
                  </span>
                </li>
              </ul>
            </div>
            <!--Grid column-->
      
            <!--Grid column-->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
              <h5 class="text-uppercase mb-4 mt-3">Thời gian mở cửa</h5>
              <table class="table text-center rounded-3">
                <tbody class="font-weight-normal">
                  <tr>
                    <td>Thứ 2 - Thứ 7:</td>
                    <td>7 am - 8pm</td>
                  </tr>
                  <tr>
                    <td>Chủ nhật</td>
                    <td>8am - 3am</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--Grid column-->
          </div>
          <!--Grid row-->
        </div>
        <!-- Grid container -->
      
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
          © 2024 Copyright: VNPT
        </div>
        <!-- Copyright -->
      </footer>
      
    </div>
    <!-- End of .container -->


  
  <!-- wishlistModal -->
  <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Đã thêm sản phẩm vào danh sách yêu thích</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        </div>
      </div>
    </div>
  </div>







    <script src="{{ asset('user-assets/js/main.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="//instant.page/5.2.0" type="module" integrity="sha384-jnZyxPjiipYXnSU0ygqeac2q7CVYMbh84q0uHVRRxEtvFPiQYbXWUorga2aqZJ0z"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"> </script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!--jQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <script  src="{{ asset ('admin-assets/plugins/select2/js/select2.min.js')}}"></script> 
    
    <!--Plugin JavaScript file-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    {{-- carousel --}}
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    {{-- province API --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script src="{{ asset('user-assets/js/api/apiprovince.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <script type="text/javascript">
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>

    <script>
        window.onscroll = function() {myFunction()};
        
        var navbar = document.getElementById("navbar");
        var sticky = navbar.offsetTop;
        
        function myFunction() {
          if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
          } else {
            navbar.classList.remove("sticky");
          }
        }
    </script>

    <script>
        function addToWishlist(id){
            $.ajax({
                    url: '{{ route("user.addToWishlist") }}',
                    type: 'post',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == true){
                            $("#wishlistModal .modal-body").html(response.message);
                            $("#wishlistModal").modal('show');
                        }else{
                            window.location.href = "{{ route('user.login') }}";
                        }
                    } 

            });
        }
    </script>   

    <script>
      $(document).ready( function () {
        $('#myTable').DataTable({
          "paging": false,
          "info": false,
          "language": {
                "search": "Tìm kiếm:",
            },
            
		    });
    });
    </script>
    
    {{-- Nút back to top --}}
    <script>
        var btn = $('#button-top');

            $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                btn.addClass('show');
            } else {
                btn.removeClass('show');
            }
            });

            btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, '300');
            });
    </script>

    @yield('js')
</body>
</html>