@extends('user.layouts.app')

@section('content')
<section class="section-5" style="margin-top: 170px;">
</section>

<section class="section-9 pt-4" style="margin-bottom: 50px">
    <div class="container">
        <form action="" method="post" id="orderForm" name="orderForm">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                <div class="text-center">
                                    <p class="fs-3 fw-bold">Thông tin địa chỉ</p>
                                </div>
                                <div class="col-md-4 col-md-12">
                                    <div class="mb-3">
                                        <input  type="text" name="name" id="name" class="form-control" placeholder="Nhập họ và tên" value="{{ (!empty($userAddress)) ? $userAddress->name : '' }}">
                                        <p></p>
                                    </div>            
                                </div>
                
                                <div class="col-md-4 col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Nhập email" value="{{ (!empty($userAddress)) ? $userAddress->email : '' }}">
                                        <p></p>
                                    </div>            
                                </div>


                                <div class="col-md-4 col-sm-12 form-group">
                                    <label for="Province">Tỉnh/Thành Phố</label>
                                    <select id="Province" class="form-control"></select>
                                    <p></p>       
                                </div>
    
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label for="District">Quận/Huyện</label>
                                    <select  id="District"  class="form-control"></select>
                                    <p></p>       
                                </div>
    
                                <div class="col-md-4 col-sm-12 form-group">
                                    <label for="Ward">Xã/Phường</label>
                                    <select id="Ward"  class="form-control"></select>
                                    <p></p>       
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="Địa chỉ lắp đặt cụ thể (Số nhà, tên đường)" class="form-control">{{ (!empty($userAddress)) ? $userAddress->address : '' }}</textarea>
                                        <p></p>
                                    </div>            
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Số điện thoại" value="{{ (!empty($userAddress)) ? $userAddress->mobile : '' }}">
                                        <p></p>
                                    </div>            
                                </div>
                            
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="notes" id="notes" cols="30" rows="5" placeholder="Yêu cầu lắp đặt (nếu có)" class="form-control"></textarea>
                                    </div>            
                                </div>
    
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="m-2 text-center">
                            <p class="fs-3 fw-bold">Thông tin thanh toán</h3>
                        </div> 
                            <div class="card-body">
                                @foreach (Cart::content() as $item)
                                   @if ($item->options->type == 'Dịch vụ di động')
                                    <div class="ms-5">
                                        <div class="h6">Số sim: {{ $item->name }}</div><br>
                                        <div class="h6">Loại thuê bao: {{ $item->options->sim_type }}</div><br>
                                        <div class="h6">Gía sim: {{  formatPriceVND(($item->price)*($item->qty)) }}</div>
                                    </div>
                                   @else
                                    <div class="d-flex justify-content-between">
                                        <div class="h6">{{ $item->name }} / {{ $item->qty}} tháng</div>
                                        <div class="h6">{{  formatPriceVND(($item->price)*($item->qty)) }}</div>
                                    </div>
                                    @endif
                                @endforeach
                                <hr>
                                <hr>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Tạm tính</strong></div>
                                    <div class="h6"><strong>{{ formatPriceVND(Cart::subtotal()) }}</strong></div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Tổng cộng</strong></div>
                                    <div class="h5"><strong id="grandTotal" >{{ $grandTotal }}</strong></div>
                                </div>                                 
                            </div>
                        </div>
                        <div class="card payment-form mt-3 p-1" id="card-payment-form">                        
                            <h3 class="card-title h5 mb-3">Phương thức thanh toán</h3>
                            <div class="card-body p-0">
                                <div class="form-check">
                                    <input class="form-check-input" value="Thanh toán tại nhà" type="radio" name="payment_method" id="payment_method_1" checked>
                                    <label class="form-check-label" for="payment_method_1">
                                        Thanh toán tại nhà
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="Thanh toán tại cửa hàng" type="radio" name="payment_method" id="payment_method_2">
                                    <label class="form-check-label" for="payment_method_2">
                                        Thanh toán tại cửa hàng
                                    </label>
                                </div>                                
                                <div class="col-12 pt-4 m-2 text-center">
                                    <button type="submit" class="btn-danger btn btn-block border rounded-5 w-50">Xác nhận đặt dịch vụ</button>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>   
@endsection

@section('js')
   <script>
        $("#orderForm").submit(function (event) {
            event.preventDefault();
            $("button[type=submit]").prop('disabled', true);

            // Lấy giá trị tên của tỉnh/thành phố, quận/huyện, và xã/phường
            var cityName = $('#Province').find("option:selected").text();
            var districtName = $('#District').find("option:selected").text();
            var wardName = $('#Ward').find("option:selected").text();

            // Tạo một đối tượng dữ liệu để gửi lên server
            var formData = $(this).serializeArray();

            // Thêm giá trị tên của tỉnh/thành phố, quận/huyện, và xã/phường vào đối tượng dữ liệu
            formData.push({ name: "city", value: cityName });
            formData.push({ name: "district", value: districtName });
            formData.push({ name: "ward", value: wardName });

            $.ajax({
                url: '{{ route("user.processCheckout") }}',
                type: 'post',
                data: formData,
                dataType: 'json',

                success: function (response) {
                    if (response["status"] == true) {
                        // $("button[type=submit]").prop('disabled', false);
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#city').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#district').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#ward').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                        window.location.href = "{{ url('thanks/') }}/" + response.orderId;

                    } else {
                        var errors = response['errors'];

                        $("button[type=submit]").prop('disabled', false);

                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['email']) {
                            $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['city']) {
                            $('#Province').addClass('is-invalid'); // Thêm class 'is-invalid' vào thẻ select
                            $('#Province').siblings('p').addClass('invalid-feedback').html(errors['city']);
                        } else {
                            $('#Province').removeClass('is-invalid');
                            $('#Province').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['district']) {
                            $('#District').addClass('is-invalid');
                            $('#District').siblings('p').addClass('invalid-feedback').html(errors['district']);
                        } else {
                            $('#District').removeClass('is-invalid');
                            $('#District').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['ward']) {
                            $('#Ward').addClass('is-invalid');
                            $('#Ward').siblings('p').addClass('invalid-feedback').html(errors['ward']);
                        } else {
                            $('#Ward').removeClass('is-invalid');
                            $('#Ward').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['address']) {
                            $('#address').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['address']);
                        } else {
                            $('#address').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }

                        if (errors['mobile']) {
                            $('#mobile').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['mobile']);
                        } else {
                            $('#mobile').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }

                },
                error: function (jQHR, exception) {
                    console.log('Xảy ra lỗi');
                }
            });
        });
   </script>
@endsection