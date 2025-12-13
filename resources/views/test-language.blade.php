<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Ngôn Ngữ Tiếng Việt</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 800px; 
            margin: 50px auto; 
            padding: 20px;
            background: #f5f5f5;
        }
        .card { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h2 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        .success { color: #4CAF50; font-weight: bold; }
        .error { color: #f44336; }
        .info { color: #2196F3; }
        ul { list-style: none; padding: 0; }
        li { padding: 10px; margin: 5px 0; background: #f9f9f9; border-left: 3px solid #4CAF50; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .validation-errors { background: #ffebee; padding: 15px; border-radius: 4px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="card">
        <h2>✅ Test Ngôn Ngữ Tiếng Việt</h2>
        
        <p class="success">Locale hiện tại: <strong>{{ app()->getLocale() }}</strong></p>
        <p class="info">Timezone: <strong>{{ config('app.timezone') }}</strong></p>
        <p class="info">Thời gian hiện tại: <strong>{{ now()->format('H:i:s d/m/Y') }}</strong></p>
    </div>

    <div class="card">
        <h2>📝 Validation Messages (Tiếng Việt)</h2>
        <ul>
            <li>{{ __('validation.required', ['attribute' => 'Email']) }}</li>
            <li>{{ __('validation.email', ['attribute' => 'Email']) }}</li>
            <li>{{ __('validation.min.string', ['attribute' => 'Mật khẩu', 'min' => 8]) }}</li>
            <li>{{ __('validation.confirmed', ['attribute' => 'Mật khẩu']) }}</li>
            <li>{{ __('validation.unique', ['attribute' => 'Email']) }}</li>
        </ul>
    </div>

    <div class="card">
        <h2>🔐 Auth Messages (Tiếng Việt)</h2>
        <ul>
            <li>{{ __('auth.failed') }}</li>
            <li>{{ __('auth.password') }}</li>
            <li>{{ __('auth.throttle', ['seconds' => 60]) }}</li>
        </ul>
    </div>

    <div class="card">
        <h2>🔑 Password Reset Messages (Tiếng Việt)</h2>
        <ul>
            <li>{{ __('passwords.reset') }}</li>
            <li>{{ __('passwords.sent') }}</li>
            <li>{{ __('passwords.token') }}</li>
            <li>{{ __('passwords.user') }}</li>
        </ul>
    </div>

    <div class="card">
        <h2>🍽️ Custom Messages (Tiếng Việt)</h2>
        <ul>
            <li>{{ __('messages.home') }}</li>
            <li>{{ __('messages.menu') }}</li>
            <li>{{ __('messages.order_now') }}</li>
            <li>{{ __('messages.add_to_cart') }}</li>
            <li>{{ __('messages.checkout') }}</li>
            <li>{{ __('messages.order_placed') }}</li>
        </ul>
    </div>

    <div class="card">
        <h2>📋 Form Test (Submit để xem lỗi tiếng Việt)</h2>
        
        @if ($errors->any())
            <div class="validation-errors">
                <strong>❌ Lỗi Validation (Tiếng Việt):</strong>
                <ul style="margin-top: 10px;">
                    @foreach ($errors->all() as $error)
                        <li style="background: white; border-left-color: #f44336;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/test-validation') }}">
            @csrf
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label>Mật khẩu:</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <label>Số điện thoại:</label>
                <input type="text" name="phone" value="{{ old('phone') }}">
            </div>
            <button type="submit">Gửi (Submit để xem lỗi tiếng Việt)</button>
        </form>
    </div>

    <div class="card">
        <h2>ℹ️ Hướng Dẫn</h2>
        <p>Để sử dụng ngôn ngữ tiếng Việt trong views, dùng:</p>
        <pre style="background: #f5f5f5; padding: 15px; border-radius: 4px; overflow-x: auto;">
@{{ __('validation.required', ['attribute' => 'Email']) }}
@{{ __('messages.home') }}
@{{ __('auth.failed') }}
        </pre>
    </div>
</body>
</html>

