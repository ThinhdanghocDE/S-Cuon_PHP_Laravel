/**
 * Menu Form Validation
 * Client-side validation for add and edit menu form
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="/menu/add/process"], form[action*="/menu/edit/process"]');
    if (!form) return;
    
    const isEditForm = form.action.includes('/menu/edit/process');
    const nameInput = form.querySelector('input[name="name"]');
    const descriptionInput = form.querySelector('textarea[name="description"]');
    const priceInput = form.querySelector('input[name="price"]');
    const imageInput = form.querySelector('input[name="image"]');
    
    if (!nameInput || !descriptionInput || !priceInput) return;
    
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
        if (!val) { addError(nameInput, 'Vui lòng nhập tên món.'); return false; }
        if (val.length < 2) { addError(nameInput, 'Tên món phải có ít nhất 2 ký tự.'); return false; }
        if (val.length > 200) { addError(nameInput, 'Tên món không được vượt quá 200 ký tự.'); return false; }
        addSuccess(nameInput); return true;
    }
    
    function validateDescription() {
        const val = descriptionInput.value.trim();
        if (!val) { addError(descriptionInput, 'Vui lòng nhập mô tả.'); return false; }
        if (val.length < 10) { addError(descriptionInput, 'Mô tả phải có ít nhất 10 ký tự.'); return false; }
        if (val.length > 1000) { addError(descriptionInput, 'Mô tả không được vượt quá 1000 ký tự.'); return false; }
        addSuccess(descriptionInput); return true;
    }
    
    function validatePrice() {
        const val = parseFloat(priceInput.value);
        if (isNaN(val) || !priceInput.value.trim()) { addError(priceInput, 'Vui lòng nhập giá.'); return false; }
        if (val < 0) { addError(priceInput, 'Giá không được âm.'); return false; }
        addSuccess(priceInput); return true;
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
    descriptionInput.addEventListener('blur', validateDescription);
    priceInput.addEventListener('blur', validatePrice);
    if (imageInput) imageInput.addEventListener('change', validateImage);
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (validateName() && validateDescription() && validatePrice() && validateImage()) {
            form.submit();
        } else {
            const firstError = form.querySelector('.is-invalid');
            if (firstError) { firstError.scrollIntoView({ behavior: 'smooth', block: 'center' }); firstError.focus(); }
        }
    });
    
    if (isEditForm) {
        setTimeout(() => {
            if (nameInput.value.trim()) validateName();
            if (descriptionInput.value.trim()) validateDescription();
            if (priceInput.value.trim()) validatePrice();
        }, 100);
    }
});

