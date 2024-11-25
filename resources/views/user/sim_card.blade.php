@extends('user.layouts.app')

@section('content')
<section class="section-6 pt-5" style="margin-left: 60px; margin-bottom: 20px; margin-top: 160px;">
    <div class="container">
        <div class="row">
            <!-- Filter Column -->
            <div class="col-md-3">
                <form id="filterForm" action="{{ route('user.simSo') }}" method="GET">
                    <div class="card">
                        <div class="card-body">
                            <!-- Loại thuê bao -->
                            <div class="filter-section mb-4">
                                <h5 class="mb-3">Loại thuê bao</h5>
                                <div class="form-check mb-2">
                                    <input class="form-check-input filter-input" type="radio" name="subscription_type" value="all" id="all" {{ request('subscription_type') == 'all' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="all">Tất cả</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input filter-input" type="radio" name="subscription_type" value="prepaid" id="prepaid" {{ request('subscription_type') == 'prepaid' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="prepaid">Trả trước</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-input" type="radio" name="subscription_type" value="postpaid" id="postpaid" {{ request('subscription_type') == 'postpaid' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="postpaid">Trả sau</label>
                                </div>
                            </div>

                            <!-- Theo đầu số -->
                            <div class="filter-section mb-4">
                                <h5 class="mb-3">Theo đầu số</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="091" id="091" {{ request('prefix') == '091' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="091">091</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="088" id="088" {{ request('prefix') == '088' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="088">088</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="082" id="082" {{ request('prefix') == '082' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="082">082</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="084" id="084" {{ request('prefix') == '084' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="084">084</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="094" id="094" {{ request('prefix') == '094' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="094">094</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="081" id="081" {{ request('prefix') == '081' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="081">081</label>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="083" id="083" {{ request('prefix') == '083' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="083">083</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input filter-input" type="radio" name="prefix" value="085" id="085" {{ request('prefix') == '085' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="085">085</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Column -->
            <div class="col-md-9">
                <!-- Results Table -->
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Số Sim</th>
                                <th>Loại thuê bao</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                           @if ($simCards->isNotEmpty())
                                @foreach($simCards as $index => $simCard)
                                    <tr>
                                        <td>{{  $index+1 }}</td>
                                        <td>{{  $simCard->sim_number }}</td>
                                        <td>
                                            @if($simCard->sim_type == 'Trả trước')
                                                Trả trước
                                            @else
                                                Trả sau
                                            @endif
                                        </td>
                                        <td>
                                            <button onclick="buySim( {{  $simCard->id }} ); " class="btn btn-sm btn-info">MUA NGAY</button>
                                        </td>
                                    </tr>
                                @endforeach
                           @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .filter-section {
        border-bottom: 1px solid #eee;
        padding-bottom: 20px;
    }

    .filter-section:last-child {
        border-bottom: none;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .table th {
        background-color: #f8f9fa;
    }

    .btn-primary {
        border-radius: 4px;
    }

    .form-control {
        border-radius: 4px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
    }
    </style>
@endsection

@section('js')
    <script>

    function buySim(id){
         $.ajax({
                 url: '{{ route("user.buySim") }}',
                 type: 'post',
                 data: {id:id},
                 dataType: 'json',
                 success: function(response){
                     if(response.status == true){
                        window.location.href = "{{ route('user.checkout') }}";
                     }else{
                            alert(response.message)
                     }
                 } 
            });
        }

        $(document).ready(function() {
            // Auto submit form when radio button changes
            $('.filter-input').change(function() {
                $('#filterForm').submit();
            });
        });
        
    $('#dataTable').DataTable({
        "searching": true,
        'info': false,
        'paging': false,
        'language': {
            'search': 'Tìm kiếm',
        }
    });
    </script>
@endsection

    


