@extends('user.layouts.app')

@section('content')
    <section style="margin-top: 200px">
        <h2 class="bd-title d-flex justify-content-center mt-4">GIỚI THIỆU VỀ VNPT ĐỒNG THÁP</h2>
        <div class="container my-5 ">
            <div class="row featurette d-flex justify-content-center align-items-center">
                <div class="col-md-7">
                    <p class="lead" style="text-align: justify">VNPT Đồng Tháp là một trong những chi nhánh quan trọng của Tập đoàn Bưu chính Viễn thông Việt Nam (VNPT), hoạt động chủ yếu trong lĩnh vực cung cấp dịch vụ viễn thông và internet tại tỉnh Đồng Tháp. Được thành lập với mục tiêu nâng cao chất lượng dịch vụ và đáp ứng nhu cầu ngày càng cao của người dân, VNPT Đồng Tháp đã không ngừng mở rộng mạng lưới và cải thiện công nghệ để phục vụ khách hàng tốt hơn. Chi nhánh này cam kết mang đến các sản phẩm và dịch vụ viễn thông hiện đại, bao gồm internet cáp quang, di động và các giải pháp công nghệ thông tin.</p>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('user-assets/image/vnpt thủ đức 1.jpg') }} " 
                    class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="">
                </div>
            </div>
            <div class="row featurette d-flex justify-content-center align-items-center mt-4">
                <div class="col-md-7 order-md-2">
                    <p class="lead" style="text-align: justify">Với sự phát triển mạnh mẽ, VNPT Đồng Tháp đã phủ sóng 100% hạ tầng cáp quang trên toàn tỉnh, giúp người dân và doanh nghiệp dễ dàng tiếp cận với dịch vụ internet tốc độ cao. Ngoài ra, VNPT Đồng Tháp cũng thường xuyên tổ chức các chương trình khuyến mãi hấp dẫn nhằm thu hút khách hàng, đồng thời đóng góp tích cực vào sự phát triển kinh tế - xã hội của địa phương. Chi nhánh còn chú trọng đến việc nâng cao chất lượng phục vụ khách hàng thông qua việc đào tạo nhân viên chuyên nghiệp và cải tiến quy trình phục vụ.</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="{{ asset('user-assets/image/banner_gioithieu_mb.jpg') }} " 
                    class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="">
                </div>
            </div>
            <hr class="featurette-divider">
        </div>
    </section>
@endsection

@section('js')
@endsection