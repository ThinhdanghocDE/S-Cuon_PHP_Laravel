@extends('layout', ['title'=> 'Đăng Nhập'])

@section('page-content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800;900&display=swap');

.auth-page {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: calc(100vh - 200px);
    padding: 60px 0;
    margin-top: 80px;
    font-family: 'Inter', sans-serif;
}

.auth-container {
    max-width: 500px;
    margin: 0 auto;
    padding: 0 20px;
}

.auth-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    padding: 50px 40px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.auth-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 70px rgba(0,0,0,0.35);
}

.auth-header {
    text-align: center;
    margin-bottom: 40px;
}

.auth-header img {
    max-width: 200px;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
}

.auth-header h1 {
    font-family: 'Dancing Script', cursive;
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #fb5849 0%, #d15400 30%, #ff6b5a 60%, #fb5849 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    letter-spacing: 2px;
}

.auth-header p {
    font-size: 1rem;
    color: #666;
    font-style: italic;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #2a2a2a;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-input {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 1rem;
    font-family: 'Inter', sans-serif;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-input:focus {
    outline: none;
    border-color: #fb5849;
    background: white;
    box-shadow: 0 0 0 3px rgba(251, 88, 73, 0.1);
}

.form-checkbox-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.form-checkbox {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    cursor: pointer;
    accent-color: #fb5849;
}

.form-checkbox-label {
    font-size: 0.9rem;
    color: #666;
    cursor: pointer;
}

.btn-primary {
    width: 100%;
    padding: 16px;
    background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(251, 88, 73, 0.4);
    font-family: 'Inter', sans-serif;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(251, 88, 73, 0.5);
    background: linear-gradient(135deg, #ff6b5a 0%, #e16410 100%);
}

.btn-primary:active {
    transform: translateY(0);
}

.link-forgot {
    color: #fb5849;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

.link-forgot:hover {
    color: #d15400;
    text-decoration: underline;
}

.auth-footer {
    text-align: center;
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #e0e0e0;
}

.auth-footer p {
    color: #666;
    font-size: 0.95rem;
    margin-bottom: 10px;
}

.auth-footer a {
    color: #fb5849;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.auth-footer a:hover {
    color: #d15400;
    text-decoration: underline;
}

.alert-message {
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.validation-errors {
    background: #f8d7da;
    color: #721c24;
    padding: 15px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-size: 0.9rem;
}

.validation-errors ul {
    margin: 0;
    padding-left: 20px;
}

.validation-errors li {
    margin-bottom: 5px;
}

.flex-between {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

@media (max-width: 768px) {
    .auth-page {
        padding: 40px 0;
        margin-top: 60px;
    }
    
    .auth-card {
        padding: 40px 30px;
    }
    
    .auth-header h1 {
        font-size: 2.5rem;
    }
}
</style>

<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <img src="{{ asset('assets/images/logo.png') }}" alt="S-Cuốn Logo">
                <h1>Đăng Nhập</h1>
                <p>Chào mừng bạn trở lại!</p>
            </div>

            <x-jet-validation-errors class="validation-errors" />

            @if (session('status'))
                <div class="alert-message alert-success">
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" 
                           class="form-input" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus 
                           placeholder="Nhập email của bạn">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input id="password" 
                           class="form-input" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="Nhập mật khẩu của bạn">
                </div>

                <div class="form-checkbox-wrapper">
                    <input type="checkbox" 
                           id="remember_me" 
                           name="remember" 
                           class="form-checkbox">
                    <label for="remember_me" class="form-checkbox-label">
                        Ghi nhớ đăng nhập
                    </label>
                </div>

                <div class="flex-between">
                    @if (Route::has('password.request'))
                        <a class="link-forgot" href="{{ route('password.request') }}">
                            Quên mật khẩu?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">
                    Đăng Nhập
                </button>
            </form>

            <div class="auth-footer">
                <p>Chưa có tài khoản?</p>
                <a href="/register">Đăng Ký Ngay</a>
            </div>
        </div>
    </div>
</div>

@endsection
