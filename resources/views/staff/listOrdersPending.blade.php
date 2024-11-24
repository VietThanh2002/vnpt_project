@extends('staff.layouts.app')

@section('content')
<main>
    <div class="col-md-12">
        <p class="fw-bold">Danh sách đơn hàng</p>
        <div class="">
            <div class="table-data">
                 <div class="order">
                     <table id="myTable" class="table-responsive">
                         <thead class="">
                             <tr>
                                <th>STT</th>
                                <th>Khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                             </tr>
                         </thead>
                         <tbody>
                            @if (!empty($orders))
                                @foreach ($orders as $key => $item)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td><p>{{$item->name}}</p></td>
                                        <td>{{$item->phone_number}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td><span class="status completed">{{$item->status}}</span></td>
                                        <td><a href="{{ url('staff/invoice', $item->id) }}"><i class="fa-regular fa-eye"></i></a></td>
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
{{-- <script>
      $(document).ready( function () {
        $('#myTable').DataTable({
          "paging": false,
          "info": false,
          "language": {
                "search": "Tìm kiếm:",
            },    
		});
    });
</script> --}}
@endsection