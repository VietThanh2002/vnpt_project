@extends('admin.layouts.app')

@section('content')
  				<!-- Content Header (Page header) -->
    <section class="content-header">      
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Tạo phí vận chuyển</h1>
        		</div>
        		<div class="col-sm-6 text-right">
        			<a href="{{ route('shipping.index') }}" class="btn btn-primary">Trở về</a>
        		</div>
        	</div>
        </div>
        <!-- /.container-fluid -->
	</section>
				<!-- Main content -->
	<section class="content">
        @include('admin.message')
        <form action="{{ route('shipping.store') }}" method="post" id="shippingForm" name="shippingForm">
            <!-- Default box -->
            {{-- @include('admin.message') --}}
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">     			
                        <div class="row">
                            <div class="col-md-6">
                               <div class="mb-3 col-md-4 col-sm-12 form-group">
                                    <label for="Province">Tỉnh/Thành Phố</label>
                                    <select id="Province" name="city" class="form-control"></select>
                                    <p></p>       
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Phí vận chuyển</label>
                                    <input type="text" name="fee" id="fee" class="form-control" placeholder="Nhập phí vận chuyển">
                                    <p></p>	
                                </div>
                            </div>
                        </div>
                    </div>      		
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Tạo</button>
                    <a href="{{ route('shipping.index') }}" class="btn btn-outline-dark ml-3">Trờ về</a>
                </div>
            </div>
            <!-- /.card -->
         </form>
</section>
				<!-- /.content -->
@endsection

@section('js')
<script>
    $("#shippingForm").submit(function(event){
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true); //sử dụng để tắt khả năng kích hoạt nút "submit" trong biểu mẫu (form) sau khi người dùng đã nhấp vào nút "Create".

        var cityName = $('#Province').find("option:selected").text();

        // Thêm cityName vào trường name của select
        $('#Province').attr('name', 'city').val(cityName);

        var formData = $(this).serializeArray();

        formData.push({ name: "city", value: cityName });

        $.ajax({

            url: '{{ route("shipping.store") }}',
            type: 'post',
            data: formData, //chuyển dữ liệu thành 1 đối tượng json và gửi đi
            dataType: 'json',
            success: function(response){
                $("button[type=submit]").prop('disabled', false);

                if(response["status"] == true){

                    $('#city').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    $('#fee').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');

                    window.location.href  = "{{route('shipping.index')}}";

                }else{
                    var errors = response['errors'];

                    if (errors['city']) {
                        $('#Province').addClass('is-invalid'); // Thêm class 'is-invalid' vào thẻ select
                        $('#Province').siblings('p').addClass('invalid-feedback').html(errors['city']);
                    } else {
                        $('#Province').removeClass('is-invalid');
                        $('#Province').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors['fee']){
                        $('#fee').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['fee']);
                    }else{
                        $('#fee').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }

                    // window.location.href  = "{{route('shipping.index')}}";
                }

            }, error: function(jqXHR, exception){

                console.log("Xảy ra lỗi!!");
            }
        })
    });

</script>
@endsection