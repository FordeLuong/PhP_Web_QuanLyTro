@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-primary"><i class="fas fa-chart-line me-2"></i> Dashboard - Quản Lý Nhà Trọ</h2>
        <p class="text-muted">Tổng quan tình hình kinh doanh và các thông báo quan trọng.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card card-hover shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body bg-gradient-primary text-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <i class="fas fa-home fa-4x opacity-75"></i>
                    <div class="text-end">
                        <h3 class="display-6 fw-bold mb-0">{{ $totalRooms }}</h3>
                        <p class="fs-5 mb-0">Tổng Số Phòng</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary-subtle text-primary border-0 py-3">
                <a href="{{ route('rooms.index') }}" class="text-decoration-none text-primary fw-medium">
                    Xem chi tiết <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-hover shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body bg-gradient-success text-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <i class="fas fa-door-open fa-4x opacity-75"></i>
                    <div class="text-end">
                        <h3 class="display-6 fw-bold mb-0">{{ $availableRooms }}</h3>
                        <p class="fs-5 mb-0">Phòng Trống</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success-subtle text-success border-0 py-3">
                <span class="text-success fw-medium">{{ $occupancyRate }}% đã được thuê</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-hover shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body bg-gradient-info text-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <i class="fas fa-users fa-4x opacity-75"></i>
                    <div class="text-end">
                        <h3 class="display-6 fw-bold mb-0">{{ $totalTenants }}</h3>
                        <p class="fs-5 mb-0">Khách Thuê</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info-subtle text-info border-0 py-3">
                <a href="{{ route('tenants.index') }}" class="text-decoration-none text-info fw-medium">
                    Xem chi tiết <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-hover shadow-sm border-0 rounded-3 overflow-hidden">
            <div class="card-body bg-gradient-warning text-white p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <i class="fas fa-file-contract fa-4x opacity-75"></i>
                    <div class="text-end">
                        <h3 class="display-6 fw-bold mb-0">{{ $activeContracts }}</h3>
                        <p class="fs-5 mb-0">Hợp Đồng Hiệu Lực</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-warning-subtle text-warning border-0 py-3">
                <a href="{{ route('contracts.index') }}" class="text-decoration-none text-warning fw-medium">
                    Xem chi tiết <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="fas fa-money-bill-wave text-success me-2"></i> Doanh Thu Tháng Này</h5>
            </div>
            <div class="card-body p-4">
                <h2 class="display-4 fw-bold text-success mb-3">{{ number_format($monthlyRevenue) }} <small class="text-muted fs-5">VNĐ</small></h2>
                <p class="text-muted mb-4">Tổng thu nhập từ {{ $activeContracts }} hợp đồng đang hoạt động.</p>

                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <span class="fw-medium">Thu nhập trung bình/phòng:</span>
                    <strong class="text-primary">{{ number_format($averageRent) }} VNĐ</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center py-2">
                    <span class="fw-medium">Tỷ lệ lấp đầy:</span>
                    <strong class="text-primary">{{ $occupancyRate }}%</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-3 h-100">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle text-warning me-2"></i> Hợp Đồng Sắp Hết Hạn</h5>
            </div>
            <div class="card-body p-4">
                @if($expiringContracts->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($expiringContracts as $contract)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-3">
                        <div>
                            <h6 class="mb-1 text-dark">Phòng {{ $contract->room->room_number }} - <span class="fw-normal">{{ $contract->tenant->name }}</span></h6>
                            <small class="text-muted"><i class="fas fa-phone me-1"></i> {{ $contract->tenant->phone }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning text-dark rounded-pill mb-1">{{ $contract->remaining_days }} ngày</span>
                            <br><small class="text-muted">{{ $contract->end_date->format('d/m/Y') }}</small>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <p class="text-muted lead">Không có hợp đồng nào sắp hết hạn trong 30 ngày tới. Mọi thứ đều ổn!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="fas fa-history text-secondary me-2"></i> Hoạt Động Gần Đây</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h6 class="text-primary mb-3">Phòng Mới Nhất</h6>
                        <ul class="list-group list-group-flush">
                            @if($recentRooms->count() > 0)
                            @foreach($recentRooms as $room)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="fas fa-door-closed me-2 text-muted"></i> Phòng {{ $room->room_number }}</span>
                                <small class="text-muted">{{ $room->created_at->diffForHumans() }}</small>
                            </li>
                            @endforeach
                            @else
                            <p class="text-muted">Chưa có dữ liệu</p>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-success mb-3">Khách Thuê Mới</h6>
                        <ul class="list-group list-group-flush">
                            @if($recentTenants->count() > 0)
                            @foreach($recentTenants as $tenant)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="fas fa-user-plus me-2 text-muted"></i> {{ $tenant->name }}</span>
                                <small class="text-muted">{{ $tenant->created_at->diffForHumans() }}</small>
                            </li>
                            @endforeach
                            @else
                            <p class="text-muted">Chưa có dữ liệu</p>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h6 class="text-warning mb-3">Hợp Đồng Mới</h6>
                        <ul class="list-group list-group-flush">
                            @if($recentContracts->count() > 0)
                            @foreach($recentContracts as $contract)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span><i class="fas fa-file-signature me-2 text-muted"></i> {{ $contract->room->room_number }} - {{ $contract->tenant->name }}</span>
                                <small class="text-muted">{{ $contract->created_at->diffForHumans() }}</small>
                            </li>
                            @endforeach
                            @else
                            <p class="text-muted">Chưa có dữ liệu</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0"><i class="fas fa-bolt text-info me-2"></i> Thao Tác Nhanh</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-lg w-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-plus-circle me-2"></i> Thêm Phòng Mới
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('tenants.create') }}" class="btn btn-success btn-lg w-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-plus me-2"></i> Thêm Khách Thuê
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('contracts.create') }}" class="btn btn-warning btn-lg w-100 d-flex align-items-center justify-content-center text-dark">
                            <i class="fas fa-file-contract me-2"></i> Tạo Hợp Đồng
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-info btn-lg w-100 d-flex align-items-center justify-content-center text-white" disabled>
                            <i class="fas fa-chart-bar me-2"></i> Xem Báo Cáo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #007bff, #0056b3) !important;
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, #28a745, #1e7e34) !important;
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #17a2b8, #117a8b) !important;
    }

    .bg-gradient-warning {
        background: linear-gradient(45deg, #ffc107, #d39e00) !important;
    }

    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .bg-primary-subtle {
        background-color: #d0e7ff !important;
    }

    .bg-success-subtle {
        background-color: #d1e7dd !important;
    }

    .bg-info-subtle {
        background-color: #cff4fc !important;
    }

    .bg-warning-subtle {
        background-color: #fff3cd !important;
    }
</style>
@endsection