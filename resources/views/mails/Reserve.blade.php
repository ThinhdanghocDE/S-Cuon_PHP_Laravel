<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Xác Nhận Đặt Bàn - S-Cuốn</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #fb5849 0%, #e63946 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .success-icon {
            text-align: center;
            margin: 20px 0;
        }
        .success-icon span {
            display: inline-block;
            width: 80px;
            height: 80px;
            background-color: #28a745;
            border-radius: 50%;
            line-height: 80px;
            color: white;
            font-size: 40px;
            font-weight: bold;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #fb5849;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: bold;
            color: #495057;
            width: 40%;
        }
        .info-value {
            color: #212529;
            width: 60%;
            text-align: right;
        }
        .message-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .message-box p {
            margin: 0;
            color: #856404;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
            color: #6c757d;
            font-size: 14px;
        }
        .footer strong {
            color: #fb5849;
        }
        .thank-you {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
        }
        .thank-you h2 {
            color: #fb5849;
            margin: 0;
            font-size: 24px;
        }
        .thank-you p {
            color: #6c757d;
            margin: 10px 0 0 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍜 S-CUỐN</h1>
            <p>Xác Nhận Đặt Bàn</p>
        </div>
        
        <div class="content">
            <div class="success-icon">
                <span>✓</span>
            </div>
            
            <div style="text-align: center; margin-bottom: 30px;">
                <h2 style="color: #28a745; margin: 0;">Đặt Bàn Thành Công!</h2>
                <p style="color: #6c757d; margin-top: 10px;">Cảm ơn bạn đã đặt bàn tại nhà hàng S-Cuốn</p>
            </div>

            <div class="info-box">
                <h3 style="margin-top: 0; color: #fb5849; border-bottom: 2px solid #fb5849; padding-bottom: 10px;">
                    📋 Thông Tin Đặt Bàn
                </h3>
                
                <div class="info-row">
                    <span class="info-label">Họ và Tên:</span>
                    <span class="info-value"><strong>{{ $name ?? ($data['name'] ?? 'N/A') }}</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $email ?? ($data['email'] ?? 'N/A') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Số Điện Thoại:</span>
                    <span class="info-value">{{ $phone ?? ($data['phone'] ?? 'N/A') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Số Người:</span>
                    <span class="info-value"><strong>{{ $no_guest ?? ($data['no_guest'] ?? 'N/A') }} người</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Ngày Đặt:</span>
                    <span class="info-value"><strong>{{ $date ?? ($data['date'] ?? 'N/A') }}</strong></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">Giờ Đặt:</span>
                    <span class="info-value"><strong>{{ $time ?? ($data['time'] ?? 'N/A') }}</strong></span>
                </div>
            </div>

            @if(!empty($data['reservation_message']))
            <div class="message-box">
                <p><strong>💬 Ghi Chú:</strong></p>
                <p>{{ $data['reservation_message'] }}</p>
            </div>
            @endif

            <div class="thank-you">
                <h2>Cảm Ơn Bạn!</h2>
                <p>Chúng tôi đã nhận được yêu cầu đặt bàn của bạn và sẽ liên hệ xác nhận trong thời gian sớm nhất.</p>
                <p style="margin-top: 15px; font-weight: bold; color: #fb5849;">
                    Hẹn gặp bạn tại S-Cuốn! 🍜
                </p>
            </div>

            <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 5px; padding: 15px; margin-top: 20px;">
                <p style="margin: 0; color: #856404; font-size: 14px;">
                    <strong>📌 Lưu ý:</strong> Nếu bạn cần thay đổi hoặc hủy đặt bàn, vui lòng liên hệ với chúng tôi trước ít nhất 2 giờ.
                </p>
            </div>
        </div>

        <div class="footer">
            <p><strong>S-CUỐN RESTAURANT</strong></p>
            <p>📍 Địa chỉ: Số 93B, Phố New Eskaton, Quận Hoàn Kiếm, Hà Nội, Việt Nam</p>
            <p>📞 Điện thoại: (+84) 1900 1234 | 📧 Email: info@scuon.vn</p>
            <p style="margin-top: 15px; font-size: 12px; color: #adb5bd;">
                Email này được gửi tự động, vui lòng không reply trực tiếp.
            </p>
        </div>
    </div>
</body>
</html>
