/**
 * Delete Confirmation Modal Functions
 * Handles confirmation dialogs for deleting admin, delivery boy, menu items, coupons, chefs, and banners
 */

// Admin Delete Confirmation
function confirmDeleteAdmin(id, name) {
    const modal = document.getElementById('deleteAdminModal');
    const adminNameSpan = document.getElementById('adminName');
    const confirmBtn = document.getElementById('confirmDeleteAdminBtn');
    
    if (!modal || !adminNameSpan || !confirmBtn) {
        console.error('Delete modal elements not found');
        return;
    }
    
    adminNameSpan.textContent = name;
    modal.style.display = 'block';
    
    // Update confirm button onclick
    confirmBtn.onclick = function() {
        window.location.href = "/admin/delete/" + id;
    };
}

function closeDeleteAdminModal() {
    const modal = document.getElementById('deleteAdminModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Delivery Boy Delete Confirmation
function confirmDeleteDeliveryBoy(id, name) {
    const modal = document.getElementById('deleteDeliveryBoyModal');
    const deliveryBoyNameSpan = document.getElementById('deliveryBoyName');
    const confirmBtn = document.getElementById('confirmDeleteDeliveryBoyBtn');
    
    if (!modal || !deliveryBoyNameSpan || !confirmBtn) {
        console.error('Delete modal elements not found');
        return;
    }
    
    deliveryBoyNameSpan.textContent = name;
    modal.style.display = 'block';
    
    // Update confirm button onclick
    confirmBtn.onclick = function() {
        window.location.href = "/delivery_boy/delete/" + id;
    };
}

function closeDeleteDeliveryBoyModal() {
    const modal = document.getElementById('deleteDeliveryBoyModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Menu Delete Confirmation
function confirmDeleteMenu(id, name) {
    const modal = document.getElementById('deleteMenuModal');
    const menuNameSpan = document.getElementById('menuName');
    const confirmBtn = document.getElementById('confirmDeleteMenuBtn');
    
    if (!modal || !menuNameSpan || !confirmBtn) {
        console.error('Delete modal elements not found');
        return;
    }
    
    menuNameSpan.textContent = name;
    modal.style.display = 'block';
    
    // Update confirm button onclick
    confirmBtn.onclick = function() {
        window.location.href = "/menu/delete/" + id;
    };
}

function closeDeleteMenuModal() {
    const modal = document.getElementById('deleteMenuModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Coupon Delete Confirmation
function confirmDeleteCoupon(id, name, code) {
    const modal = document.getElementById('deleteCouponModal');
    const couponNameSpan = document.getElementById('couponName');
    const couponCodeSpan = document.getElementById('couponCode');
    const confirmBtn = document.getElementById('confirmDeleteCouponBtn');
    
    if (!modal || !couponNameSpan || !couponCodeSpan || !confirmBtn) {
        console.error('Delete modal elements not found');
        return;
    }
    
    couponNameSpan.textContent = name;
    couponCodeSpan.textContent = code;
    modal.style.display = 'block';
    
    // Update confirm button onclick
    confirmBtn.onclick = function() {
        window.location.href = "/admin/coupon/delete/" + id;
    };
}

function closeDeleteCouponModal() {
    const modal = document.getElementById('deleteCouponModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Chef Delete Confirmation
function confirmDeleteChef(id, name) {
    const modal = document.getElementById('deleteChefModal');
    const chefNameSpan = document.getElementById('chefName');
    const confirmBtn = document.getElementById('confirmDeleteChefBtn');
    
    if (!modal || !chefNameSpan || !confirmBtn) {
        console.error('Delete modal elements not found');
        return;
    }
    
    chefNameSpan.textContent = name;
    modal.style.display = 'block';
    
    // Update confirm button onclick
    confirmBtn.onclick = function() {
        window.location.href = "/chef/delete/" + id;
    };
}

function closeDeleteChefModal() {
    const modal = document.getElementById('deleteChefModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Banner Delete Confirmation
function confirmDeleteBanner(id, bannerNumber) {
    const modal = document.getElementById('deleteBannerModal');
    const bannerNumberSpan = document.getElementById('bannerNumber');
    const confirmBtn = document.getElementById('confirmDeleteBannerBtn');
    
    if (!modal || !bannerNumberSpan || !confirmBtn) {
        console.error('Delete modal elements not found');
        return;
    }
    
    bannerNumberSpan.textContent = bannerNumber;
    modal.style.display = 'block';
    
    // Update confirm button onclick
    confirmBtn.onclick = function() {
        window.location.href = "/admin/banner/delete/" + id;
    };
}

function closeDeleteBannerModal() {
    const modal = document.getElementById('deleteBannerModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    window.onclick = function(event) {
        const adminModal = document.getElementById('deleteAdminModal');
        const deliveryBoyModal = document.getElementById('deleteDeliveryBoyModal');
        const menuModal = document.getElementById('deleteMenuModal');
        const couponModal = document.getElementById('deleteCouponModal');
        
        if (event.target == adminModal) {
            adminModal.style.display = 'none';
        }
        
        if (event.target == deliveryBoyModal) {
            deliveryBoyModal.style.display = 'none';
        }
        
        if (event.target == menuModal) {
            menuModal.style.display = 'none';
        }
        
        if (event.target == couponModal) {
            couponModal.style.display = 'none';
        }
        
        const chefModal = document.getElementById('deleteChefModal');
        if (event.target == chefModal) {
            chefModal.style.display = 'none';
        }
        
        const bannerModal = document.getElementById('deleteBannerModal');
        if (event.target == bannerModal) {
            bannerModal.style.display = 'none';
        }
    };
});

