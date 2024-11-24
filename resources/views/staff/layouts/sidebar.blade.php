

<section id="sidebar">
    <div  class="mt-5 d-flex justify-content-center text-info">
        <span class="text"><i class="fa-solid fa-truck-fast"></i> Giao hàng</span>
    </div>
    <ul class="side-menu top">
        <li class="active">
            <a href="{{route('staff.home')}}">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Bảng điều khiển</span>
            </a>
        </li>
        <li class="">
            <a href="{{route('staff.productsList')}}">
                <i class='bx bx-package' ></i>
                <span class="text">Sản phẩm</span>
            </a>
        </li>
        <li>
           <div class="mt-2 d-flex justify-content-start">
             <!-- Example single danger button -->
                <div class="btn-group border">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Đơn hàng
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{route('staff.listPending')}}">Đang hàng đang giao</a></li>
                        <li><a class="dropdown-item" href="{{route('staff.listComplete')}}">Đơn hàng hoàn thành</a></li>
                    </ul>
                </div>
           </div>
        </li>
    </ul>
</section>
<!-- SIDEBAR -->