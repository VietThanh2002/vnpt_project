<nav>
    <i class='bx bx-menu' ></i>
    <form action="#">
        <div class="form-input">
            <input type="search" placeholder="Tìm kiếm">
            <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
        </div>
    </form>
    <input type="checkbox" id="switch-mode" hidden>
    <label for="switch-mode" class="switch-mode"></label>
    <!-- Example split danger button -->
    <div class="btn-group">
        <button type="button" class="btn btn-info btn-sm"><i class='bx bxs-user'></i></button>
        <button type="button" class="btn btn-info btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="visually-hidden">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu text-center">
            <li class=""><span>Xin chào:</span><strong>{{Auth::guard('staff')->user()->name}}</strong>
            <li><a class="dropdown-item" href="{{route('staff.viewProfile')}}">Thông tin cá nhân</a></li>
            <li><a class="dropdown-item text-danger" href="{{route('staff.logout')}}">Đăng xuất</a></li>
        </ul>
    </div>
</nav>