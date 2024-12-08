# Cài Đặt Dự Án

Làm theo các bước dưới đây để cài đặt và chạy dự án trên máy của bạn:

## Bước 1: Chuẩn bị
- Chọn thư mục nơi bạn muốn chứa mã nguồn.
- Mở terminal trong thư mục đó.

## Bước 2: Clone repository
Chạy lệnh sau để clone mã nguồn từ repository:
```bash
git clone https://github.com/VietThanh2002/my_project
```

## Bước 3: Di chuyển vào thư mục dự án
```bash
cd my_project
```

## Bước 4: Cài đặt các dependency
Sử dụng Composer để cài đặt tất cả các dependency:
```bash
composer install
```

## Bước 5: Cấu hình file `.env`
- Mở dự án `my_project` bằng **VS Code** hoặc trình soạn thảo yêu thích của bạn.
- Tạo file `.env` bằng cách sao chép file `.env.example` và chỉnh sửa theo cấu hình của bạn.

## Bước 6: Tạo application key
Chạy lệnh sau để tạo khóa ứng dụng cho Laravel:
```bash
php artisan key:generate
```

## Bước 7: Tạo cơ sở dữ liệu
1. Tạo cơ sở dữ liệu mới với tên `my_project`.
2. Import file cơ sở dữ liệu tại đường dẫn `database/my_project.sql` vào cơ sở dữ liệu của bạn.
3. Chỉnh sửa file `.env` và cập nhật dòng sau với tên cơ sở dữ liệu của bạn:
   ```env
   DB_DATABASE=my_project
   ```

## Bước 8: Khởi động máy chủ Laravel
Chạy lệnh sau để khởi động máy chủ phát triển tích hợp của Laravel:
```bash
php artisan serve
```

## Bước 9: Kiểm tra chức năng
### Phía Admin
- Truy cập: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)
- Thông tin đăng nhập:
  - **Email**: `admin123@gmail.com`
  - **Password**: `admin@123`

### Phía User
- Truy cập: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- Thông tin đăng nhập:
  - **Email**: `vthanhb2014610@gmail.com`
  - **Password**: `123456789`
