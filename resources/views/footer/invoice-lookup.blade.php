@extends('layout', ['title'=> 'Tra Cứu Hóa Đơn Điện Tử'])

@section('page-content')
<div class="container" style="padding: 100px 20px; min-height: 600px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 style="text-align: center; margin-bottom: 40px; color: #fb5849;">Tra Cứu Hóa Đơn Điện Tử</h1>
            
            <div style="max-width: 700px; margin: 0 auto;">
                <div style="background: #f9f9f9; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <form method="POST" action="{{ route('trace.confirm') }}">
                        @csrf
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Mã Hóa Đơn / Mã Đơn Hàng:</label>
                            <input type="text" name="order_id" class="form-control" placeholder="Nhập mã hóa đơn" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Email hoặc Số Điện Thoại:</label>
                            <input type="text" name="email_or_phone" class="form-control" placeholder="Nhập email hoặc số điện thoại" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
                        </div>

                        <button type="submit" class="main-text-button" style="width: 100%; padding: 15px; font-size: 16px; border: none; cursor: pointer;">Tra Cứu Hóa Đơn</button>
                    </form>
                </div>

                <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 5px;">
                    <h4 style="color: #856404; margin-bottom: 10px;">Lưu Ý:</h4>
                    <ul style="color: #856404; line-height: 1.8;">
                        <li>Mã hóa đơn được gửi qua email sau khi đặt hàng thành công</li>
                        <li>Bạn cũng có thể tra cứu đơn hàng tại mục "Đơn Hàng" nếu đã đăng nhập</li>
                        <li>Nếu không tìm thấy, vui lòng liên hệ hotline: <strong>0123 456 789</strong></li>
                    </ul>
                </div>

                <p style="margin-top: 40px; text-align: center;">
                    <a href="/" class="main-text-button" style="display: inline-block; padding: 12px 30px;">Quay Về Trang Chủ</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

