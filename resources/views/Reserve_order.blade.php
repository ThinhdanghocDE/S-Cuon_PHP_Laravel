<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <title>Successful Reservation</title>
</head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Thành Công</h1> 
        <p>Chúng tôi đã nhận được yêu cầu đặt bàn của bạn!<br/> Chúng tôi sẽ liên hệ với bạn sớm nhất có thể!</p>
        @if(isset($reservation))
        <div style="margin-top: 20px; text-align: left; display: inline-block;">
          <p style="font-size: 16px; color: #404F5E;"><strong>Thông tin đặt bàn:</strong></p>
          <p style="font-size: 14px; color: #404F5E;">Họ tên: {{ $reservation['name'] }}</p>
          <p style="font-size: 14px; color: #404F5E;">Email: {{ $reservation['email'] }}</p>
          <p style="font-size: 14px; color: #404F5E;">Số điện thoại: {{ $reservation['phone'] }}</p>
          <p style="font-size: 14px; color: #404F5E;">Số người: {{ $reservation['no_guest'] }}</p>
          <p style="font-size: 14px; color: #404F5E;">Ngày: {{ $reservation['date'] }}</p>
          <p style="font-size: 14px; color: #404F5E;">Giờ: {{ $reservation['time'] }}</p>
          @if(isset($emailSent) && $emailSent)
          <p style="font-size: 14px; color: #88B04B; margin-top: 10px;">✓ Email xác nhận đã được gửi đến {{ $reservation['email'] }}</p>
          @elseif(isset($mailer) && $mailer === 'log')
          <div style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 5px; padding: 15px; margin-top: 15px;">
            <p style="font-size: 14px; color: #856404; margin: 0;">
              <strong>⚠️ Lưu ý:</strong> Email đã được lưu vào log file. Để gửi email thật, vui lòng cấu hình SMTP trong file .env (xem hướng dẫn trong file HUONG_DAN_CAU_HINH_MAIL.md)
            </p>
          </div>
          @elseif(isset($emailError))
          <div style="background-color: #f8d7da; border: 1px solid #dc3545; border-radius: 5px; padding: 15px; margin-top: 15px;">
            <p style="font-size: 14px; color: #721c24; margin: 0;">
              <strong>❌ Lỗi gửi email:</strong> {{ $emailError }}<br>
              <small>Vui lòng kiểm tra cấu hình mail trong file .env</small>
            </p>
          </div>
          @endif
        </div>
        @endif
      </div>
    </body>
</html>