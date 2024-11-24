@extends('user.layouts.app')

@section('content')
<section class=" section-11" style="margin-top: 200px; margin-bottom: 30px">
    <div class="container  mt-5">
        <div class="row gx-5">
            <div class="col-md-3">
                @include('user.component.sidebar')
            </div>
            <div class="col-md-9">
                @include('user.message')
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2 text-center">Sản phẩm yêu thích</h2>
                    </div>
                    <div class="card-body p-4">
                        @if (!empty($wishlists))
                            @foreach ($wishlists as $item)
                                <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                    <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                        <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route("user.product", $item->product->slug) }}" style="width: 10rem;">
                                            @php
                                                $productImage = getProductImage($item->product_id);
                                            @endphp
                                            @if (!empty($productImage))
                                                <img src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="50" > 
                                            @else
                                                <img src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
                                            @endif
                                        </a>
                                        <div class="pt-2">
                                            <h3 class="product-title fs-base mb-2"><a href="#" class="text-dark">{{ $item->product->name}}</a></h3>                                        
                                            <div class="fs-lg text-accent pt-2">
                                                <span class="h5"> {{ formatPriceVND($item->product->price) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-2 text-center">
                                        <button onclick="removeProduct({{ $item->product_id }})" class="btn btn-sm border-info d-flex justify-content-sm-center" type="button"><i class="fas fa-trash-alt text-danger"></i></button>
                                    </div>
                                </div>  
                            @endforeach
                        @else
                            <div>
                                <p class="Danh sách sản phẩm yêu thích trống"></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>   
@endsection

@section('js')
<script>
    function removeProduct(id){
        if(confirm("Bạn có chắc muốn xóa sản phẩm yêu thích này?")){
            $.ajax({
                    url: '{{ route("user.removeWishList") }}',
                    type: 'delete',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response){
                        if(response.status == true){
                            window.location.href = "{{ route('user.wishList') }}";
                        }else{
                            alert(response.message)
                        }
                    } 

            });
        }
    }
</script>   
@endsection