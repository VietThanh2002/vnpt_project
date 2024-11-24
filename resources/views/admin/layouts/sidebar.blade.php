<aside class="main-sidebar sidebar-dark-white elevation-4" style="background-color:  rgb(56, 93, 202);">

    <a href="#" class="brand-link">
        <span class="brand-text fw-bold">Cửa hàng phụ tùng xe máy</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard')}}" class="nav-link">
                        <p  class="text-white hover">Bảng điều khiển</p>
                    </a>																
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link">
                        <p  class="text-white hover">Danh mục</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sub-categories.index')}}" class="nav-link">
                        <p  class="text-white hover">Danh mục phụ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('brands.index') }}" class="nav-link">
                        <p  class="text-white hover">Thương hiệu</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <p  class="text-white hover">Sản phẩm</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('shipping.index') }}" class="nav-link">
                        <p  class="text-white hover">Vận chuyển</p>
                    </a>
                </li>							
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <p  class="text-white hover">Đơn hàng</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('products.productRating') }}" class="nav-link">
                        <p  class="text-white hover">Đánh giá sản phẩm</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <div class="accordion-item nav-link" id="accordion">
                        <div class="" >
                          <div id="headingOne">
                              <p class="text-white" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Kho                               
                              </p>                          
                            </div>
                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                              <a class="p-2 m-4" href="{{ route('warehouse.import') }}">Nhập sản phẩm</a><br>
                          </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                     <a href="{{ route('discount.index') }}" class="nav-link">
                        <p  class="text-white hover">Mã giảm giá</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staffs.index') }}" class="nav-link">
                        <p  class="text-white hover">Nhân viên</p>
                    </a>
                </li>	
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <p  class="text-white hover">Khách hàng</p>
                    </a>
                </li>					
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
 </aside>