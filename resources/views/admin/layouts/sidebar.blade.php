<aside class="main-sidebar sidebar-dark-white elevation-4" style="background-color:  rgb(87, 121, 221);">

    <a href="#" class="brand-link">
        <span class="brand-text fw-bold">VNPT Đồng Tháp</span>
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
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <p  class="text-white hover">Dịch vụ Internet</p>
                    </a>
                </li>	
                <li class="nav-item">
                    <a href="{{ route('sim-card.index') }}" class="nav-link">
                        <p  class="text-white hover">Sim</p>
                    </a>
                </li>			
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <p  class="text-white hover">Đơn hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.productRating') }}" class="nav-link">
                        <p  class="text-white hover">Đánh giá dịch vụ</p>
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