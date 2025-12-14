document.addEventListener('DOMContentLoaded', function() {
    const menuContainer = document.getElementById('menuCardsContainer');
    const paginationContainer = document.getElementById('paginationContainer');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const perPageSelect = document.getElementById('perPage');
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    let currentPage = 1;
    let perPage = 12;
    let searchTimeout;
    let priceTimeout;

    // Load products on page load
    loadProducts();

    // Handle per page change
    perPageSelect.addEventListener('change', function() {
        perPage = parseInt(this.value);
        currentPage = 1;
        loadProducts();
    });

    // Handle search input with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            currentPage = 1;
            loadProducts();
        }, 500); // Wait 500ms after user stops typing
    });

    // Handle category filter
    categoryFilter.addEventListener('change', function() {
        currentPage = 1;
        loadProducts();
    });

    // Handle price filters
    priceMin.addEventListener('change', function() {
        currentPage = 1;
        loadProducts();
    });

    priceMax.addEventListener('change', function() {
        currentPage = 1;
        loadProducts();
    });

    // Handle reset filters
    resetFiltersBtn.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        priceMin.value = '';
        priceMax.value = '';
        perPageSelect.value = 12;
        perPage = 12;
        currentPage = 1;
        loadProducts();
    });

    // Handle pagination clicks (delegated event listener)
    paginationContainer.addEventListener('click', function(e) {
        e.preventDefault();
        
        const link = e.target.closest('a');
        if (!link || link.classList.contains('disabled')) return;

        const url = new URL(link.href);
        const page = url.searchParams.get('page');
        
        if (page) {
            currentPage = parseInt(page);
            loadProducts();
        }
    });

    function loadProducts() {
        // Show loading indicator
        loadingIndicator.style.display = 'block';
        menuContainer.style.opacity = '0.5';
        paginationContainer.style.opacity = '0.5';

        // Build URL with query parameters
        const url = new URL('/menu/products', window.location.origin);
        url.searchParams.append('page', currentPage);
        url.searchParams.append('per_page', perPage);
        
        // Add search parameter
        if (searchInput.value.trim() !== '') {
            url.searchParams.append('search', searchInput.value.trim());
        }
        
        // Add category parameter
        if (categoryFilter.value !== '') {
            url.searchParams.append('category', categoryFilter.value);
        }
        
        // Add price parameters
        if (priceMin.value !== '') {
            url.searchParams.append('price_min', priceMin.value);
        }
        if (priceMax.value !== '') {
            url.searchParams.append('price_max', priceMax.value);
        }

        // Make AJAX request
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Update menu cards
            menuContainer.innerHTML = data.html;
            
            // Update pagination
            paginationContainer.innerHTML = data.pagination;
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            // Hide loading indicator
            loadingIndicator.style.display = 'none';
            menuContainer.style.opacity = '1';
            paginationContainer.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error loading products:', error);
            loadingIndicator.style.display = 'none';
            menuContainer.style.opacity = '1';
            paginationContainer.style.opacity = '1';
            
            // Show error message
            menuContainer.innerHTML = '<div style="text-align: center; padding: 40px; color: #fb5849;"><p>Có lỗi xảy ra khi tải sản phẩm. Vui lòng thử lại.</p></div>';
        });
    }
});
