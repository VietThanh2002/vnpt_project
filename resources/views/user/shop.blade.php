@extends('user.layouts.app')

@section('content')
    <section class="section-6 pt-5" style="margin-left: 60px;  margin-bottom: 20px; margin-top: 160px;">
        <div class="container-fluid">
            <div class="row">            
                <div class="col-md-3 sidebar">
                    <div class="card">
                        <div class="mt-3 sub-title text-center">
                            <h3 class="fw-bold">Danh mục dịch vụ</h3>
                        </div><hr>
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if ($categories->isNotEmpty())
                                    @foreach ($categories as $key => $category)
                                    <div class="accordion-item">
                                        @if ($category->sub_category->isNotEmpty())
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne-{{ $key }}" aria-expanded="false" aria-controls="collapseOne-{{ $key}}">
                                             {{ $category->name}}
                                            </button>
                                        </h2>
                                        @else
                                            <a href="{{ route("user.shop", $category->slug)}}" class="nav-item nav-link  {{ ($categorySelected == $category->id) ? 'text-primary' : ''}}" style="margin-left:20px;">{{$category->name}}</a>
                                        @endif

                                        @if ($category->sub_category->isNotEmpty())
                                            <div id="collapseOne-{{ $key }}" class="accordion-collapse collapse {{ ($categorySelected == $category->id) ? 'show' : ''}}" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                                <div class="accordion-body">
                                                    <div class="navbar-nav">
                                                       @foreach ($category->sub_category as $subcategory)
                                                            <a href="{{ route("user.shop", [$category->slug, $subcategory->slug]) }}" class="nav-item nav-link {{ ($subCategorySelected == $subcategory->id) ? 'text-primary' : ''}}">{{$subcategory->name}}</a>
                                                       @endforeach                                     
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>  
                                    @endforeach
                                @endif
                                                                                    
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 card">                    
                        <div class="text-center sub-title mt-3">
                            <h3>Giá</h3>
                        </div><hr>
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row" style="margin-left: 50px;">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest" {{ ($sort == 'latest') ? 'selected' : ''}}>Mới nhất</option>
                                        <option value="price_desc" {{ ($sort == '"price_desc') ? 'selected' : ''}}>Giá giảm dần</option>
                                        <option value="price_asc" {{ ($sort == 'price_asc') ? 'selected' : ''}}>Giá tăng dần</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if ($products->isNotEmpty())
                        @foreach ($products as $product)
                            @php
                                $productImage =  $product->product_images->first();
                            @endphp
                            <div class="col-lg-3 col-sm-12 col-md-4 list-group-item me-1 rounded-1">
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
                                    </div>
                                </div>
                                <div class="text-center">
                                    <a class="btn border-info" href="{{ route("user.product", $product->slug) }}">Xem chi tiết</a>
                                </div>
                            </div>
                        @endforeach
                    @endif              
                    
                        <div class="col-md-12 pt-5">
                            {{ $products->withQueryString()->links()}} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script>
        function addService(id){
           $.ajax({
                url: '{{ route("user.addService") }}',
                type: 'post',
                data: {id:id},
                dataType: 'json',
                success: function(response){
                    if(response.status == true){
                        window.location.href = "{{ route('user.checkout') }}";
                    }else{
                        alert(response.message)
                    }
                } 
           });
        };
        
        rangeSlider = $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: 0,
            max: 10000000,
            from: {{ $priceMin }},
            step: 100,
            to:  {{ $priceMax}},
            skin: "round",
            // max_postfix: "+",
            postfix: "đ",
            onFinish: function(){
        apply_filters();
            }
        });

        var slider = $(".js-range-slider").data("ionRangeSlider");

        // chọn thương hiệu

        $("#sort").change(function () {
            apply_filters();
        });

        function apply_filters(){
           // console.log(brands.toString());

            var url =  '{{ url()->current() }}?'; // lấy url hiện tại
            // giá tiền kéo lọc

            url += '&price_min='+slider.result.from+'&price_max='+slider.result.to;
            // sort 
            var keyword = $("#search").val();

            if(keyword.length > 0){
                url += '&search='+ keyword;
            }

            url += '&sort='+$("#sort").val();

            window.location.href = url;

        }
    </script>
@endsection

    


