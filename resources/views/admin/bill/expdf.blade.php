
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xuất hóa đơn</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: DejaVu Sans;
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
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 20px;
            margin-top: 12px;
            margin-bottom: 12px;
        }
        .small-heading {
            font-size: 13px;
        }
        .total-heading {
            font-size: 13px;
            font-weight: 700;

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
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>

    <table class="order-details" class="shadow">
        <thead>
            <tr>
                <th width="50%" colspan="2">
                    <h2 class="text-start">Cửa hàng phụ tùng xe máy VT</h2>
                </th>
                <th width="50%" colspan="2" class="text-end company-data">
                    <span>Mã hóa đơn: {{ $order->id }}</span> <br>
                    <span>Thời gian đặt hàng: {{ ($order->created_at)->format('d/m/Y H:i:s') }}</span> <br>
                    @if (!empty($order->notes))
                        <span>Ghi chú đơn hàng: {{$order->notes}}</span>
                    @else
                        <span>Ghi chú đơn hàng: <strong>Không có ghi chú</strong></span>
                    @endif
                </th>
            </tr>
            <tr class="bg-blue">
                <th class="text-center" width="50%" colspan="2">Chi tiết đơn hàng</th>
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
                <td>Ngày đặt hàng</td>
                <td>{{ $order->created_at}}</td>

                <td>Sđt:</td>
                <td>{{ $order->mobile }}</td>
            </tr>
            <tr>
                <td>Phương thức thanh toán:</td>
                <td>{{ $order->payment_method}}</td>

                <td>Email:</td>
                <td>{{ $order->email }}</td>
            </tr>
            <tr>
                <td>Trạng thái đơn hàng</td>
                 <td>{{ $order->payment_status}}</td>

                <td>Địa chỉ:</td>
                <td><span>{{$order->address}}-{{$order->ward }}-{{ $order->district}}-{{$order->city}}</span><br></td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <th class="no-border text-start heading" colspan="5">
                  Sản phẩm đã đặt
                </th>
            </tr>
            <tr class="bg-blue">
                <th>ID</th>
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
                    <td width="20%">{{ formatPriceVND($item->price) }}</td>
                    <td width="10%"> {{ $item->qty }}</td>
                    <td width="20%" class="fw-bold">{{ formatPriceVND($item->total) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="total-heading">Áp dụng giảm giá</td>
                <td colspan="1" class="total-heading">{{ formatPriceVND($discountAmount) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="total-heading">Phí vận chuyển</td>
                <td colspan="1" class="total-heading">{{ formatPriceVND($order->shipping) }}</td>
            </tr>
            <tr>
                <td colspan="4" class="total-heading">Tổng tiền thanh toán:</td>
                <td colspan="1" class="total-heading">{{formatPriceVND($order->grand_total)}}</td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table class="border-r" class="shadow">
        <thead>
            <tr>
                <th width="50%" colspan="2" class="text-center">
                    <h4>Khách hàng</h4>
                    <h5>(Ký tên)</h5><br>
                    <h5>{{ $order->name }}</h5>
                </th>
                <th width="50%" colspan="2" class="text-center">
                    <h4>Quản lý</h4>
                    <h5>(Ký tên)</h5><br>
                    <h5>Phạm Viêt Thanh</h5>
                </th>
            </tr>
        </thead>
    </table>

</body>
</html>