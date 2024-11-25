@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">      
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sửa dịch vụ internet</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('internet_services.index') }}" class="btn btn-primary">Trở về</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <form action="{{ route('internet_services.update', $internetService->id) }}" method="post" id="internetServiceForm" name="internetServiceForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">     			
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="service_name">Tên</label>
                                    <input type="text" name="service_name" id="service_name" value="{{ $internetService->service_name}}" class="form-control" placeholder="Name">
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email">Tên không dấu</label>
                                    <input type="text" readonly name="slug" id="slug" value="{{ $internetService->slug}}" class="form-control" placeholder="Slug">
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
                                            @foreach ($categories as $category)
                                                <option {{ ($category->id == $internetService->category_id) ? 'selected' : ''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                     </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Giá</label>
                                    <input type="text" name="price" id="price" value="{{ $internetService->price}}" class="form-control" placeholder="Price">
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="speed">Tốc độ</label>
                                    <input type="text" name="speed" id="speed" value="{{ $internetService->speed}}" class="form-control" placeholder="Speed">
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description">Mô tả</label>
                                    <textarea class="summernote" name="description" id="description" class="form-control" placeholder="Description">{{ $internetService->description}}</textarea>
                                    <p></p>	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="short_des">Mô tả ngắn</label>
                                    <textarea class="summernote" name="short_des" id="short_des" class="form-control" placeholder="Short Description">{{ $internetService->short_des}}</textarea>
                                    <p></p>	
                                </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="hidden" id="image_id" name="image_id" value="{{ $internetService->image_id}}">
                                    <label for="image">Hình ảnh</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message
                                        needsclick">    
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($internetService->status == 1) ? 'selected' : ''}} value="1">Action</option>
                                        <option {{ ($internetService->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if (!empty($internetService->image))
                                    <div class="">
                                        <img class="img-thumbnail" src="{{ asset('uploads/service/'.$internetService->image)}}" alt="" style="height: 200px; width: 200px;">
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                    <!-- /.card-footer-->
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

                url: '{{ route("internet_services.update", $internetService->id) }}',
                type: 'put',
                data: element.serializeArray(), //chuyển dữ liệu thành 1 đối tượng json và gửi đi
                dataType: 'json',
                success: function(response){

                    if(response["status"] == true){
                        // window.location.href = "{{route('internet_services.index')}}";
                        $("button[type=submit]").prop('disabled', true);


                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#price').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#speed').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#description').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        $('#short_des').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        
                    }else{

                        $("button[type=submit]").prop('disabled', false);

                        var errors = response['errors'];

                        if(errors['service_name']){
                            $('#service_name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['service_name']);
                        }else{
                            $('#service_name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
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

        $("#service_name").change(function (){
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
                        // khi giá trị của trường "service_name" thay đổi và yêu cầu Ajax thành công, 
                        //nút "submit" sẽ được kích hoạt lại, và giá trị của trường "slug" sẽ được cập nhật dựa trên kết quả từ server.
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
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.image_id);
            //console.log(response)
        }
    });
    </script>           


    
@endsection