@extends('staff.layouts.app')

@section('content')
<main>
   <div class="d-flex justify-content-center">
    <div class="card" style="width: 50rem;">
        <div class="card-header text-center">
          Thông tin nhân viên
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Họ và tên: <span class="fw-bold">{{ $staff->name}}</span></li>
          <li class="list-group-item">Quê quán: <span class="fw-bold">{{  $staff->address }}- {{  $staff->ward }}- {{  $staff->district }}- {{  $staff->city }}</span></li>
          <li class="list-group-item">Thông tin liên lạc: <span class="fw-bold">{{  $staff->mobile }}-{{ $staff->email}}</span></li>
          <li class="list-group-item">Vị trí làm việc: <span class="fw-bold">{{ $staff->position}}</span></li>
        </ul>
      </div>
   </div>
</main>   
@endsection

@section('js')
    
@endsection