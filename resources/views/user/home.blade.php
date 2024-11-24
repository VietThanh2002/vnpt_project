@extends('user.layouts.app')

@section('content')
<section class="section-1" style="margin-top: 160px">
   <div class="container-fluid">
        <div class="row gx-0">
            <div class="col-sm-12">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{ asset('user-assets/image/1.jpg') }} " class="img-baner d-block " alt="..." style="height: auto; width: 100%;">
                      </div>
                      <div class="carousel-item">
                        <img src="{{ asset('user-assets/image/2.jpg') }} " class="img-baner d-block" alt="..." style="height: auto; width: 100%;">
                      </div>
                      <div class="carousel-item">
                        <img src="{{ asset('user-assets/image/3.jpg') }} " class="img-baner d-block" alt="..." style="height: auto; width: 100%;">
                      </div>
                      <div class="carousel-item">
                        <img src="{{ asset('user-assets/image/4.png') }} " class="img-baner d-block" alt="..." style="height: auto; width: 100%;">
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
            </div>
        </div>
   </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title text-center">
            <h2>CÁC SẢN PHẨM NỔI BẬC</h2>
        </div>    
        <div class="row gx-3" style="margin-left: 50px">
            @if ($featuredProducts->isNotEmpty())
                @foreach ($featuredProducts as $product)
                    @php
                        $productImage =  $product->product_images->first();
                    @endphp
                    <div class="col-lg-3 col-sm-12 col-md-4 list-group-item me-1 rounded-1">
                        <a href="javascript:void(0);" onclick="addToWishlist({{ $product->id}})" class="whishlist d-flex justify-content-end m-2"><i class="far fa-heart"></i></a>     
                        <div class="product_img position-relative">
                            <a href="{{ route("user.product", $product->slug) }}" class="product-img">
                                @if (!empty($productImage->image))
                                    <img src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="50" > 
                                @else
                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
                                @endif
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="product_name">
                                {{$product->name}}
                            </div>
                            <div class="product_price">
                                <span class="h5"><strong> {{  formatPriceVND($product->price) }}</strong></span>
                               @if ($product->compare_price > 0)
                                <span class="h6 text-underline"><del> {{ formatPriceVND($product->compare_price)}}</del></span>
                               @endif
                            </div>
                        </div>
                        <div class="text-center">
                            @if ($product->track_qty == 'Yes')
                                @if ($product->qty > 0)
                                    <button class="btn_cart">
                                        <a href="javascript:void(0);" onclick="addToCart( {{ $product->id }});" class="fa-solid fa-cart-shopping text-danger"></a>
                                    </button>
                                @else
                                    <p class="text-center">
                                        Sản phẩm này đã hết hàng
                                    </p>
                                @endif
                            @else
                                <button class="btn_cart">
                                    <a href="javascript:void(0);" onclick="addToCart( {{ $product->id }});" class="fa-solid fa-cart-shopping text-danger"></a>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif              
        </div>
    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title text-center">
            <h2>SẢN PHẨM MỚI</h2>
        </div>    
        <div class="row gx-3" style="margin-left: 50px">
            @if ($latestProducts->isNotEmpty())
                @foreach ($latestProducts as $latestProduct)
                    @php
                        $productImage =  $latestProduct->product_images->first();
                    @endphp
                    <div class="col-lg-3 col-sm-12 col-md-4 list-group-item me-1 rounded-1">
                        <a href="javascript:void(0);" onclick="addToWishlist({{ $product->id}})" class="whishlist d-flex justify-content-end m-2"><i class="far fa-heart"></i></a>     
                        <div class="product_img position-relative">
                            <a href="{{ route("user.product", $latestProduct->slug) }}" class="product-img">
                                @if (!empty($productImage->image))
                                    <img src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="50" > 
                                @else
                                    <img src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
                                @endif
                            </a>
                        </div>
                        <div class="card-body">

                            <div class="product_name">
                                {{$latestProduct->name}}
                            </div>
                            <div class="product_price">
                                <span class="h5 m-2"><strong>{{  formatPriceVND($latestProduct->price) }}</strong></span>
                            </div>
                        </div>
                        <div class="text-center">
                            @if ($product->track_qty == 'Yes')
                                @if ($product->qty > 0)
                                    <button class="btn_cart">
                                        <a href="javascript:void(0);" onclick="addToCart( {{ $product->id }});" class="fa-solid fa-cart-shopping text-danger"></a>
                                    </button>
                                @else
                                    <p class="text-center">
                                        Sản phẩm này đã hết hàng
                                    </p>
                                @endif
                            @else
                                <button class="btn_cart">
                                    <a href="javascript:void(0);" onclick="addToCart( {{ $product->id }});" class="fa-solid fa-cart-shopping text-danger"></a>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif              
        </div>
    </div>
</section>

<hr>
@endsection

@section('js')
    <script>
            function addToCart(id){
                $.ajax({
                        url: '{{ route("user.addToCart") }}',
                        type: 'post',
                        data: {id:id},
                        dataType: 'json',
                        success: function(response){
                            if(response.status == true){
                                window.location.href = "{{ route('user.cart') }}";
                            }else{
                                alert(response.message)
                            }
                        } 

                });
            }
    </script>   
@endsection
