@extends('layout', ['title'=> 'Chính Sách Bảo Mật'])

@section('page-content')
<div class="container" style="padding: 100px 20px; min-height: 600px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 style="text-align: center; margin-bottom: 40px; color: #fb5849;">Chính Sách Bảo Mật</h1>
            
            <div style="max-width: 900px; margin: 0 auto; line-height: 1.8;">
                <h3>1. Thu Thập Thông Tin</h3>
                <p>Chúng tôi thu thập thông tin khi bạn:</p>
                <ul>
                    <li>Đăng ký tài khoản</li>
                    <li>Đặt hàng</li>
                    <li>Liên hệ với chúng tôi</li>
                    <li>Truy cập website</li>
                </ul>

                <h3>2. Thông Tin Chúng Tôi Thu Thập</h3>
                <ul>
                    <li>Họ tên, email, số điện thoại</li>
                    <li>Địa chỉ giao hàng</li>
                    <li>Thông tin thanh toán</li>
                    <li>Dữ liệu truy cập website</li>
                </ul>

                <h3>3. Mục Đích Sử Dụng</h3>
                <p>Thông tin của bạn được sử dụng để:</p>
                <ul>
                    <li>Xử lý đơn hàng</li>
                    <li>Cải thiện dịch vụ</li>
                    <li>Gửi thông tin khuyến mãi (nếu bạn đồng ý)</li>
                    <li>Liên hệ hỗ trợ</li>
                </ul>

                <h3>4. Bảo Mật Thông Tin</h3>
                <p>Chúng tôi cam kết bảo vệ thông tin của bạn bằng các biện pháp bảo mật tiên tiến và không chia sẻ thông tin với bên thứ ba trừ khi có yêu cầu pháp lý.</p>

                <h3>5. Quyền Của Bạn</h3>
                <p>Bạn có quyền:</p>
                <ul>
                    <li>Truy cập và chỉnh sửa thông tin cá nhân</li>
                    <li>Yêu cầu xóa tài khoản</li>
                    <li>Từ chối nhận email marketing</li>
                </ul>

                <h3>6. Liên Hệ</h3>
                <p>Nếu có thắc mắc về chính sách bảo mật, vui lòng liên hệ: <strong>info@scuon.vn</strong></p>

                <p style="margin-top: 40px; text-align: center;">
                    <a href="/" class="main-text-button" style="display: inline-block; padding: 12px 30px;">Quay Về Trang Chủ</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

