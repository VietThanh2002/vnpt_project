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
                                    <p class="fs-3 fw-bold">Thông tin nhận hàng</p>
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

                                <div class="col-md-4 col-lg-12">
                                    <div class="m-2 p-1">
                                        <p>Thông tin địa chỉ nhận hàng hiện tại:</p>
                                        @if(!empty($userAddress) && !empty($userAddress->ward) && !empty($userAddress->district) && !empty($userAddress->city))
                                            <span class="fw-bold text-dark d-flex justify-content-center">
                                                {{ $userAddress->ward }} - {{ $userAddress->district }} - {{ $userAddress->city }}
                                            </span>
                                        @else
                                            <span class="fw-bold text-dark d-flex justify-content-center">Chưa có !!</span>
                                        @endif
                                    </div>
                                </div>
    
                                <div class="col-md-12 mt-2">
                                    <div class="mb-3">
                                        <textarea name="address" id="address" cols="30" rows="3" placeholder="(Số nhà, tên đường)" class="form-control">{{ (!empty($userAddress)) ? $userAddress->address : '' }}</textarea>
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
                                        <textarea name="notes" id="notes" cols="30" rows="5" placeholder="Ghi chú nhận hàng (nếu có)" class="form-control"></textarea>
                                    </div>            
                                </div>
    
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="m-2 text-center">
                            <p class="fs-3 fw-bold">Thông tin giỏ hàng</h3>
                        </div> 
                            <div class="card-body">
                                @foreach (Cart::content() as $item)
                                    <div class="d-flex justify-content-between">
                                        <div class="h6">{{ $item->name }} x {{ $item->qty}}</div>
                                        <div class="h6">{{  formatPriceVND(($item->price)*($item->qty)) }}</div>
                                    </div>
                                @endforeach
                                <hr>
                                <div>
                                    <div class="input-group apply-coupan mt-4">
                                        <input type="text" id="discount_code" name="discount_code" placeholder="Mã giảm giá" class="form-control m-1">
                                        <button id="apply-discount" class="btn btn-primary m-1" type="button">Áp dụng</button>
                                    </div>
                                   <div>
                                   <div>
                                        @if(Session::has('code'))
                                            <div class="mt-4">
                                                <strong>{{ Session::get('code')->code}}</strong>
                                                <a id="remove_discout" name="remove_discout" class="btn btn-sm btn-danger rounded-circle"><i class="fa fa-times"></i></a>
                                            </div>
                                        @endif
                                        <div class="m-2 p-2" id="discount_message">
                                            
                                        </div>
                                   </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Tạm tính</strong></div>
                                    <div class="h6"><strong>{{ formatPriceVND(Cart::subtotal()) }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Giảm giá</strong></div>
                                    <div class="h6"><strong id="discount_value">{{ $discount }}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Phí lắp đặt</strong></div>
                                    <div class="h6"><strong id="shippingFee">{{ $ShippingCost }}</strong></div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Tổng cộng</strong></div>
                                    <div class="h5"><strong id="grandTotal" >{{ $grandTotal }}</strong></div>
                                </div>                                 
                            </div>
                        </div>
                    </div>
                    <div class="card payment-form mt-3 p-1" id="card-payment-form">                        
                        <h3 class="card-title h5 mb-3">Phương thức thanh toán</h3>
                        <div class="card-body p-0">
                            <div class="form-check">
                                <input class="form-check-input" value="Thanh toán khi nhận hàng" type="radio" name="payment_method" id="payment_method_1"  checked>
                                <label class="form-check-label" for="payment_method_1">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            {{-- <a href="{{ url('payment-online') }}">
                                <div class="form-check">
                                    <input class="form-check-input" value="Thanh toán online" type="radio" name="payment_method" id="payment_method_2">
                                    <label class="form-check-label" for="payment_method_2">
                                    Thanh toán online (Ví VNpay)
                                    </label>
                                </div>
                            </a> --}}
                            <div class="col-12 pt-4 m-2 text-center">
                                <button type="submit" class="btn-danger btn btn-block border rounded-5 w-25">Đặt hàng</button>
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

     
     $("#Province").change(function(){
        $.ajax({
            url: '{{ route("user.getOrderSummary") }}',
            type: 'post',
            data: {city: $(this).find("option:selected").text()}, // lấy tên thay vì id
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $("#shippingFee").html(response.shipping); //lấy giá trị từ response truyền vào thẻ có id là #shippingFee
                    $("#grandTotal").html(response.grandTotal);
                    $("#discount_value").html(response.discount);
                }
            }
        });
     });

     $('#apply-discount').click(function(){
        $.ajax({
            url: '{{ route("user.applyDiscount") }}',
            type: 'post',
            data: {code: $("#discount_code").val()},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    // $("#shippingFee").html(response.shippingFee); //lấy giá trị từ response truyền vào thẻ có id là #shippingFee
                    $("#grandTotal").html(response.grandTotal);
                    $("#discount_value").html(response.discount);
                }else{
                    $("#discount_message").html("<span class='text-center text-danger'>"+response.message+"</span>");
                }
            },
            error: function(xhr, status, error){
            // Xử lý lỗi nếu có
            console.log(xhr.responseText);
        }
        });
     });

     $('#remove_discout').click(function(){
        $.ajax({
            url: '{{ route("user.removeDiscount") }}',
            type: 'post',
            data: {},
            dataType: 'json',
            success: function(response){
                if(response.status == true){
                    $("#shippingFee").html(response.shippingFee); //lấy giá trị từ response truyền vào thẻ có id là #shippingFee
                    $("#grandTotal").html(response.grandTotal);
                    $("#discount_value").html(response.discount);
                    $("#discount_reponse").html('');
                }
            }
        });
     });


   </script>
@endsection