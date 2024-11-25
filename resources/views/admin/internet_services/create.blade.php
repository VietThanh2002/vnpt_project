@extends('admin.layouts.app')

@section('content')
  				<!-- Content Header (Page header) -->
    <section class="content-header">      
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Thêm dịch vụ internet</h1>
        		</div>
        		<div class="col-sm-6 text-right">
        			<a href="categories.html" class="btn btn-primary">Trở về</a>
        		</div>
        	</div>
        </div>
        <!-- /.container-fluid -->
	</section>
				<!-- Main content -->
	<section class="content">
        <form action="" method="post" id="serviceForm" name="serviceForm">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">     			
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="service_name">Tên dịch vụ</label>
                                    <input type="text" name="service_name" id="name" class="form-control" placeholder="Nhập tên dịch vụ">
                                    <p></p>	
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email">Tên không dấu</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                     {{-- readonly thuộc tính làm cho ô nhập liệu chỉ có thể đọc chứ không thể nhập dữ liệu vào --}}	
                                    <p></p>
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label for="category_id">Danh mục</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>  
                                        <p></p>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Giá</label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Nhập giá">
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="speed">Tốc độ</label>
                                    <input type="text" name="speed" id="speed" class="form-control" placeholder="Nhập tốc độ">
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description">Mô tả</label>
                                    <textarea class="summernote" name="description" id="description" class="form-control" placeholder="Nhập mô tả"></textarea>
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description">Mô tả ngắn</label>
                                    <textarea class="summernote" name="short_des" id="short_des" class="form-control" placeholder="Nhập mô tả ngắn"></textarea>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Còn kinh doanh</option>
                                        <option value="0">Ngừng kinh doanh</option>
                                    </select>
                                </div>
                            </div>
                              
                            <div class="col-md-6">
                                <div class="mb-3">
                                 <input type="text" id="image_id" name="image_id" value="">
                                  <label for="image">Hình ảnh</label>
                                  <div id="image" class="dropzone dz-clickable">
                                     <div class="dz-message needsclick">    
                                         <br>Thả tập tin vào đây hoặc bấm vào để tải lên.<br><br>                                           
                                     </div>
                                 </div>
                                </div>
                             </div> 

                        </div>
                    </div>      		
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Trở về</a>
                </div>
            </div>
            <!-- /.card -->
         </form>
</section>
				<!-- /.content -->
@endsection

@section('js')
<script>

    $("#serviceForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true); //sử dụng để tắt khả năng kích hoạt nút "submit" trong biểu mẫu (form) sau khi người dùng đã nhấp vào nút "Create".
        $.ajax({

            url: '{{ route("internet_services.store") }}',
            type: 'post',
            data: element.serializeArray(), //chuyển dữ liệu thành 1 đối tượng json và gửi đi
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', true);

                if(response["status"] == true){

                    window.location.href  = "{{route('internet_services.index')}}";

                    $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#price').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#speed').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#description').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#short_des').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#category_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    
                    window.location.href  = "{{route('internet_services.index')}}";

                }else{

                    $("button[type=submit]").prop('disabled', false);

                    var errors = response['errors'];

                    if(errors['service_name']){
                        $('#service_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['service_name']);
                    }else{
                        $('#service_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['category_id']){
                        $('#category_id').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['category_id']);
                    }else{
                        $('#category_id').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['slug']){
                        $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
                    }else{
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['price']){
                        $('#price').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['price']);
                    }else{
                        $('#price').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['speed']){
                        $('#speed').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['speed']);
                    }else{
                        $('#speed').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['description']){
                        $('#description').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['description']);
                    }else{
                        $('#description').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['short_des']){
                        $('#short_des').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['short_des']);
                    }else{   
                        $('#short_des').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }
                }

            }, error: function(jqXHR, exception){

                console.log("Xảy ra lỗi!!");
            }
        })
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
                    $("#slug").val(response['slug']);
                }
            }
        });
    });

        Dropzone.autoDiscover = false;   
        const dropzone = $("#image").dropzone({ 
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },
        url:  "{{ route('temp-images.create') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif,image/jpg, image/svg",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            //console.log(response)
        }
    });
</script>
@endsection