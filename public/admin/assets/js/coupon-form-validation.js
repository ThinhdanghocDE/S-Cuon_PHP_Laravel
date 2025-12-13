/**
 * Coupon Form Validation
 * Client-side validation for add and edit coupon form
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="/coupon-add-process"], form[action*="/coupon-edit-process"]');
    if (!form) return;
    
    const nameInput = form.querySelector('input[name="name"]');
    const detailsInput = form.querySelector('input[name="details"]');
    const codeInput = form.querySelector('input[name="code"]');
    const discountInput = form.querySelector('input[name="discount_percentage"]');
    const dateInput = form.querySelector('input[name="vaildation_date"]');
    
    if (!nameInput || !detailsInput || !codeInput || !discountInput || !dateInput) return;
    
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
        if (!val) { addError(nameInput, 'Vui lòng nhập tên coupon.'); return false; }
        if (val.length < 2) { addError(nameInput, 'Tên coupon phải có ít nhất 2 ký tự.'); return false; }
        if (val.length > 100) { addError(nameInput, 'Tên coupon không được vượt quá 100 ký tự.'); return false; }
        addSuccess(nameInput); return true;
    }
    
    function validateDetails() {
        const val = detailsInput.value.trim();
        if (!val) { addError(detailsInput, 'Vui lòng nhập chi tiết.'); return false; }
        if (val.length < 5) { addError(detailsInput, 'Chi tiết phải có ít nhất 5 ký tự.'); return false; }
        if (val.length > 500) { addError(detailsInput, 'Chi tiết không được vượt quá 500 ký tự.'); return false; }
        addSuccess(detailsInput); return true;
    }
    
    function validateCode() {
        const val = codeInput.value.trim().toUpperCase();
        if (!val) { addError(codeInput, 'Vui lòng nhập mã coupon.'); return false; }
        if (val.length < 3) { addError(codeInput, 'Mã coupon phải có ít nhất 3 ký tự.'); return false; }
        if (val.length > 20) { addError(codeInput, 'Mã coupon không được vượt quá 20 ký tự.'); return false; }
        if (!/^[A-Z0-9]+$/.test(val)) { addError(codeInput, 'Mã coupon chỉ được chứa chữ cái và số.'); return false; }
        codeInput.value = val; // Auto uppercase
        addSuccess(codeInput); return true;
    }
    
    function validateDiscount() {
        const val = parseFloat(discountInput.value);
        if (isNaN(val) || !discountInput.value.trim()) { addError(discountInput, 'Vui lòng nhập phần trăm giảm giá.'); return false; }
        if (val < 0) { addError(discountInput, 'Phần trăm giảm giá không được âm.'); return false; }
        if (val > 100) { addError(discountInput, 'Phần trăm giảm giá không được vượt quá 100%.'); return false; }
        addSuccess(discountInput); return true;
    }
    
    function validateDate() {
        const val = dateInput.value;
        if (!val) { addError(dateInput, 'Vui lòng chọn ngày hết hạn.'); return false; }
        const selectedDate = new Date(val);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        if (selectedDate <= today) { addError(dateInput, 'Ngày hết hạn phải sau ngày hiện tại.'); return false; }
        addSuccess(dateInput); return true;
    }
    
    nameInput.addEventListener('blur', validateName);
    detailsInput.addEventListener('blur', validateDetails);
    codeInput.addEventListener('blur', validateCode);
    codeInput.addEventListener('input', function() { codeInput.value = codeInput.value.toUpperCase(); });
    discountInput.addEventListener('blur', validateDiscount);
    dateInput.addEventListener('blur', validateDate);
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateName() && validateDetails() && validateCode() && validateDiscount() && validateDate()) {
            form.submit();
        } else {
            const firstError = form.querySelector('.is-invalid');
            if (firstError) { firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }); firstError.focus(); }
        }
    });
});

