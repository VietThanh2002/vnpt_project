<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hóa đơn</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: 'Arial', sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: 'Arial', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }
        
        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-color {
            background-color: #2d3ce2;
            color: #fff;
        }
    </style>
</head>
<body>
    <table class="order-details" class="shadow">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">VNPT Đồng Tháp</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Mã hóa đơn: {{ $order->id }}</span> <br>
                    <span>Thời gian đặt hàng: {{ ($order->created_at)->format('d/m/Y H:i:s') }}</span> <br>
                    @if (!empty($order->notes))
                        <span>Ghi chú đơn hàng: {{$order->notes}}</span>
                    @else
                        <span>Ghi chú đơn hàng: <strong>Không có ghi chú</strong></span>
                    @endif
                    <br>
                </th>
            </tr>
            <tr class="bg-color">
                <th class="text-center" width="50%" colspan="2">Thông tin đơn hàng</th>
                <th class="text-center" width="50%" colspan="2">Thông tin người nhận hàng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mã hóa đơn</td>
                <td>{{ $order->id }}</td>

                <td>Họ và tên</td>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <td>Ordered Date:</td>
                <td>22-09-2022 10:54 AM</td>

                <td>Sđt:</td>
                <td>{{ $order->mobile }}</td>
            </tr>
            <tr>
                <td>Phương thức thanh toán:</td>
                <td>{{ $order->payment_status}}</td>

                
                <td>Email:</td>
                <td>{{ $order->email }}</td>
            </tr>
            <tr>
                <td>Trạng thái đơn hàng</td>
                 <td>{{$order->status}}</td>

                <td>Địa chỉ:</td>
                <td><span>{{$order->address}}-{{$order->ward }}-{{ $order->district}}-{{$order->city}}</span><br></td>
            </tr>
        </tbody>
    </table><br>
    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                  Sản phẩm đã đặt
                </th>
            </tr>
            <tr class="bg-color">
                <th>Mã SP</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails as $item)
                <tr>
                    <td width="10%">{{ $item->id }}</td>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td width="10%">   {{ formatPriceVND($item->price) }}</td>
                    <td width="10%"> {{ $item->qty }}</td>
                    <td width="15%" class="fw-bold">{{ formatPriceVND($item->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="total-heading">Tổng tiền thanh toán:</td>
                <td colspan="1" class="total-heading">{{formatPriceVND($order->grand_total)}}</td>
            </tr>
        </tbody>
    </table><br>

    <table class="border-r" class="shadow">
        <thead>
            <tr>
                <th width="50%" colspan="2" class="text-center">
                    <h2>Khách hàng</h2>
                    <h3>(Ký tên)</h3><br>
                    <h3>{{ $order->name }}</h3>
                </th>
                <th width="50%" colspan="2" class="text-center">
                    <h2>Quản lý</h2>
                    <h3>(Ký tên)</h3><br>
                    <h3>Phạm Viêt Thanh</h3>
                </th>
            </tr>
        </thead>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    </script>
</body>
</html>
