@extends('layout', ['title'=> 'Menu'])

@section('page-content')

<div class="menu-page-container">
    <div class="container">
        <div class="menu-header">
            <h1 class="menu-title">Thực Đơn</h1>
            <p class="menu-subtitle">Bản đồ món cuốn Việt thu nhỏ trên bàn tiệc.</p>
        </div>

        <div class="menu-filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="searchInput">Tìm kiếm:</label>
                    <input type="text" id="searchInput" class="form-control" placeholder="Nhập tên món...">
                </div>
                
                <div class="filter-group">
                    <label for="categoryFilter">Phân loại:</label>
                    <select id="categoryFilter" class="form-control">
                        <option value="">Tất cả</option>
                        <option value="0">Món cuốn chính</option>
                        <option value="1">Món cuốn phụ</option>
                        <option value="2">Đồ uống</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="priceMin">Giá từ:</label>
                    <input type="number" id="priceMin" class="form-control" placeholder="Min" min="0" step="1">
                </div>

                <div class="filter-group">
                    <label for="priceMax">Đến:</label>
                    <input type="number" id="priceMax" class="form-control" placeholder="Max" min="0" step="1">
                </div>

                <div class="filter-group">
                    <label for="perPage">Hiển thị:</label>
                    <select id="perPage" class="form-control">
                        <option value="6">6 sản phẩm</option>
                        <option value="12" selected>12 sản phẩm</option>
                        <option value="24">24 sản phẩm</option>
                        <option value="48">48 sản phẩm</option>
                    </select>
                </div>

                <div class="filter-group">
                    <button type="button" id="resetFilters" class="btn-reset">Đặt lại</button>
                </div>
            </div>
        </div>

        <div id="menuCardsContainer" class="menu-cards-grid">
            <!-- Cards will be loaded here via AJAX -->
        </div>

        <div id="paginationContainer" class="pagination-wrapper">
            <!-- Pagination will be loaded here via AJAX -->
        </div>

        <div id="loadingIndicator" class="loading-indicator" style="display: none;">
            <div class="spinner"></div>
            <p>Đang tải...</p>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('css/menu.css')}}">
@endpush

@push('scripts')
<script src="{{asset('js/menu-pagination.js')}}"></script>
@endpush
