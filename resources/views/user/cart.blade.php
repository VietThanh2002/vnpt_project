@extends('user.layouts.app')

@section('content')

<section class="section-5" style="margin-top: 170px;">
        <div class="text-center">
            <p class="fs-3">Giỏ hàng</p>
        </div>
</section>

<section class=" section-9 pt-4" style="margin-bottom: 100px;">
    <div class="container">
        <div class="row">
            @if (Session::has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show w-50" role="alert">
                            {{ Session::get('success')}}
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                </div>
            @endif

            @if (Session::has('error'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show w-50" role="alert">
                        {{ Session::get('error')}}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                 </div>
            </div>
        @endif
        @if (Cart::count() > 0)
            <div class="col-sm-12 col-md-12">
                <div class="table-responsive">
                    <table class="table table-condensed" id="cart">
                        <thead class="table-bordered table-borderless table-info text-center">
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                                @foreach ($cartContent as $item)
                                    <tr>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center justify-content-center">
                                                @if (!empty($item->options->productImage->image))
                                                    <img clas="card-img-top" src="{{ asset('/uploads/product/'.$item->options->productImage->image) }} " class="img-thumbnail" width="50" > 
                                                @else
                                                    <img clas="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
                                                @endif

                                            </div>
                                        </td>
                                        <td><p>{{ $item->name }}</p></td>
                                        <td>{{ formatPriceVND($item->price) }}</td>
                                        <td>
                                            <div class="input-group quantity mx-auto" style="width: 100px; background-color: azure">
                                                <div class="input-group-btn">
                                                    <button class="sub btn btn-sm btn-minus" data-id="{{ $item->rowId }}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm border-0 text-center" value="{{ $item->qty }}">
                                                <div class="input-group-btn">
                                                    <button class="add btn btn-sm btn-plus" data-id="{{ $item->rowId }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                           {{ formatPriceVND(($item->price)*($item->qty)) }}
                                        </td>
                                        <td>
                                            <button onclick="deleteCart('{{ $item->rowId }}');" class="btn btn-sm btn-danger rounded-circle"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>    
                                @endforeach
                                               
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">            
                <div class="card cart-summery">
                    <div class="sub-title">
                        <h3 class="bg-white m-1 p-1 text-center">Thông tin giỏ hàng</h3>
                    </div> 
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <div>Tổng tiền:</div>
                            <div>{{ formatPriceVND(Cart::Subtotal()) }}</div>
                        </div>
                        <hr>
                        <div class="d-flex mt-2">
                            <div class="justify-content-start m-2">
                                <a href="{{ route('user.shop') }}" class="btn-secondary btn btn-block btn-sm">Tiếp tục mua hàng</a>
                            </div>
                            <div class="justify-content-start m-2">
                                <a href="{{ route('user.checkout') }}" class="btn-danger btn btn-block btn-sm">Thanh toán</a>
                            </div>
                        </div>
                    </div>
                </div>     
            </div>
            @else
                <div class="text-center" style="margin-bottom: 80px;">
                    <p>Giỏ hàng rỗng</p>
                    <div class="btn btn-sm btn-success">
                        <a class="text-white" href="{{ route('user.shop') }}">Tiếp tục mua hàng </a>
                    </div>
                </div>
            @endif  
        </div>
    </div>
</section>  
@endsection

@section('js')
    <script>
      $('.add').click(function(){
            var qtyElement = $(this).parent().prev(); // Qty Input
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue < 10) {
                qtyElement.val(qtyValue+1);
                var rowId = $(this).data('id'); 
                var newQty = qtyElement.val();
                updateCart(rowId, newQty);
            }            
        });

        $('.sub').click(function(){
            var qtyElement = $(this).parent().next(); 
            var qtyValue = parseInt(qtyElement.val());
            if (qtyValue > 1) {
                qtyElement.val(qtyValue-1);
                var rowId = $(this).data('id'); 
                var newQty = qtyElement.val();
                updateCart(rowId, newQty);
            }        
        });


        function updateCart(rowId, qty){
            $.ajax({
                url: '{{ route("user.updateCart") }}',
                type: 'post',
                data: {rowId:rowId, qty:qty},
                dataType: 'json',
                success: function(response){
                    window.location.href = '{{ route("user.cart") }}';
                }
            });
        }

        function deleteCart(rowId){
           if(confirm('Bạn muốn xóa sản phẩm này')){
                $.ajax({
                    url: '{{ route("user.deleteItem.cart") }}',
                    type: 'delete',
                    data: {rowId:rowId},
                    dataType: 'json',
                    success: function(response){
                        window.location.href = '{{ route("user.cart") }}';
                    }
                });
            }
        }

    </script> 
@endsection