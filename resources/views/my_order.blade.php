@extends('layout', ['title'=> 'My Orders'])

@section('page-content')
<div class="my-orders-container">
    <div class="container" style="padding-top: 100px; padding-bottom: 50px;">
        <div class="text-center mb-5">
            <h1 class="orders-page-title">Đơn Hàng Của Tôi</h1>
            <p class="orders-page-subtitle">Theo dõi tất cả đơn hàng của bạn</p>
        </div>

        @php
            // Nhóm các sản phẩm theo invoice_no
            $orders = [];
            foreach($carts as $product) {
                $invoice_no = $product->invoice_no;
                if(!isset($orders[$invoice_no])) {
                    $orders[$invoice_no] = [
                        'invoice_no' => $invoice_no,
                        'purchase_date' => $product->purchase_date,
                        'pay_method' => $product->pay_method,
                        'products' => [],
                        'total' => 0
                    ];
                }
                $orders[$invoice_no]['products'][] = $product;
                $orders[$invoice_no]['total'] += $product->subtotal;
            }
            // Sắp xếp theo ngày mua (mới nhất trước)
            krsort($orders);
        @endphp

        @if(count($orders) > 0)
            <div class="orders-list">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-header-left">
                                <h3 class="order-invoice">
                                    <i class="fa fa-file-text-o"></i> 
                                    Mã đơn: <strong>{{ $order['invoice_no'] }}</strong>
                                </h3>
                                <p class="order-date">
                                    <i class="fa fa-calendar"></i> 
                                    Ngày đặt: {{ date('d/m/Y', strtotime($order['purchase_date'])) }}
                                </p>
                            </div>
                            <div class="order-header-right">
                                <span class="order-payment-method">
                                    <i class="fa fa-credit-card"></i> 
                                    {{ $order['pay_method'] }}
                                </span>
                            </div>
                        </div>

                        <div class="order-body">
                            <table class="order-products-table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">Đơn giá</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-right">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order['products'] as $product)
                                        <tr>
                                            <td class="product-name">{{ $product->name }}</td>
                                            <td class="text-center">{{ number_format((float)$product->price * 1000, 0, ',', '.') }} VNĐ</td>
                                            <td class="text-center">{{ $product->quantity }}</td>
                                            <td class="text-right">{{ number_format((float)$product->subtotal * 1000, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="order-total-row">
                                        <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                                        <td class="text-right order-total-amount">
                                            <strong>{{ number_format((float)$order['total'] * 1000, 0, ',', '.') }} VNĐ</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4 mb-4">
                <a href="{{ url('/menu') }}" class="btn-continue-shopping">
                    <i class="fa fa-angle-left"></i> Tiếp tục mua sắm
                </a>
            </div>
        @else
            <div class="empty-orders">
                <div class="empty-orders-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <h3>Chưa có đơn hàng nào</h3>
                <p>Bạn chưa có đơn hàng nào. Hãy bắt đầu mua sắm ngay!</p>
                <a href="{{ url('/menu') }}" class="btn-continue-shopping">
                    <i class="fa fa-shopping-bag"></i> Xem thực đơn
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
    .my-orders-container {
        min-height: 100vh;
        background: #f8f9fa;
    }

    .orders-page-title {
        font-family: 'Dancing Script', cursive;
        font-size: 3.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #fb5849 0%, #d15400 30%, #ff6b5a 60%, #fb5849 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .orders-page-subtitle {
        font-size: 1.1rem;
        color: #666;
        font-style: italic;
    }

    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .order-card {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
    }

    .order-header {
        background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
        color: #fff;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .order-header-left h3 {
        margin: 0 0 8px 0;
        font-size: 1.4rem;
        font-weight: 600;
    }

    .order-header-left p {
        margin: 0;
        font-size: 0.95rem;
        opacity: 0.95;
    }

    .order-invoice i,
    .order-date i,
    .order-payment-method i {
        margin-right: 8px;
    }

    .order-payment-method {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .order-body {
        padding: 25px 30px;
    }

    .order-products-table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-products-table thead {
        background: #f8f9fa;
    }

    .order-products-table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e9ecef;
        font-size: 0.95rem;
    }

    .order-products-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s ease;
    }

    .order-products-table tbody tr:hover {
        background: #f8f9fa;
    }

    .order-products-table td {
        padding: 15px 12px;
        color: #555;
    }

    .product-name {
        font-weight: 500;
        color: #333;
    }

    .order-total-row {
        background: #f8f9fa;
        border-top: 2px solid #e9ecef;
    }

    .order-total-row td {
        padding: 18px 12px;
        font-size: 1.1rem;
    }

    .order-total-amount {
        font-size: 1.3rem !important;
        color: #fb5849;
    }

    .btn-continue-shopping {
        display: inline-block;
        padding: 12px 30px;
        background: linear-gradient(135deg, #fb5849 0%, #d15400 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(251, 88, 73, 0.3);
    }

    .btn-continue-shopping:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(251, 88, 73, 0.4);
        color: #fff;
        text-decoration: none;
    }

    .btn-continue-shopping i {
        margin-right: 8px;
    }

    .empty-orders {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .empty-orders-icon {
        font-size: 5rem;
        color: #ddd;
        margin-bottom: 20px;
    }

    .empty-orders h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }

    .empty-orders p {
        color: #666;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .orders-page-title {
            font-size: 2.5rem;
        }

        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-header-right {
            width: 100%;
        }

        .order-body {
            padding: 15px;
            overflow-x: auto;
        }

        .order-products-table {
            min-width: 600px;
        }

        .order-products-table th,
        .order-products-table td {
            padding: 10px 8px;
            font-size: 0.9rem;
        }
    }
</style>
@endpush
@endsection