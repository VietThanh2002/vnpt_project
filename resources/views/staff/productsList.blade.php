@extends('staff.layouts.app')

@section('content')
<main>
    <div class="col-md-12">
        <p class="fw-bold">Danh sách sản phẩm</p>
        <div class="bg-light">
            <div class="table-data">
                 <div class="order">
                     <table id="myTable" class="table-responsive">
                         <thead>
                             <tr>
                                <th>Mã SP</th>
                                <th>Tên sản phẩn</th>
                                <th>Hình ảnh</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                             </tr>
                         </thead>
                         <tbody>
                            @if (!empty($products))
                                @foreach ($products as $key => $item)
                                @php
                                    $productImage =  $item->product_images->first(); //load từ model product-image
                                @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><p>{{$item->name}}</p></td>
                                        <td>
                                            @if (!empty($productImage->image))
                                                <img src="{{ asset('/uploads/product/'.$productImage->image) }} " class="img-thumbnail" width="75"> 
                                            @else
                                                <img src="{{ asset('admin-assets/img/default-150x150.png') }} " class="img-thumbnail" width="75"> 
                                            @endif
                                        </td>
                                        <td data-order="{{$item->price}}">{{formatPriceVND($item->price)}}</td>
                                        <td>{{$item->qty}}</td>
                                        <td style="text-align: center;">
                                            @if (($item->status == 1) and ($item->qty > 0))
                                                <div clas="text-center">
                                                    <i class="fa-regular fa-circle-check btn btn-success btn-sm"></i>
                                                </div>
                                            @else
                                                <p class="text-danger">Hết hàng</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                 <p class="text-center">Rỗng</p>
                            @endif
                         </tbody>
                     </table>
                 </div>
             </div>
        </div>
    </div>
</main>
@endsection

@section('js')
@endsection