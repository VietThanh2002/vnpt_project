<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="chrome=latest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Đặt lại mật khẩu</title>
</head>
<body>
    <div class="card">
        <div class="card-header text-center">
           <h2>Yêu cầu đặt lại mật khẩu</h2>
        </div>
        <div class="card-body">
            <div>
                <p>Xin chào khách hàng {{ $mailContent['user']->name }} bạn có yêu cầu đặt lại mật khẩu</p>
            </div>
        </div>
        <div class="card-footer">
            <p>Vui lòng ấn vào đường dẫn phía dưới để tiến hành đặt lại mật khẩu</p>
            <a href="{{route('user.resetPassword', $mailContent['token']) }}">Click vào đây !</a>
        </div>
    </div>
    <p></p>
</body>
</html>