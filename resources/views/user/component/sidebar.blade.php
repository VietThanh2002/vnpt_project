<ul id="account-panel" class="nav nav-pills flex-column" >
    <li class="nav-item">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <i class="fas fa-user-alt m-1 text-warning ml-1"></i>Tài khoản của tôi
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <a href="{{ route('user.profile') }}" class="nav-link font-weight-bold text-dark m-1"><i class="fa-solid fa-file text-primary"></i>  Thông tin đăng nhập</a>
                    <a href="{{ route('user.getOrder') }}" class="nav-link font-weight-bold text-dark m-1"><i class="fa-solid fa-receipt text-primary"></i></i> Đơn hàng</a>
                </div>
              </div>
            </div>
    </li><hr>
    <li class="nav-item">
        <a href="{{ route('user.changePassWordForm') }}" class="nav-link font-weight-bold text-dark m-1"><i class="fas fa-lock text-primary"></i> Thay đổi mật khẩu</a>
    </li><hr>
    <li class="nav-item">
        <a href="{{route('user.logout')}}" class="nav-link font-weight-bold text-dark m-1"><i class="fas fa-sign-out-alt text-danger"></i> Đăng xuất</a>
    </li>
</ul>