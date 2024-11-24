@extends('admin.layouts.app')

@section('content')
  				<!-- Content Header (Page header) -->
    <section class="content-header">      
        <div class="container-fluid my-2">
        	<div class="row mb-2">
        		<div class="col-sm-6">
        			<h1>Cập nhật phí vận chuyển</h1>
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
        <form action="{{ route('shipping.store') }}" method="post" id="shippingForm" name="shippingForm">
            <!-- Default box -->
            @include('admin.message')
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">     			
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                        <div class="col-md-4 col-sm-12 form-group">
                                            <label for="Province">Tỉnh/Thành Phố</label>
                                            <select disabled id="Province" class="form-control"></select>
                                            <p></p>       
                                        </div>
                                        <p class="p-2" value="{{$shippings->id}}" data-id="{{$shippings->id}}">Tỉnh hiện tại: {{$shippings->city_province}}</p>       
                                    <p></p>	
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Phí vận chuyển</label>
                                    <input type="text" value="{{ $shippings->shipping_fee}}" name="fee" id="fee" class="form-control" placeholder="Nhập phí vận chuyển">
                                    <p></p>	
                                </div>
                            </div>
                        </div>
                    </div>      		
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('shipping.index') }}" class="btn btn-outline-dark ml-3">Trở về</a>
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
            $.ajax({

                url: '{{ route("shipping.update", $shippings->id) }}',
                type: 'patch',
                data: element.serializeArray(), //chuyển dữ liệu thành 1 đối tượng json và gửi đi
                dataType: 'json',
                success: function(response){
                    $("button[type=submit]").prop('disabled', true);

                    if(response["status"] == true){

                        window.location.href  = "{{route('shipping.index')}}";

                        $('#fee').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                    }else{
                        var errors = response['errors'];

                        if(errors['fee']){
                            $('#fee').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors['name']);
                        }else{
                            $('#fee').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        }
                    }

                }, error: function(jqXHR, exception){

                    console.log("Xảy ra lỗi!!");
                }
            })
        });
    </script>
@endsection