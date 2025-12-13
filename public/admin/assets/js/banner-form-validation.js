/**
 * Banner Form Validation
 * Client-side validation for add and edit banner form
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="/banner/add/process"], form[action*="/banner/edit/process"]');
    if (!form) return;
    
    const isEditForm = form.action.includes('/banner/edit/process');
    const imageInput = form.querySelector('input[name="image"]');
    
    if (!imageInput) return;
    
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
    
    imageInput.addEventListener('change', validateImage);
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateImage()) {
            form.submit();
        } else {
            const firstError = form.querySelector('.is-invalid');
            if (firstError) { firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }); firstError.focus(); }
        }
    });
});

