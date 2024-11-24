<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="chrome=latest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Thông tin đơn hàng</title>
</head>
<body>
    @if($mailContent['userType'] == 'user')
        <h2 class="text-center">Cảm ơn quý khách đã đặt hàng!!</h2>
        <h2>Mã đơn hàng của bạn là: {{ $mailContent['order']->id}}</h2>
    @else
        <h1>Bạn đã nhận được 1 đơn đặt hàng:</h1>
        <h2>Mã đơn hàng là: {{ $mailContent['order']->id}}</h2>
    @endif
    <h3 class="h6">Thông tin và địa chỉ nhận hàng</h3>
    <address>
        <p>Tên khách hàng: <span class="fw-bold">{{$mailContent['order']->name}}</span></p>
        <p>Địa chỉ: <span class="fw-bold"> {{$mailContent['order']->address}}-{{$mailContent['order']->ward }}-{{$mailContent['order']->district }}- {{$mailContent['order']->city }}</span></p>
        <p title="Phone">Số điện thoại: <span class="fw-bold">{{$mailContent['order']->mobile }}</span></p>
    </address>
    <h3 class="text-center">Thông tin đơn hàng</h3>
    <table class="table table-borderless">
        <thead>
            <tr class="text-center bg-info">
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá </th>
            </tr>
        </thead>
        <tbody>
             @foreach ($mailContent['order']->items as $item)
                    <tr class="text-center">
                        <td>
                            <div class="d-flex mb-2">
                                <div class="flex-lg-grow-1 ms-3">
                                    <p class="small mb-0">{{$item->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{$item->qty}}</td>
                        <td>{{  formatPriceVND($item->price) }}</td>
                    </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Tổng tiền sản phẩm</td>
                <td class="text-end">{{ formatPriceVND( $mailContent['order']->subtotal) }}</td>
            </tr>
            <tr>
                <td colspan="2">Áp dụng giảm giá</td>
                <td class="text-end">{{ formatPriceVND( $mailContent['discountAmount'])}}</td>
            </tr>
            <tr>
                <td colspan="2">Phí vận chuyển</td>
                <td class="text-end">{{ formatPriceVND( $mailContent['order']->shipping) }}</td>
            </tr>
            <tr class="fw-bold">
                <td colspan="2">Tiền thanh toán</td>
                <td class="text-end">{{ formatPriceVND( $mailContent['order']->grand_total) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>