/**
 * Admin Form Validation
 * Client-side validation for add and edit admin form
 */

document.addEventListener('DOMContentLoaded', function() {
    // Support both add and edit forms
    const adminForm = document.querySelector('form[action*="/admin-add-process"], form[action*="/admin-edit-process"]');
    
    if (!adminForm) {
        return;
    }
    
    // Check if it's edit form (password is optional)
    const isEditForm = adminForm.action.includes('/admin-edit-process');
    
    // Get form elements
    const nameInput = adminForm.querySelector('input[name="name"]');
    const emailInput = adminForm.querySelector('input[name="email"]');
    const phoneInput = adminForm.querySelector('input[name="phone"]');
    const typeSelect = adminForm.querySelector('select[name="type"]');
    const salaryInput = adminForm.querySelector('input[name="salary"]');
    const passwordInput = adminForm.querySelector('input[name="password"]');
    const confirmPasswordInput = adminForm.querySelector('input[name="confirm_password"]');
    const imageInput = adminForm.querySelector('input[name="image"]');
    
    if (!nameInput || !emailInput || !phoneInput || !typeSelect || !salaryInput) {
        console.error('Required form elements not found');
        return;
    }
    
    // Helper functions
    function removeErrorMessage(input) {
        const errorMsg = input.parentElement.querySelector('.invalid-feedback');
        if (errorMsg) {
            errorMsg.remove();
        }
    }
    
    function createErrorMessage(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        return errorDiv;
    }
    
    function addErrorStyle(input) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    }
    
    function addSuccessStyle(input) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    }
    
    function removeValidationStyle(input) {
        input.classList.remove('is-invalid', 'is-valid');
    }
    
    // Validate name
    function validateName() {
        removeErrorMessage(nameInput);
        
        const name = nameInput.value.trim();
        if (name.length === 0) {
            addErrorStyle(nameInput);
            nameInput.parentElement.appendChild(createErrorMessage('Vui lòng nhập tên.'));
            return false;
        }
        if (name.length < 2) {
            addErrorStyle(nameInput);
            nameInput.parentElement.appendChild(createErrorMessage('Tên phải có ít nhất 2 ký tự.'));
            return false;
        }
        if (name.length > 100) {
            addErrorStyle(nameInput);
            nameInput.parentElement.appendChild(createErrorMessage('Tên không được vượt quá 100 ký tự.'));
            return false;
        }
        
        addSuccessStyle(nameInput);
        return true;
    }
    
    // Validate email
    function validateEmail() {
        removeErrorMessage(emailInput);
        
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email.length === 0) {
            addErrorStyle(emailInput);
            emailInput.parentElement.appendChild(createErrorMessage('Vui lòng nhập email.'));
            return false;
        }
        if (!emailRegex.test(email)) {
            addErrorStyle(emailInput);
            emailInput.parentElement.appendChild(createErrorMessage('Email không hợp lệ.'));
            return false;
        }
        
        addSuccessStyle(emailInput);
        return true;
    }
    
    // Validate phone
    function validatePhone() {
        removeErrorMessage(phoneInput);
        
        const phone = phoneInput.value.trim();
        const phoneRegex = /^[0-9]{10,11}$/;
        
        if (phone.length === 0) {
            addErrorStyle(phoneInput);
            phoneInput.parentElement.appendChild(createErrorMessage('Vui lòng nhập số điện thoại.'));
            return false;
        }
        if (!phoneRegex.test(phone)) {
            addErrorStyle(phoneInput);
            phoneInput.parentElement.appendChild(createErrorMessage('Số điện thoại phải có 10-11 chữ số.'));
            return false;
        }
        
        addSuccessStyle(phoneInput);
        return true;
    }
    
    // Validate salary
    function validateSalary() {
        removeErrorMessage(salaryInput);
        
        const salary = parseFloat(salaryInput.value);
        
        if (isNaN(salary) || salaryInput.value.trim().length === 0) {
            addErrorStyle(salaryInput);
            salaryInput.parentElement.appendChild(createErrorMessage('Vui lòng nhập lương.'));
            return false;
        }
        if (salary < 0) {
            addErrorStyle(salaryInput);
            salaryInput.parentElement.appendChild(createErrorMessage('Lương không được âm.'));
            return false;
        }
        
        addSuccessStyle(salaryInput);
        return true;
    }
    
    // Validate password (only for add form)
    function validatePassword() {
        if (isEditForm) {
            // Password is optional in edit form
            if (passwordInput && passwordInput.value.trim().length > 0) {
                if (passwordInput.value.length < 8) {
                    removeErrorMessage(passwordInput);
                    addErrorStyle(passwordInput);
                    passwordInput.parentElement.appendChild(createErrorMessage('Mật khẩu phải có ít nhất 8 ký tự.'));
                    return false;
                }
                addSuccessStyle(passwordInput);
            }
            return true;
        }
        
        // Password is required in add form
        removeErrorMessage(passwordInput);
        
        if (!passwordInput || passwordInput.value.length === 0) {
            addErrorStyle(passwordInput);
            passwordInput.parentElement.appendChild(createErrorMessage('Vui lòng nhập mật khẩu.'));
            return false;
        }
        if (passwordInput.value.length < 8) {
            addErrorStyle(passwordInput);
            passwordInput.parentElement.appendChild(createErrorMessage('Mật khẩu phải có ít nhất 8 ký tự.'));
            return false;
        }
        
        addSuccessStyle(passwordInput);
        return true;
    }
    
    // Validate confirm password
    function validateConfirmPassword() {
        if (isEditForm) {
            // Only validate if password is provided
            if (passwordInput && passwordInput.value.trim().length > 0) {
                if (!confirmPasswordInput || confirmPasswordInput.value.length === 0) {
                    removeErrorMessage(confirmPasswordInput);
                    addErrorStyle(confirmPasswordInput);
                    confirmPasswordInput.parentElement.appendChild(createErrorMessage('Vui lòng xác nhận mật khẩu.'));
                    return false;
                }
                if (passwordInput.value !== confirmPasswordInput.value) {
                    removeErrorMessage(confirmPasswordInput);
                    addErrorStyle(confirmPasswordInput);
                    confirmPasswordInput.parentElement.appendChild(createErrorMessage('Mật khẩu xác nhận không khớp.'));
                    return false;
                }
                addSuccessStyle(confirmPasswordInput);
            }
            return true;
        }
        
        // Required in add form
        removeErrorMessage(confirmPasswordInput);
        
        if (!confirmPasswordInput || confirmPasswordInput.value.length === 0) {
            addErrorStyle(confirmPasswordInput);
            confirmPasswordInput.parentElement.appendChild(createErrorMessage('Vui lòng xác nhận mật khẩu.'));
            return false;
        }
        if (passwordInput.value !== confirmPasswordInput.value) {
            addErrorStyle(confirmPasswordInput);
            confirmPasswordInput.parentElement.appendChild(createErrorMessage('Mật khẩu xác nhận không khớp.'));
            return false;
        }
        
        addSuccessStyle(confirmPasswordInput);
        return true;
    }
    
    // Validate image
    function validateImage() {
        removeErrorMessage(imageInput);
        
        // Image is optional in edit form
        if (isEditForm && (!imageInput.files || imageInput.files.length === 0)) {
            removeValidationStyle(imageInput);
            return true;
        }
        
        // Image is required in add form
        if (!isEditForm && (!imageInput.files || imageInput.files.length === 0)) {
            addErrorStyle(imageInput);
            imageInput.parentElement.appendChild(createErrorMessage('Vui lòng chọn ảnh.'));
            return false;
        }
        
        // If file is selected, validate it
        if (imageInput.files && imageInput.files.length > 0) {
            const file = imageInput.files[0];
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (!validTypes.includes(file.type)) {
                addErrorStyle(imageInput);
                imageInput.parentElement.appendChild(createErrorMessage('Chỉ chấp nhận file ảnh định dạng JPG, JPEG hoặc PNG.'));
                return false;
            }
            
            if (file.size > maxSize) {
                addErrorStyle(imageInput);
                imageInput.parentElement.appendChild(createErrorMessage('Kích thước file không được vượt quá 5MB.'));
                return false;
            }
            
            addSuccessStyle(imageInput);
        }
        
        return true;
    }
    
    // Real-time validation
    nameInput.addEventListener('blur', validateName);
    emailInput.addEventListener('blur', validateEmail);
    phoneInput.addEventListener('blur', validatePhone);
    salaryInput.addEventListener('blur', validateSalary);
    
    if (passwordInput) {
        passwordInput.addEventListener('blur', validatePassword);
        passwordInput.addEventListener('input', function() {
            if (confirmPasswordInput && confirmPasswordInput.value.length > 0) {
                validateConfirmPassword();
            }
        });
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('blur', validateConfirmPassword);
        confirmPasswordInput.addEventListener('input', validateConfirmPassword);
    }
    
    if (imageInput) {
        imageInput.addEventListener('change', validateImage);
    }
    
    // Form submission
    adminForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all fields
        const isNameValid = validateName();
        const isEmailValid = validateEmail();
        const isPhoneValid = validatePhone();
        const isSalaryValid = validateSalary();
        const isPasswordValid = validatePassword();
        const isConfirmPasswordValid = validateConfirmPassword();
        const isImageValid = validateImage();
        
        // If all valid, submit form
        if (isNameValid && isEmailValid && isPhoneValid && isSalaryValid && isPasswordValid && isConfirmPasswordValid && isImageValid) {
            adminForm.submit();
        } else {
            // Scroll to first error
            const firstError = adminForm.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
    
    // Initialize validation for edit form
    if (isEditForm) {
        setTimeout(function() {
            if (nameInput.value.trim()) validateName();
            if (emailInput.value.trim()) validateEmail();
            if (phoneInput.value.trim()) validatePhone();
            if (salaryInput.value.trim()) validateSalary();
        }, 100);
    }
});

