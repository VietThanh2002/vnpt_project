@extends('admin.layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">	
	<div class="container-fluid my-2">
		<div class="row mb-2">
			<div class="col-sm-6">
                <h1>Thêm thương hiệu</h1>
			</div>
			<div class="col-sm-6 text-right">
                <a href="{{ route('brands.index')}}" class="btn btn-primary"><i class='bx bx-arrow-back'></i></a>
			</div>
		</div>
	</div>
	<!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
	<div class="container-fluid">
		<form action="" id="brandsForm" id="brandsForm">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Tên thương hiệu</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Tên thương hiệu">
                                <p></p>	
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input readonly type="text" name="slug" id="slug" class="form-control" placeholder="Slug">	
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Trạng thái</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Action</option>
                                    <option value="0">Block</option>
                                </select>
                                
                            </div>
                        </div>      
                    </div>
                </div>			
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Tạo</button>
                <a href="{{ route('brands.index')}}" class="btn btn-outline-dark ml-3">Trở về</a>
            </div>
        </form>
	</div>
	<!-- /.card -->
</section>
<!-- /.content -->

@endsection

@section('js')
<script>

    $("#brandsForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true); //sử dụng để tắt khả năng kích hoạt nút "submit" trong biểu mẫu (form) sau khi người dùng đã nhấp vào nút "Create".
        $.ajax({

            url: '{{ route("brands.store") }}',
            type: 'post',
            data: element.serializeArray(), //chuyển dữ liệu thành 1 đối tượng json và gửi đi
            dataType: 'json',
            success: function(response){
                if(response["status"] == true){

                    $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    window.location.href  = "{{route('brands.index')}}";
                }else{
                    var errors = response['errors'];

                    $("button[type=submit]").prop('disabled', false);

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


</script>
@endsection