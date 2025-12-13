/**
 * Chef Form Validation
 * Client-side validation for add and edit chef form
 */

document.addEventListener('DOMContentLoaded', function() {
    // Support both add and edit forms
    const chefForm = document.querySelector('form[action*="/chef/add/process"], form[action*="/edit/chef/process"]');
    
    if (!chefForm) {
        return;
    }
    
    // Check if it's edit form (image is optional)
    const isEditForm = chefForm.action.includes('/edit/chef/process');
    
    // Get form elements (support both add and edit forms)
    const nameInput = chefForm.querySelector('input[name="name"]');
    const jobInput = chefForm.querySelector('input[name="job"]');
    const fbInput = chefForm.querySelector('input[name="fb"]');
    const twitterInput = chefForm.querySelector('input[name="twitter"]');
    const instagramInput = chefForm.querySelector('input[name="instagram"]');
    const imageInput = chefForm.querySelector('input[name="image"]');
    const submitBtn = chefForm.querySelector('button[type="submit"]');
    
    if (!nameInput || !jobInput || !imageInput) {
        console.error('Required form elements not found');
        return;
    }
    
    // URL validation regex
    const urlRegex = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
    
    // Add validation styles
    function addErrorStyle(input) {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    }
    
    function addSuccessStyle(input) {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
    }
    
    function removeValidationStyle(input) {
        input.classList.remove('is-invalid', 'is-valid');
    }
    
    // Create error message element
    function createErrorMessage(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        return errorDiv;
    }
    
    // Remove existing error message
    function removeErrorMessage(input) {
        const existingError = input.parentElement.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
    }
    
    // Validate name
    function validateName() {
        const value = nameInput.value.trim();
        removeErrorMessage(nameInput);
        
        if (!value) {
            addErrorStyle(nameInput);
            nameInput.parentElement.appendChild(createErrorMessage('Vui lòng nhập tên đầu bếp.'));
            return false;
        }
        
        if (value.length < 2) {
            addErrorStyle(nameInput);
            nameInput.parentElement.appendChild(createErrorMessage('Tên đầu bếp phải có ít nhất 2 ký tự.'));
            return false;
        }
        
        if (value.length > 100) {
            addErrorStyle(nameInput);
            nameInput.parentElement.appendChild(createErrorMessage('Tên đầu bếp không được vượt quá 100 ký tự.'));
            return false;
        }
        
        addSuccessStyle(nameInput);
        return true;
    }
    
    // Validate job title
    function validateJobTitle() {
        const value = jobInput.value.trim();
        removeErrorMessage(jobInput);
        
        if (!value) {
            addErrorStyle(jobInput);
            jobInput.parentElement.appendChild(createErrorMessage('Vui lòng nhập chức danh.'));
            return false;
        }
        
        if (value.length < 2) {
            addErrorStyle(jobInput);
            jobInput.parentElement.appendChild(createErrorMessage('Chức danh phải có ít nhất 2 ký tự.'));
            return false;
        }
        
        if (value.length > 100) {
            addErrorStyle(jobInput);
            jobInput.parentElement.appendChild(createErrorMessage('Chức danh không được vượt quá 100 ký tự.'));
            return false;
        }
        
        addSuccessStyle(jobInput);
        return true;
    }
    
    // Validate URL (optional field)
    function validateURL(input, fieldName) {
        const value = input.value.trim();
        removeErrorMessage(input);
        
        // If empty, it's optional, so valid
        if (!value) {
            removeValidationStyle(input);
            return true;
        }
        
        // If not empty, must be valid URL
        if (!urlRegex.test(value)) {
            addErrorStyle(input);
            input.parentElement.appendChild(createErrorMessage('Vui lòng nhập URL hợp lệ cho ' + fieldName + '.'));
            return false;
        }
        
        addSuccessStyle(input);
        return true;
    }
    
    // Validate image
    function validateImage() {
        removeErrorMessage(imageInput);
        
        // Image is optional in edit form
        if (isEditForm && (!imageInput.files || imageInput.files.length === 0)) {
            removeValidationStyle(imageInput);
            return true; // Valid if no file selected in edit form
        }
        
        // Image is required in add form
        if (!isEditForm && (!imageInput.files || imageInput.files.length === 0)) {
            addErrorStyle(imageInput);
            imageInput.parentElement.appendChild(createErrorMessage('Vui lòng chọn ảnh đầu bếp.'));
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
    nameInput.addEventListener('input', function() {
        if (nameInput.classList.contains('is-invalid')) {
            validateName();
        }
    });
    
    jobInput.addEventListener('blur', validateJobTitle);
    jobInput.addEventListener('input', function() {
        if (jobInput.classList.contains('is-invalid')) {
            validateJobTitle();
        }
    });
    
    fbInput.addEventListener('blur', function() {
        validateURL(fbInput, 'Facebook');
    });
    fbInput.addEventListener('input', function() {
        if (fbInput.classList.contains('is-invalid')) {
            validateURL(fbInput, 'Facebook');
        }
    });
    
    twitterInput.addEventListener('blur', function() {
        validateURL(twitterInput, 'Twitter');
    });
    twitterInput.addEventListener('input', function() {
        if (twitterInput.classList.contains('is-invalid')) {
            validateURL(twitterInput, 'Twitter');
        }
    });
    
    instagramInput.addEventListener('blur', function() {
        validateURL(instagramInput, 'Instagram');
    });
    instagramInput.addEventListener('input', function() {
        if (instagramInput.classList.contains('is-invalid')) {
            validateURL(instagramInput, 'Instagram');
        }
    });
    
    imageInput.addEventListener('change', validateImage);
    
    // Form submission validation
    chefForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Remove all previous error messages
        const allInputs = chefForm.querySelectorAll('input');
        allInputs.forEach(input => {
            removeErrorMessage(input);
        });
        
        // Validate all fields
        const isNameValid = validateName();
        const isJobValid = validateJobTitle();
        const isFbValid = validateURL(fbInput, 'Facebook');
        const isTwitterValid = validateURL(twitterInput, 'Twitter');
        const isInstagramValid = validateURL(instagramInput, 'Instagram');
        const isImageValid = validateImage();
        
        // If all valid, submit form
        if (isNameValid && isJobValid && isFbValid && isTwitterValid && isInstagramValid && isImageValid) {
            chefForm.submit();
        } else {
            // Scroll to first error
            const firstError = chefForm.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
    
    // Initialize validation for edit form (validate existing values on load)
    if (isEditForm) {
        // Validate existing values when form loads
        setTimeout(function() {
            if (nameInput.value.trim()) validateName();
            if (jobInput.value.trim()) validateJobTitle();
            if (fbInput.value.trim()) validateURL(fbInput, 'Facebook');
            if (twitterInput.value.trim()) validateURL(twitterInput, 'Twitter');
            if (instagramInput.value.trim()) validateURL(instagramInput, 'Instagram');
        }, 100);
    }
});

