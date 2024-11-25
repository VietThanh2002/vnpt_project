@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">	
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Thêm số điện thoại</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('sim-card.index') }}" class="btn btn-primary"><i class='bx bx-arrow-back'></i></a>
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
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title">Số sim</label>
                                        <input value="{{ $simCard->sim_number }}" type="text" name="sim_number" id="sim_number" class="form-control" placeholder="Nhập tên dịch vụ">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price">Giá sim</label>
                                        <input value="{{ $simCard->price }}"  type="text" name="price" id="price" class="form-control" placeholder="Giá">
                                        <p class="error"></p>	
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sim_type">Loại sim</label>
                                        <select name="sim_type" id="sim_type" class="form-control">
                                            <option  {{ ($simCard->sim_type == 'Trả trước') ? 'selected' : ''}} value="Trả trước" >Thuê bao trả trước</option>
                                            <option  {{ ($simCard->sim_type == 'Trả sau') ? 'selected' : ''}} value="Trả sau" >Thuê bao trả sau</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>	                                  
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">	
                            <h2 class="h4 mb-3">Trạng thái dịch vụ</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option  {{ ($simCard->status == 1) ? 'selected' : ''}} value="1">Còn khinh doanh</option>
                                    <option  {{ ($simCard->status == 0) ? 'selected' : ''}} value="0">Ngưng khi doanh</option>
                                </select>
                                <p class="error"></p>	
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">	
                            <h2 class="h4  mb-3">Danh mục sản phẩm</h2>
                            <div class="mb-3">
                                <label for="category">Danh mục</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Chọn loại sản phẩm</option>
                                    @if ($categories->isNotEmpty())
                                       @foreach ($categories as $cate)
                                        <option {{ ($simCard->category_id == $cate->id) ? 'selected' : ''  }} value="{{$cate->id}}"> {{$cate->name }}</option>
                                       @endforeach
                                    @endif
                                </select>
                                <p class="error"></p>	
                            </div>
                            <div class="mb-3">
                                <label for="category">Danh mục con</label>
                                <select name="sub_category" id="sub_category" class="form-control">
                                    <option value="">Chọn danh con</option>
                                    @if ($subCategories->isNotEmpty())
                                    @foreach ($subCategories as $subCategory)
                                        <option {{ ($simCard->sub_category_id ==  $subCategory->id) ? 'selected' : ''  }} value="{{ $subCategory->id}}">{{ $subCategory->name }}</option>
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
			<a href="{{ route('sim-card.index') }}" class="btn btn-outline-dark ml-3">Trở về</a>
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
                url: '{{ route("sim-card.update", $simCard->id)}}',
                type: 'put',
                data: fromArray,
                dataType: 'json',
                success: function(response){
                    if(response['status'] == true){

                        window.location.href  = "{{route('sim-card.index')}}";

                    }else{
                        
                        $("button[type=submit]").prop('disabled', false); 

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
    </script>
@endsection
