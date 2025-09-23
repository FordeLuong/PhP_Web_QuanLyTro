@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-contract"></i> Chi Tiết Hợp Đồng #{{ $contract->id }}</h2>
    <div>
        <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông Tin Hợp Đồng</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Thông Tin Phòng</h6>
                        <p><strong>Phòng:</strong> {{ $contract->room->room_number }}</p>
                        <p><strong>Tầng:</strong> {{ $contract->room->floor }}</p>
                        <p><strong>Diện tích:</strong> {{ $contract->room->area }} m²</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Thông Tin Khách Thuê</h6>
                        <p><strong>Tên:</strong> {{ $contract->tenant->name }}</p>
                        <p><strong>SĐT:</strong> {{ $contract->tenant->phone }}</p>
                        <p><strong>CMND:</strong> {{ $contract->tenant->id_card }}</p>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Thời Gian</h6>
                        <p><strong>Bắt đầu:</strong> {{ $contract->start_date->format('d/m/Y') }}</p>
                        <p><strong>Kết thúc:</strong> {{ $contract->end_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Tài Chính</h6>
                        <p><strong>Tiền thuê:</strong> {{ number_format($contract->monthly_rent) }} VNĐ</p>
                        <p><strong>Tiền cọc:</strong> {{ number_format($contract->deposit) }} VNĐ</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Thao Tác</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning w-100 mb-2">
                    Chỉnh Sửa
                </a>
                <a href="tel:{{ $contract->tenant->phone }}" class="btn btn-success w-100">
                    Gọi Khách Thuê
                </a>
            </div>
        </div>
    </div>
</div>
@endsection