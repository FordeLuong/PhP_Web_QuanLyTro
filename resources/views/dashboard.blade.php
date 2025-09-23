@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="fas fa-tachometer-alt"></i> Dashboard - Hệ Thống Quản Lý Nhà Trọ</h2>
        <p class="text-muted">Tổng quan về tình hình kinh doanh nhà trọ</p>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-home fa-3x me-3"></i>
                    <div>
                        <h3>{{ $totalRooms }}</h3>
                        <p class="mb-0">Tổng Số Phòng</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-primary bg-opacity-75">
                <a href="{{ route('rooms.index') }}" class="text-white text-decoration-none">
                    <i class="fas fa-arrow-right"></i> Xem chi tiết
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-door-open fa-3x me-3"></i>
                    <div>
                        <h3>{{ $availableRooms }}</h3>
                        <p class="mb-0">Phòng Trống</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-success bg-opacity-75">
                <small>{{ $occupancyRate }}% đã được thuê</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users fa-3x me-3"></i>
                    <div>
                        <h3>{{ $totalTenants }}</h3>
                        <p class="mb-0">Khách Thuê</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-info bg-opacity-75">
                <a href="{{ route('tenants.index') }}" class="text-white text-decoration-none">
                    <i class="fas fa-arrow-right"></i> Xem chi tiết
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-file-contract fa-3x me-3"></i>
                    <div>
                        <h3>{{ $activeContracts }}</h3>
                        <p class="mb-0">Hợp Đồng Hiệu Lực</p>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-warning bg-opacity-75">
                <a href="{{ route('contracts.index') }}" class="text-white text-decoration-none">
                    <i class="fas fa-arrow-right"></i> Xem chi tiết
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Doanh thu và hợp đồng sắp hết hạn -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-money-bill text-success"></i> Doanh Thu Tháng Này</h5>
            </div>
            <div class="card-body">
                <h2 class="text-success">{{ number_format($monthlyRevenue) }} VNĐ</h2>
                <p class="text-muted mb-3">Tổng thu nhập từ {{ $activeContracts }} hợp đồng</p>
                
                <div class="d-flex justify-content-between">
                    <span>Thu nhập trung bình/phòng:</span>
                    <strong>{{ number_format($averageRent) }} VNĐ</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tỷ lệ lấp đầy:</span>
                    <strong>{{ $occupancyRate }}%</strong>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-exclamation-triangle text-warning"></i> Hợp Đồng Sắp Hết Hạn</h5>
            </div>
            <div class="card-body">
                @if($expiringContracts->count() > 0)
                    @foreach($expiringContracts as $contract)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>Phòng {{ $contract->room->room_number }}</strong> - {{ $contract->tenant->name }}
                            <br><small class="text-muted">{{ $contract->tenant->phone }}</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning">{{ $contract->remaining_days }} ngày</span>
                            <br><small class="text-muted">{{ $contract->end_date->format('d/m/Y') }}</small>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <p class="text-muted">Không có hợp đồng nào sắp hết hạn trong 30 ngày tới</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Hoạt động gần đây -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-history"></i> Hoạt Động Gần Đây</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h6>Phòng Mới Nhất</h6>
                        @if($recentRooms->count() > 0)
                            @foreach($recentRooms as $room)
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phòng {{ $room->room_number }}</span>
                                <small class="text-muted">{{ $room->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">Chưa có dữ liệu</p>
                        @endif
                    </div>
                    
                    <div class="col-md-4">
                        <h6>Khách Thuê Mới</h6>
                        @if($recentTenants->count() > 0)
                            @foreach($recentTenants as $tenant)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $tenant->name }}</span>
                                <small class="text-muted">{{ $tenant->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">Chưa có dữ liệu</p>
                        @endif
                    </div>
                    
                    <div class="col-md-4">
                        <h6>Hợp Đồng Mới</h6>
                        @if($recentContracts->count() > 0)
                            @foreach($recentContracts as $contract)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $contract->room->room_number }} - {{ $contract->tenant->name }}</span>
                                <small class="text-muted">{{ $contract->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">Chưa có dữ liệu</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-bolt"></i> Thao Tác Nhanh</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('rooms.create') }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="fas fa-plus"></i> Thêm Phòng Mới
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('tenants.create') }}" class="btn btn-outline-success w-100 mb-2">
                            <i class="fas fa-user-plus"></i> Thêm Khách Thuê
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('contracts.create') }}" class="btn btn-outline-warning w-100 mb-2">
                            <i class="fas fa-file-contract"></i> Tạo Hợp Đồng
                        </a>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-outline-info w-100 mb-2" disabled>
                            <i class="fas fa-chart-bar"></i> Xem Báo Cáo
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection