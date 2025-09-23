@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user"></i> Chi Tiết Khách Thuê</h2>
    <div>
        <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Sửa
        </a>
        <a href="{{ route('tenants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông Tin Cá Nhân</h5>
                @if(method_exists($tenant, 'hasActiveContract') && $tenant->hasActiveContract())
                    <span class="badge bg-success fs-6">
                        <i class="fas fa-home"></i> Đang Thuê Phòng
                    </span>
                @else
                    <span class="badge bg-secondary fs-6">
                        <i class="fas fa-user-clock"></i> Chưa Thuê Phòng
                    </span>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-user text-primary"></i> Họ Tên:</th>
                                <td><strong class="fs-5">{{ $tenant->name }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone text-success"></i> Điện Thoại:</th>
                                <td>
                                    <a href="tel:{{ $tenant->phone }}" class="text-decoration-none">
                                        {{ $tenant->formatted_phone ?? $tenant->phone }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-envelope text-info"></i> Email:</th>
                                <td>
                                    @if($tenant->email)
                                        <a href="mailto:{{ $tenant->email }}" class="text-decoration-none">
                                            {{ $tenant->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">Chưa có email</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-id-card text-warning"></i> CMND/CCCD:</th>
                                <td>
                                    <span class="badge bg-secondary fs-6">{{ $tenant->id_card }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar text-primary"></i> Tạo Lúc:</th>
                                <td>{{ $tenant->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-edit text-secondary"></i> Cập Nhật:</th>
                                <td>{{ $tenant->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-12">
                        <h6><i class="fas fa-map-marker-alt text-danger"></i> Địa Chỉ:</h6>
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-home text-muted me-2"></i>{{ $tenant->address }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Phần lịch sử thuê phòng -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-history"></i> Lịch Sử Thuê Phòng</h6>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Chưa có lịch sử thuê phòng</h6>
                    <p class="text-muted">Lịch sử hợp đồng sẽ hiển thị ở đây khi có dữ liệu</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Thao Tác Nhanh</h6>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Chỉnh Sửa Thông Tin
                </a>
                
                <button class="btn btn-success" disabled>
                    <i class="fas fa-home"></i> Tạo Hợp Đồng Thuê
                </button>
                
                <button class="btn btn-info" disabled>
                    <i class="fas fa-file-invoice"></i> Xem Hóa Đơn
                </button>
                
                <a href="tel:{{ $tenant->phone }}" class="btn btn-outline-success">
                    <i class="fas fa-phone"></i> Gọi Điện
                </a>
                
                @if($tenant->email)
                <a href="mailto:{{ $tenant->email }}" class="btn btn-outline-info">
                    <i class="fas fa-envelope"></i> Gửi Email
                </a>
                @endif
                
                <hr>
                
                <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" 
                      onsubmit="return confirm('Bạn có chắc muốn xóa khách thuê {{ $tenant->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Xóa Khách Thuê
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Thông Tin Thêm</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>ID:</strong> {{ $tenant->id }}<br>
                    <strong>Tạo:</strong> {{ $tenant->created_at->diffForHumans() }}<br>
                    <strong>Cập nhật:</strong> {{ $tenant->updated_at->diffForHumans() }}
                </small>
                
                <hr>
                
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Trạng thái:</span>
                    @if(method_exists($tenant, 'hasActiveContract') && $tenant->hasActiveContract())
                        <span class="badge bg-success">Đang thuê</span>
                    @else
                        <span class="badge bg-secondary">Chưa thuê</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection