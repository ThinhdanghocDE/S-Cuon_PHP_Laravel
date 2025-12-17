@extends('admin/adminlayout')

@section('container')

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
          <h4 class="card-title mb-2">Thêm đặt bàn</h4>
          <a href="{{ route('admin.reservations') }}" class="btn btn-secondary btn-sm mb-2">Quay lại</a>
        </div>

        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.reservations.add.process') }}" method="POST">
          @csrf

          <div class="form-group">
            <label>Họ tên</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          </div>

          <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
          </div>

          <div class="form-group">
            <label>Số lượng khách</label>
            <input type="number" name="no_guest" class="form-control" value="{{ old('no_guest') }}" min="1" max="100" required>
          </div>

          <div class="form-group">
            <label>Ngày</label>
            <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
          </div>

          <div class="form-group">
            <label>Giờ</label>
            <input type="time" name="time" class="form-control" value="{{ old('time') }}" required>
          </div>

          <div class="form-group">
            <label>Ghi chú</label>
            <textarea name="message" class="form-control" rows="4">{{ old('message') }}</textarea>
          </div>

          <button type="submit" class="btn btn-primary">Lưu</button>
        </form>

        <script>
          (function () {
            const form = document.querySelector('form[action="{{ route('admin.reservations.add.process') }}"]');
            if (!form) return;

            const nameInput = form.querySelector('input[name="name"]');
            const emailInput = form.querySelector('input[name="email"]');
            const phoneInput = form.querySelector('input[name="phone"]');
            const guestsInput = form.querySelector('input[name="no_guest"]');
            const dateInput = form.querySelector('input[name="date"]');
            const timeInput = form.querySelector('input[name="time"]');

            function showError(input, message) {
              if (!input) return;
              input.classList.add('is-invalid');
              let el = input.parentElement.querySelector('.invalid-feedback');
              if (!el) {
                el = document.createElement('div');
                el.className = 'invalid-feedback';
                input.parentElement.appendChild(el);
              }
              el.textContent = message || '';
            }

            function clearError(input) {
              if (!input) return;
              input.classList.remove('is-invalid');
              const el = input.parentElement.querySelector('.invalid-feedback');
              if (el) el.remove();
            }

            function validateName() {
              const v = (nameInput?.value || '').trim();
              if (v.length < 2) return showError(nameInput, 'Họ tên phải có ít nhất 2 ký tự.');
              clearError(nameInput);
              return true;
            }

            function validateEmail() {
              const v = (emailInput?.value || '').trim();
              const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
              if (!re.test(v)) return showError(emailInput, 'Email không hợp lệ.');
              clearError(emailInput);
              return true;
            }

            function validatePhone() {
              const v = (phoneInput?.value || '').trim().replace(/[^\d+]/g, '');
              if (phoneInput) phoneInput.value = v;
              const digits = v.replace(/[^\d]/g, '');
              if (digits.length < 9 || digits.length > 15) return showError(phoneInput, 'Số điện thoại không hợp lệ.');
              clearError(phoneInput);
              return true;
            }

            function validateGuests() {
              const v = Number(guestsInput?.value || 0);
              if (!Number.isFinite(v) || v < 1) return showError(guestsInput, 'Số lượng khách phải >= 1.');
              if (v > 100) return showError(guestsInput, 'Số lượng khách quá lớn.');
              clearError(guestsInput);
              return true;
            }

            function validateDate() {
              const v = (dateInput?.value || '').trim();
              if (!v) return showError(dateInput, 'Vui lòng chọn ngày.');
              clearError(dateInput);
              return true;
            }

            function validateTime() {
              const v = (timeInput?.value || '').trim();
              if (!v) return showError(timeInput, 'Vui lòng chọn giờ.');
              clearError(timeInput);
              return true;
            }

            [nameInput, emailInput, phoneInput, guestsInput, dateInput, timeInput].forEach((input) => {
              if (!input) return;
              input.addEventListener('input', () => clearError(input));
              input.addEventListener('blur', () => {
                if (input === nameInput) validateName();
                if (input === emailInput) validateEmail();
                if (input === phoneInput) validatePhone();
                if (input === guestsInput) validateGuests();
                if (input === dateInput) validateDate();
                if (input === timeInput) validateTime();
              });
            });

            form.addEventListener('submit', function (e) {
              const ok =
                validateName() &
                validateEmail() &
                validatePhone() &
                validateGuests() &
                validateDate() &
                validateTime();
              if (!ok) e.preventDefault();
            });
          })();
        </script>
      </div>
    </div>
  </div>
</div>

@endsection()


