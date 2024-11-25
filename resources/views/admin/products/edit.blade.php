@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">	
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cập nhật dịch vụ</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.index')}}" class="btn btn-primary">Trở về</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<form action="" method="post" id="productForm" name="productForm">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="Name">Tên sản phẩm</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="title">Tên không dấu</label>
                                        <input readonly type="text" name="slug" id="slug" class="form-control" value="{{$product->slug}}">
                                        <p class="error"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price">Giá dịch vụ</label>
                                        <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ $product->price}}">
                                        <p class="error"></p>	
                                    </div>
                                </div>   

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="des">Mô tả</label>
                                        <textarea name="des" id="des" cols="30" rows="10" class="summernote" placeholder="Nhập mô tả">{{ $product->des}}</textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>
                             
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="short_des">Mô tả ngắn</label>
                                        <textarea name="short_des" id="short_des" cols="30" rows="10" class="summernote" placeholder="Nhập mô tả">{{ $product->short_des}}</textarea>
                                        <p class="error"></p>
                                    </div>
                                </div>
                            
                              
                            </div>
                        </div>	                                  
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h2 class="h4 mb-3">Media</h2>
                            <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">    
                                    <br>Thả tập tin vào đây hoặc bấm vào để tải lên.<br><br>                             
                                </div>
                            </div>
                        </div>	                                  
                    </div>
                    <div class="row" id="product-gallery">
                        @if ($productImages->isNotEmpty())
                            @foreach ($productImages as $image)
                                <div class="card" id="image-row-{{ $image->id }}" style="width: 10rem;">
                                    <input type="hidden" name="image_array[]" value="{{ $image->id }}">
                                    <div class="mt-2 d-flex justify-content-center">
                                        <img src="{{ asset('/uploads/product/' .$image->image)}}" class="img-thumbnail card-img-top w-50"  alt="...">
                                    </div>
                                    <div class="card-body d-flex justify-content-center">
                                        <a href="javascript:void(0)" onclick="deleleImage({{ $image->id }})" class="btn btn-danger btn-sm"><i class='bx bx-trash'></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Trạng thái sản phẩm</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($product->status == 1) ? 'selected' : ''}} value="1">Action</option>
                                    <option {{ ($product->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Danh mục sản phẩm</h2>
                            <div class="mb-3">
                                <label for="category">Danh mục</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Chọn danh mục sản phẩm</option>
                                    @if ($categories->isNotEmpty())
                                       @foreach ($categories as  $categorie)
                                            <option {{ ($product->category_id == $categorie->id) ? 'selected' : ''  }} value="{{ $categorie->id}}" >{{ $categorie->name }}</option>
                                       @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="category">Danh mục con</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">Chọn danh mục phụ</option>
                                    @if ($subCategories->isNotEmpty())
                                        @foreach ($subCategories as $subCategory)
                                            <option {{ ($product->sub_category_id ==  $subCategory->id) ? 'selected' : ''  }} value="{{ $subCategory->id}}">{{ $subCategory->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>                          
                </div>
            </div>
		
		<div class="pb-5 pt-3">
			<button type="submit" class="btn btn-primary">Cập nhật</button>
			<a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Trở về</a>
		</div>
	</div>
    </form>
	<!-- /.card -->
</section>
<!-- /.content -->   
@endsection

@section('js')

    <script> 

        $("#productForm").submit(function(event){
            event.preventDefault();
            var fromArray = $(this).serializeArray();
            $("button[type=submit]").prop('disabled', true); 

            $.ajax({
                url: '{{ route("products.update", $product->id)}}',
                type: 'put',
                data: fromArray,
                dataType: 'json',
                success: function(response){
                    if(response['status'] == true){
                        $("button[type=submit]").prop('disabled', false); 

                        window.location.href  = "{{route('products.index')}}";

                    }else{
                        var errors = response['errors'];

                        $(".error").removeClass('invalid-feedback').html('');

                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');

                        $.each(errors, function(key, value){
                            $(`#${key}`).addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(value);

                        });
                
                    }

                },
                error: function(){
                    console.log("Xảy ra lỗi!!");
                }
            });
        });



        $("#category").change(function(){
            var category_id = $(this).val();

            $.ajax({
                url: '{{ route("product-subcategories.index") }}',
                type: 'get',
                data: {category_id:category_id},
                dataType: 'json',
                success: function(response){
                    console.log(response);

                    $("#sub_category").find("option").not(":first").remove();
                    $.each(response["subCategories"], function(key, item){
                        $("#sub_category").append(`<option value='${item.id}'>${item.name}</option>`)
                    })
                },
                error: function(){
                    console.log("Xảy ra lỗi!!");
                }
            });
        });

        $("#name").change(function (){
            element = $(this);
            $("button[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route("getLSlug") }}',
                type: 'get',
                data: {title: element.val()}, 
                dataType: 'json',
                success: function(response){
                    if(response['status'] == true){
                        $("button[type=submit]").prop('disabled', false);
                        // khi giá trị của trường "name" thay đổi và yêu cầu Ajax thành công, 
                        //nút "submit" sẽ được kích hoạt lại, và giá trị của trường "slug" sẽ được cập nhật dựa trên kết quả từ server.
                        $("#slug").val(response['slug']);
                    }
                }
            });
        });

        Dropzone.autoDiscover = false;   
            const dropzone = $("#image").dropzone({


            url:  "{{ route('product-images.update') }}",
            maxFiles: 10,
            paramName: 'image',
            params: {'product_id': '{{ $product->id}} '},
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg, image/png, image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                // $("#image_id").val(response.image_id);
                //console.log(response)
               var html = ` <div class="card" id="image-row-${response.image_id}" style="width: 10rem;">
                                <input type="hidden" name="image_array[]" value="${response.image_id}">
                                <img src="${response.ImagePath}" class="img-thumbnail card-img-top w-50 h-50 p-2 "  alt="...">
                                <div class="card-body">
                                    <a href="javascript:void(0)" onclick = "deleleImage(${response.image_id})"  class="btn btn-primary">Delete</a>
                                </div>
                            </div>`

                            $("#product-gallery").append(html);
                    },
                    complete: function(file){
                        this.removeFile(file);
                    }
        });

        function deleleImage(id){
            if (confirm("Bạn có muốn xóa ảnh này?")) {
                $("#image-row-"+id).remove();
                $.ajax({
                    url: '{{ route("product-images.destroy") }}',
                    type: 'post', // Sử dụng phương thức POST thay vì DELETE
                    data: { _method: 'delete', id: id }, // Thêm _method để chỉ định phương thức DELETE
                    success: function(response){
                        if(response.status == true){
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Xảy ra lỗi trong quá trình xóa ảnh!");
                    }
                });
            }
        }



    </script>
@endsection
