@extends('user.layouts.app')

@section('content')
    <section style="margin-top: 200px">
        <h2 class="bd-title d-flex justify-content-center mt-4">GIỚI THIỆU VỀ CỬA HÀNG</h2>
        <div class="container my-5 ">
            <div class="row featurette d-flex justify-content-center align-items-center">
                <div class="col-md-7">
                    <p class="lead" style="text-align: justify">Chào mừng quý khách đến với cửa hàng phụ tùng xe máy của chúng tôi! Với đam mê và kinh nghiệm lâu năm trong ngành, chúng tôi tự hào là địa chỉ tin cậy cho những người yêu xe máy. Cửa hàng của chúng tôi cam kết cung cấp những sản phẩm chất lượng cao, đa dạng và phù hợp với mọi loại xe. Chúng tôi không chỉ mang đến cho khách hàng những sản phẩm chất lượng mà còn đảm bảo dịch vụ chăm sóc khách hàng tận tâm và chuyên nghiệp.</p>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('user-assets/image/img_store/1.jpg') }} " 
                    class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="">
                </div>
            </div>
            <div class="row featurette d-flex justify-content-center align-items-center mt-4">
                <div class="col-md-7 order-md-2">
                    <p class="lead" style="text-align: justify">Tại cửa hàng chúng tôi, không chỉ là nơi để mua sắm phụ tùng, mà còn là điểm đến của cộng đồng đam mê xe máy. Chúng tôi luôn sẵn lòng chia sẻ kiến thức và kinh nghiệm với khách hàng, giúp họ hiểu rõ hơn về việc bảo dưỡng và nâng cấp xe của mình. Với đội ngũ nhân viên nhiệt tình và am hiểu về xe máy, chúng tôi tin rằng mỗi lần ghé thăm cửa hàng sẽ là một trải nghiệm đặc biệt, giúp khách hàng cảm thấy hài lòng và tự tin với sự lựa chọn của mình. Hãy đồng hành cùng chúng tôi trên hành trình khám phá thế giới xe máy và tận hưởng niềm đam mê!</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="{{ asset('user-assets/image/img_store/3.jpg') }} " 
                    class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="">
        
                </div>
            </div>
            <hr class="featurette-divider">
        </div>
    </section>
@endsection

@section('js')
@endsection