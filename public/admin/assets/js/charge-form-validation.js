/**
 * Charge Form Validation
 * Client-side validation for add and edit charge form
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="/charge-add-process"], form[action*="/charge-edit-process"]');
    if (!form) return;
    
    const nameInput = form.querySelector('input[name="name"]');
    const priceInput = form.querySelector('input[name="price"]');
    
    if (!nameInput || !priceInput) return;
    
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
        if (!val) { addError(nameInput, 'Vui lòng nhập tên phí.'); return false; }
        if (val.length < 2) { addError(nameInput, 'Tên phí phải có ít nhất 2 ký tự.'); return false; }
        if (val.length > 100) { addError(nameInput, 'Tên phí không được vượt quá 100 ký tự.'); return false; }
        addSuccess(nameInput); return true;
    }
    
    function validatePrice() {
        const val = parseFloat(priceInput.value);
        if (isNaN(val) || !priceInput.value.trim()) { addError(priceInput, 'Vui lòng nhập giá.'); return false; }
        if (val < 0) { addError(priceInput, 'Giá không được âm.'); return false; }
        addSuccess(priceInput); return true;
    }
    
    nameInput.addEventListener('blur', validateName);
    priceInput.addEventListener('blur', validatePrice);
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateName() && validatePrice()) {
            form.submit();
        } else {
            const firstError = form.querySelector('.is-invalid');
            if (firstError) { firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }); firstError.focus(); }
        }
    });
});

