<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="chrome=latest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Contact Email</title>
</head>
<body>
   <div class="card">
        <div class="card-header">
            <h3 class="fw-bold text-center">Email liên hệ từ khách hàng</h3>
        </div>
        <div class="card-body">
            <p>Họ và tên khách hàng: <span class="">{{ $mailContent['user_name'] }}</span></p>
            <p>Từ khác hàng có email: <span class="">{{ $mailContent['email'] }}</span></p>
            <p>Chủ đề liên hệ: <span class="">{{ $mailContent['subject'] }}</span></p>
            <p>Nội dung liên hệ: <span class="">{{ $mailContent['content'] }}</span></p>
        </div>
   </div>
</body>
</html>