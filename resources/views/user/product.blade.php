@extends('user.layouts.app')

@section('content')
<section class="section-5 pt-3 pb-3 mb-3 bg-white" style="margin-top: 180px">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('user.home')}}">Trang chủ</a></li>
                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('user.shop') }}">Sản phẩm</a></li> 
                <li class="breadcrumb-item">{{ $product->name}}</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            <div class="col-md-5">
                <div class="w-75" style="margin-left: 100px;">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">
                           @if ($product->product_images)
                               @foreach ($product->product_images as $key => $image)
                                   <div class="carousel-item {{ ($key == 0) ? 'active' : ''}}">
                                        <img class="img-thumbnail product-detail-img" src="{{ asset('/uploads/product/'.$image->image) }}" alt="Image">
                                   </div>
                               @endforeach
                           @endif
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="right shadow rounded-3" style="background-color: white">
                    <div class="p-3">
                        <h5 class="m-2">Tên sản phẩm: <span class="fw-bold">{{ $product->name}}</span></h5>
                        {{-- <div class="overall-rating mb-3">
                            <div class="d-flex">
                                <div class="star-rating mt-2" title="70%">
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        
                                        <div class="front-stars" style="width: {{ $avgRatingPercent }}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>  
                                <div class="pt-2 ps-2">({{ ($product->product_ratings_count > 1) ? $product->product_ratings_count : '0'}}) :Lượt đánh giá</div>
                            </div>
                        </div> --}}
                        <div class="">
                            @if (!empty($product->compare_price))
                                <span class="h5 m-2 text-underline">Giá sản phẩm: <del class="text-danger fw-bold">{{ formatPriceVND($product->compare_price)}}</del></span>
                                <span class="h5 m-2"><strong><del class="text-danger text-decoration-line-through">{{  formatPriceVND($product->price) }}</span></strong></span>
                            @else
                                <span class="h5 m-2">Giá sản phẩm: <strong><span class="text-danger fw-bold">{{  formatPriceVND($product->price) }}</span></strong></span>
                            @endif
                        </div>
                        <div class="h5 m-2" style="text-align: justify;">Mô tả ngắn: <span class="ms-2">{!!$product->short_des!!}</span></div>
                        <h5 class="h5 m-2">Bảo hành: <span class="fw-bold">{{ $product->guarantee}}</span></h5>
                        @if ($product->track_qty == 'Yes')
                            @if ($product->qty > 0)
                                <h5 class="h5 m-2">Tình trạng: <span class="text-success fw-bold">Còn kinh doanh</span></h5>
                            @else
                                <h5 class="h5 m-2">Tình trạng: <span class="text-danger fw-bold">Ngừng kinh doanh</span></h5>
                            @endif
                        @endif
                        <div class="text-center">
                            @if ($product->track_qty == 'Yes')
                                @if ($product->qty > 0)
                                    <button class="btn_cart">
                                        <a href="javascript:void(0);" onclick="addToCart( {{ $product->id }});" class="fa-solid fa-cart-shopping text-danger"></a>
                                    </button>
                                @else
                                    <button disabled class="btn_cart">
                                        <a href="javascript:void(0);" onclick="addToCart( {{ $product->id }});" class="fa-solid fa-cart-shopping text-danger"></a>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Mô tả chi tiết</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Chính sách đổi trả và vận chuyển</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Đánh giá sản phẩm</button>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p class="m-2 p-2" style="text-align: justify">{!!  $product->des !!}</p>
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <p class="m-2 p-2" style="text-align: justify">{{ strip_tags($product->shipping_returns) }}</p>
                        </div>

                        <!-- ratingModal -->
                        <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Cảm ơn bạn đã gửi đánh giá sản phẩm</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                ...
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                            </div>
                        </div>
                         <!-- ratingModal -->
  
                        {{-- <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <div class="col-md-8">
                                <div class="row">
                                    <form action="" method="post" name="ratingForm" id="ratingForm">
                                        <h3 class="h4 pb-3">Viết đánh giá</h3>
                                        <div class="form-group col-lg-6 mb-3">
                                            <label for="name">Tên khách hàng</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Vui lòng điền họ và tên">
                                            <p></p>
                                        </div>
                                        <div class="form-group col-lg-6 mb-3">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Vui lòng nhập email">
                                            <p></p>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="rating">Xếp hạng</label>
                                            <br>
                                            <div class="rating" style="width: 10rem">
                                                <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-4" type="radio" name="rating" value="4"/><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                            </div>
                                            <p class="product-rating-error text-danger"></p>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="">Trải nghiệm sản phẩm của bạn như thế nào ?</label>
                                            <textarea name="comment" id="comment" class="form-control" cols="30" rows="6" placeholder="Bạn có thể để lại đánh giá tại đây"></textarea>
                                            <p></p>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-danger">Gửi</button>
                                        </div>
                                    </form>   
                                </div>
                            </div>
                            <div class="col-md-12 mt-5">
                                <div class="overall-rating mb-3">
                                    <div class="d-flex">
                                        <h1 class="h3 pe-3">{{ $avgRating }}</h1>
                                        <div class="star-rating mt-2" title="70%">
                                            <div class="back-stars">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                
                                                <div class="front-stars" style="width: {{ $avgRatingPercent }}%">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>  
                                        <div class="pt-2 ps-2">({{ ($product->product_ratings_count > 1) ? $product->product_ratings_count : '0'}}) :Lượt đánh giá</div>
                                    </div>
                                    
                                </div>
                                @if (!empty($product->product_ratings))
                                    @foreach ($product->product_ratings as $rating)
                                        <div class="rating-group mb-4">
                                            <span> <strong>{{ $rating->user_name }}</strong></span>
                                            @php
                                                $ratingPercent = ($rating->rating*100)/5;  //1 sao= 20%
                                            @endphp
                                            <div class="star-rating mt-2" title="70%">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    
                                                    <div class="front-stars" style="width: {{  $ratingPercent }}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="my-3">
                                                <p>{{ $rating->comment }}
                                            </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div> 
        </div>           
    </div>
</section>


<section class="pt-5 section-8">
    <div class="container">
        <div class="section-title text-center">
            <h2>Sản phẩm liên quan</h2>
        </div> 
        <div class="row gx-3">
            @if (!empty($relatedProducts))
            @foreach ($relatedProducts as $product)
                @php
                    $productImage =  $product->product_images->first();
                @endphp
                <div class="col-lg-3 col-sm-12 col-md-4 list-group-item me-1 rounded-3">
                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>     
                    <div class="product_img position-relative">
                        <a href="{{ route("user.product", $product->slug) }}" class="product-img">
                            @if (!empty($productImage->image))
                                <img clas="card-img-top" src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="50" > 
                            @else
                                <img clas="card-img-top" src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="50" > 
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
                            <span class="h6 text-underline"><del> {{ formatPriceVND($product->compare_price) }}</del></span>
                           @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn_cart">
                            <a href="javascript:void(0);" onclick="addToCart( {{ $product->id }});" class="fa-solid fa-cart-shopping"></a>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center">Không có sản phẩm phẩm liên quan</p>
        @endif  
        </div>
    </div>
</section>
@endsection

@section('js')
    <script type="text/javascript">
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
        };

        // $("#ratingForm").submit(function (event){
        //     event.preventDefault();

        //     $.ajax({
        //         url: '{{ route("user.saveRating", $product->id )}}',
        //         type: 'post',
        //         data: $(this).serializeArray(),
        //         dataType: 'json',
        //         success: function(response){
        //             if(response.status == true){
        //                 $("button[type=submit]").prop('disabled', false);

        //                 $("#ratingModal .modal-body").html(response.message);
        //                 $("#ratingModal").modal('show');

        //                 setTimeout(function() {
        //                     window.location.href = "{{ route('user.product', $product->slug) }}";
        //                 }, 4000);

        //             }else{
        //                 var errors = response['errors'];

        //                 if(errors['name']){
        //                     $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
        //                 }else{
        //                     $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
        //                 }
                        
        //                 if(errors['email']){
        //                     $('#email').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['email']);
        //                 }else{
        //                     $('#email').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
        //                 }

        //                 if(errors['rating']){
        //                    $(".product-rating-error").html(errors.rating);
        //                 }else{
        //                     $(".product-rating-error").html('');
        //                 }

        //                 if(errors['comment']){
        //                     $('#comment').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['comment']);
        //                 }else{
        //                     $('#comment').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
        //                 }
        //             }
        //         } 
        //    });
        // });

    </script>
@endsection