@extends('layout', ['title'=> 'Đăng Ký'])

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
    max-width: 550px;
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
    box-sizing: border-box;
}

.form-input:focus {
    outline: none;
    border-color: #fb5849;
    background: white;
    box-shadow: 0 0 0 3px rgba(251, 88, 73, 0.1);
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
    margin-top: 10px;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(251, 88, 73, 0.5);
    background: linear-gradient(135deg, #ff6b5a 0%, #e16410 100%);
}

.btn-primary:active {
    transform: translateY(0);
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

.closebtn {
    margin-left: 15px;
    color: inherit;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
    opacity: 0.7;
}

.closebtn:hover {
    opacity: 1;
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

.terms-checkbox {
    display: flex;
    align-items: flex-start;
    margin-top: 20px;
    margin-bottom: 25px;
}

.terms-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    margin-top: 3px;
    cursor: pointer;
    accent-color: #fb5849;
    flex-shrink: 0;
}

.terms-checkbox label {
    font-size: 0.9rem;
    color: #666;
    cursor: pointer;
    line-height: 1.5;
}

.terms-checkbox a {
    color: #fb5849;
    text-decoration: none;
    font-weight: 500;
}

.terms-checkbox a:hover {
    text-decoration: underline;
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
                <h1>Đăng Ký</h1>
                <p>Tạo tài khoản mới ngay hôm nay!</p>
            </div>

            @if(Session::has('wrong'))
            <div class="alert-message alert-error">
                <span><strong>Lỗi!</strong> {{Session::get('wrong')}}</span>
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
            @endif

            @if(Session::has('success'))
            <div class="alert-message alert-success">
                <span><strong>Thành công!</strong> {{Session::get('success')}}</span>
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            </div>
            @endif

            <x-jet-validation-errors class="validation-errors" />

            <form method="POST" action="{{ route('register/confirm') }}" id="registerForm" novalidate>
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Họ và Tên</label>
                    <input id="name" 
                           class="form-input" 
                           type="text" 
                           name="name" 
                           value="{{ old('name') }}" 
                           required 
                           autofocus 
                           autocomplete="name"
                           placeholder="Nhập họ và tên của bạn">
                    <div class="field-error" id="err-name" style="display:none;"></div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" 
                           class="form-input" 
                           type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required
                           placeholder="Nhập email của bạn">
                    <div class="field-error" id="err-email" style="display:none;"></div>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Số Điện Thoại</label>
                    <input id="phone" 
                           class="form-input" 
                           type="tel" 
                           name="phone" 
                           value="{{ old('phone') }}" 
                           required
                           inputmode="numeric"
                           pattern="[0-9]*"
                           placeholder="Nhập số điện thoại của bạn">
                    <div class="field-error" id="err-phone" style="display:none;"></div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input id="password" 
                           class="form-input" 
                           type="password" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="Nhập mật khẩu">
                    <div class="field-error" id="err-password" style="display:none;"></div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                    <input id="password_confirmation" 
                           class="form-input" 
                           type="password" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Nhập lại mật khẩu">
                    <div class="field-error" id="err-password_confirmation" style="display:none;"></div>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="terms-checkbox">
                    <input type="checkbox" name="terms" id="terms" required>
                    <label for="terms">
                        Tôi đồng ý với 
                        <a target="_blank" href="{{ route('terms.show') }}">Điều khoản dịch vụ</a> 
                        và 
                        <a target="_blank" href="{{ route('policy.show') }}">Chính sách bảo mật</a>
                    </label>
                </div>
                <div class="field-error" id="err-terms" style="display:none;"></div>
                @endif

                <button type="submit" class="btn-primary">
                    Đăng Ký
                </button>
            </form>

            <div class="auth-footer">
                <p>Đã có tài khoản?</p>
                <a href="{{ route('login') }}">Đăng Nhập Ngay</a>
            </div>
        </div>
    </div>
</div>

<style>
  .field-error{
    margin-top: 8px;
    color: #b02a37;
    font-size: 0.9rem;
    line-height: 1.35;
  }
  .input-invalid{
    border-color: #dc3545 !important;
    background: #fff5f5 !important;
  }
</style>

<script>
  (function () {
    var form = document.getElementById('registerForm');
    if (!form) return;

    var elName = document.getElementById('name');
    var elEmail = document.getElementById('email');
    var elPhone = document.getElementById('phone');
    var elPass = document.getElementById('password');
    var elPass2 = document.getElementById('password_confirmation');
    var elTerms = document.getElementById('terms');

    function setError(inputEl, errId, message) {
      var errEl = document.getElementById(errId);
      if (errEl) {
        errEl.textContent = message || '';
        errEl.style.display = message ? 'block' : 'none';
      }
      if (inputEl) {
        inputEl.classList.toggle('input-invalid', !!message);
      }
    }

    function normalizePhone(v) {
      return (v || '').toString().replace(/\D/g, '');
    }

    function validateAll() {
      var ok = true;

      var name = (elName.value || '').trim();
      if (name.length < 2) { setError(elName, 'err-name', 'Họ và tên phải có ít nhất 2 ký tự.'); ok = false; }
      else setError(elName, 'err-name', '');

      var email = (elEmail.value || '').trim();
      var emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
      if (!emailOk) { setError(elEmail, 'err-email', 'Email không hợp lệ.'); ok = false; }
      else setError(elEmail, 'err-email', '');

      var phone = normalizePhone(elPhone.value);
      if (!(phone.length === 10 || phone.length === 11)) { setError(elPhone, 'err-phone', 'Số điện thoại phải gồm 10–11 chữ số.'); ok = false; }
      else setError(elPhone, 'err-phone', '');

      var pw = elPass.value || '';
      if (pw.length < 8) { setError(elPass, 'err-password', 'Mật khẩu phải có ít nhất 8 ký tự.'); ok = false; }
      else setError(elPass, 'err-password', '');

      var pw2 = elPass2.value || '';
      if (pw2 !== pw) { setError(elPass2, 'err-password_confirmation', 'Mật khẩu xác nhận không khớp.'); ok = false; }
      else setError(elPass2, 'err-password_confirmation', '');

      if (elTerms) {
        if (!elTerms.checked) { setError(elTerms, 'err-terms', 'Vui lòng đồng ý Điều khoản & Chính sách.'); ok = false; }
        else setError(elTerms, 'err-terms', '');
      }

      // chuẩn hóa phone trước khi submit
      elPhone.value = phone;
      return ok;
    }

    ['input','blur'].forEach(function (evt) {
      [elName, elEmail, elPhone, elPass, elPass2].forEach(function (el) {
        if (!el) return;
        el.addEventListener(evt, function () { validateAll(); });
      });
      if (elTerms) elTerms.addEventListener(evt, function () { validateAll(); });
    });

    form.addEventListener('submit', function (e) {
      if (!validateAll()) {
        e.preventDefault();
        e.stopPropagation();
      }
    });
  })();
</script>

@endsection
