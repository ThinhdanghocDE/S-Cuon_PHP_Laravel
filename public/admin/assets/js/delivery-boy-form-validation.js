/**
 * Delivery Boy Form Validation
 * Client-side validation for add and edit delivery boy form
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="/add-delivery-boy-process"], form[action*="/edit_delivery_boy_process"]');
    if (!form) return;
    
    const isEditForm = form.action.includes('/edit_delivery_boy_process');
    const nameInput = form.querySelector('input[name="name"]');
    const emailInput = form.querySelector('input[name="email"]');
    const phoneInput = form.querySelector('input[name="phone"]');
    const salaryInput = form.querySelector('input[name="salary"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');
    const imageInput = form.querySelector('input[name="image"]');
    
    if (!nameInput || !emailInput || !phoneInput || !salaryInput) return;
    
    function removeError(input) {
        const err = input.parentElement.querySelector('.invalid-feedback');
        if (err) err.remove();
    }
    
    function addError(input, msg) {
        removeError(input);
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        const err = document.createElement('div');
        err.className = 'invalid-feedback';
        err.textContent = msg;
        input.parentElement.appendChild(err);
    }
    
    function addSuccess(input) {
        removeError(input);
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }
    
    function validateName() {
        const val = nameInput.value.trim();
        if (!val) { addError(nameInput, 'Vui lòng nhập tên.'); return false; }
        if (val.length < 2) { addError(nameInput, 'Tên phải có ít nhất 2 ký tự.'); return false; }
        if (val.length > 100) { addError(nameInput, 'Tên không được vượt quá 100 ký tự.'); return false; }
        addSuccess(nameInput); return true;
    }
    
    function validateEmail() {
        const val = emailInput.value.trim();
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!val) { addError(emailInput, 'Vui lòng nhập email.'); return false; }
        if (!regex.test(val)) { addError(emailInput, 'Email không hợp lệ.'); return false; }
        addSuccess(emailInput); return true;
    }
    
    function validatePhone() {
        const val = phoneInput.value.trim();
        const regex = /^[0-9]{10,11}$/;
        if (!val) { addError(phoneInput, 'Vui lòng nhập số điện thoại.'); return false; }
        if (!regex.test(val)) { addError(phoneInput, 'Số điện thoại phải có 10-11 chữ số.'); return false; }
        addSuccess(phoneInput); return true;
    }
    
    function validateSalary() {
        const val = parseFloat(salaryInput.value);
        if (isNaN(val) || !salaryInput.value.trim()) { addError(salaryInput, 'Vui lòng nhập lương.'); return false; }
        if (val < 0) { addError(salaryInput, 'Lương không được âm.'); return false; }
        addSuccess(salaryInput); return true;
    }
    
    function validatePassword() {
        if (isEditForm && (!passwordInput || !passwordInput.value.trim())) return true;
        if (!passwordInput || !passwordInput.value) { addError(passwordInput, 'Vui lòng nhập mật khẩu.'); return false; }
        if (passwordInput.value.length < 8) { addError(passwordInput, 'Mật khẩu phải có ít nhất 8 ký tự.'); return false; }
        addSuccess(passwordInput); return true;
    }
    
    function validateConfirmPassword() {
        if (isEditForm && (!passwordInput || !passwordInput.value.trim())) return true;
        if (!confirmPasswordInput || !confirmPasswordInput.value) { addError(confirmPasswordInput, 'Vui lòng xác nhận mật khẩu.'); return false; }
        if (passwordInput.value !== confirmPasswordInput.value) { addError(confirmPasswordInput, 'Mật khẩu xác nhận không khớp.'); return false; }
        addSuccess(confirmPasswordInput); return true;
    }
    
    function validateImage() {
        if (isEditForm && (!imageInput.files || imageInput.files.length === 0)) return true;
        if (!isEditForm && (!imageInput.files || imageInput.files.length === 0)) { addError(imageInput, 'Vui lòng chọn ảnh.'); return false; }
        if (imageInput.files && imageInput.files.length > 0) {
            const file = imageInput.files[0];
            if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) { addError(imageInput, 'Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.'); return false; }
            if (file.size > 5 * 1024 * 1024) { addError(imageInput, 'Kích thước file không được vượt quá 5MB.'); return false; }
        }
        if (imageInput.files && imageInput.files.length > 0) addSuccess(imageInput);
        return true;
    }
    
    nameInput.addEventListener('blur', validateName);
    emailInput.addEventListener('blur', validateEmail);
    phoneInput.addEventListener('blur', validatePhone);
    salaryInput.addEventListener('blur', validateSalary);
    if (passwordInput) passwordInput.addEventListener('blur', validatePassword);
    if (confirmPasswordInput) confirmPasswordInput.addEventListener('blur', validateConfirmPassword);
    if (imageInput) imageInput.addEventListener('change', validateImage);
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateName() && validateEmail() && validatePhone() && validateSalary() && validatePassword() && validateConfirmPassword() && validateImage()) {
            form.submit();
        } else {
            const firstError = form.querySelector('.is-invalid');
            if (firstError) { firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }); firstError.focus(); }
        }
    });
    
    if (isEditForm) {
        setTimeout(() => {
            if (nameInput.value.trim()) validateName();
            if (emailInput.value.trim()) validateEmail();
            if (phoneInput.value.trim()) validatePhone();
            if (salaryInput.value.trim()) validateSalary();
        }, 100);
    }
});

