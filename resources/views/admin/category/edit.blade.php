@extends('admin.layouts.app')

@section('content')
  				<!-- Content Header (Page header) -->
    <section class="content-header">      
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Sửa loại sản phẩm</h1>
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
        <form action="" method="post" id="categoryForm" name="categoryForm">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">     			
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Tên</label>
                                    <input type="text" name="name" id="name" value="{{ $category->name}}" class="form-control" placeholder="Name">
                                    <p></p>	
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Tên không dấu</label>
                                    <input type="text" readonly name="slug" id="slug" value="{{ $category->slug}}" class="form-control" placeholder="Slug">
                                     {{-- readonly thuộc tính làm cho ô nhập liệu chỉ có thể đọc chứ không thể nhập dữ liệu vào --}}	
                                    <p></p>
                                </div>
                            </div>  
                           
                            <div class="col-md-6">
                               <div class="mb-3">
                                <input type="hidden" id="image_id" name="image_id" value="">
                                 <label for="image">Hình ảnh</label>
                                 <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">    
                                        <br>Drop files here or click to upload.<br><br>                                            
                                    </div>
                                </div>
                               </div>
                            </div>
            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Trạng thái</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($category->status == 1) ? 'selected' : ''}} value="1">Action</option>
                                        <option {{ ($category->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="col-md-6">
                                @if (!empty($category->image))
                                    <div class="">
                                        <img class="img-thumbnail" src="{{ asset('uploads/category/'.$category->image)}}" alt="" style="height: 200px; width: 200px;">
                                    </div>
                                @endif
                           </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showHome">Hiển thị trang chủ</label>
                                    <select name="show_home" id="show_home" class="form-control">
                                          <option {{ ($category->show_home == 'Yes') ? 'selected' : ''}} value="Yes">Yes</option>
                                        <option {{ ($category->show_home == 'No') ? 'selected' : ''}} value="No">No</option>
                                    </select>
                                </div>
                            </div>            

                        </div>
                    </div>      		
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Trờ về</a>
                </div>
            </div>
            <!-- /.card -->
         </form>
</section>
				<!-- /.content -->
@endsection

@section('js')
<script>

    $("#categoryForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true); //sử dụng để tắt khả năng kích hoạt nút "submit" trong biểu mẫu (form) sau khi người dùng đã nhấp vào nút "Create".
        $.ajax({

            url: '{{ route("categories.update", $category->id) }}',
            type: 'put',
            data: element.serializeArray(), //chuyển dữ liệu thành 1 đối tượng json và gửi đi
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', true);

                if(response["status"] == true){

                    window.location.href  = "{{route('categories.index')}}";

                    $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                }else{
                    var errors = response['errors'];

                    if(errors['name']){
                        $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                    }else{
                        $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['slug']){
                        $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['slug']);
                    }else{
                        $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
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
                    // khi giá trị của trường "name" thay đổi và yêu cầu Ajax thành công, 
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