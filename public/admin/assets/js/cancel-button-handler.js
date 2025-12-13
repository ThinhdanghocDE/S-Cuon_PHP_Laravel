/**
 * Cancel Button Handler
 * Xử lý logic cho nút Cancel trong các form:
 * - Nếu chưa điền thông tin: quay về trang trước ngay
 * - Nếu đã điền thông tin: hiển thị popup xác nhận
 */

document.addEventListener('DOMContentLoaded', function() {
    // Tìm tất cả các nút Cancel trong form
    const cancelButtons = document.querySelectorAll('a.btn-dark[href], button.btn-dark');
    
    cancelButtons.forEach(function(cancelBtn) {
        // Chỉ xử lý các nút Cancel trong form
        const form = cancelBtn.closest('form');
        if (!form) return;
        
        // Lưu URL để quay về
        const cancelUrl = cancelBtn.getAttribute('href') || cancelBtn.dataset.cancelUrl;
        if (!cancelUrl) return;
        
        // Lưu giá trị ban đầu của form
        const initialFormData = getFormData(form);
        
        // Thay đổi từ link thành button để có thể xử lý event
        if (cancelBtn.tagName === 'A') {
            const newBtn = document.createElement('button');
            newBtn.type = 'button';
            newBtn.className = cancelBtn.className;
            newBtn.textContent = cancelBtn.textContent;
            newBtn.dataset.cancelUrl = cancelUrl;
            cancelBtn.parentNode.replaceChild(newBtn, cancelBtn);
            setupCancelHandler(newBtn, form, initialFormData, cancelUrl);
        } else {
            setupCancelHandler(cancelBtn, form, initialFormData, cancelUrl);
        }
    });
});

/**
 * Lấy dữ liệu hiện tại của form
 */
function getFormData(form) {
    const formData = new FormData(form);
    const data = {};
    
    // Lấy giá trị từ tất cả các input, textarea, select
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(function(input) {
        if (input.type === 'file') {
            // File input: kiểm tra xem có file được chọn không
            data[input.name] = input.files.length > 0 ? 'file_selected' : '';
        } else if (input.type === 'checkbox' || input.type === 'radio') {
            data[input.name] = input.checked;
        } else {
            data[input.name] = input.value || '';
        }
    });
    
    return data;
}

/**
 * So sánh dữ liệu form hiện tại với dữ liệu ban đầu
 */
function hasFormChanged(form, initialData) {
    const currentData = getFormData(form);
    
    // So sánh từng field
    for (const key in currentData) {
        if (currentData.hasOwnProperty(key)) {
            // Bỏ qua các field không quan trọng (như _token, _method)
            if (key === '_token' || key === '_method') continue;
            
            // So sánh giá trị
            if (String(currentData[key]) !== String(initialData[key] || '')) {
                return true;
            }
        }
    }
    
    return false;
}

/**
 * Thiết lập handler cho nút Cancel
 */
function setupCancelHandler(btn, form, initialData, cancelUrl) {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Kiểm tra xem form có thay đổi không
        if (hasFormChanged(form, initialData)) {
            // Đã có thay đổi: hiển thị popup xác nhận
            showCancelConfirmation(cancelUrl);
        } else {
            // Chưa có thay đổi: quay về ngay
            window.location.href = cancelUrl;
        }
    });
}

/**
 * Hiển thị popup xác nhận
 */
function showCancelConfirmation(cancelUrl) {
    // Tạo modal nếu chưa có
    let modal = document.getElementById('cancelConfirmationModal');
    if (!modal) {
        modal = createCancelModal();
        document.body.appendChild(modal);
    }
    
    // Cập nhật URL để quay về
    const confirmBtn = modal.querySelector('#confirmCancelBtn');
    confirmBtn.onclick = function() {
        window.location.href = cancelUrl;
    };
    
    // Hiển thị modal
    modal.style.display = 'flex';
}

/**
 * Tạo modal xác nhận
 */
function createCancelModal() {
    const modal = document.createElement('div');
    modal.id = 'cancelConfirmationModal';
    modal.className = 'cancel-confirmation-modal';
    modal.innerHTML = `
        <div class="cancel-confirmation-modal-content">
            <div class="cancel-confirmation-modal-header">
                <span class="cancel-confirmation-modal-icon">⚠️</span>
                <h3 class="cancel-confirmation-modal-title">Xác nhận hủy</h3>
            </div>
            <div class="cancel-confirmation-modal-body">
                <p>Bạn đã nhập thông tin vào form. Bạn có chắc chắn muốn hủy và quay lại trang trước?</p>
                <p class="cancel-confirmation-modal-warning">Tất cả thông tin đã nhập sẽ bị mất.</p>
            </div>
            <div class="cancel-confirmation-modal-footer">
                <button type="button" class="cancel-confirmation-btn cancel-confirmation-btn-cancel" onclick="closeCancelConfirmationModal()">Ở lại</button>
                <button type="button" id="confirmCancelBtn" class="cancel-confirmation-btn cancel-confirmation-btn-confirm">Xác nhận hủy</button>
            </div>
        </div>
    `;
    
    // Đóng modal khi click bên ngoài
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeCancelConfirmationModal();
        }
    });
    
    return modal;
}

/**
 * Đóng modal xác nhận
 */
function closeCancelConfirmationModal() {
    const modal = document.getElementById('cancelConfirmationModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Export function để có thể gọi từ HTML
window.closeCancelConfirmationModal = closeCancelConfirmationModal;

