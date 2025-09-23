@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-users"></i> Quản Lý Khách Thuê</h2>
    <a href="{{ route('tenants.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus"></i> Thêm Khách Thuê Mới
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh Sách Khách Thuê</h5>
    </div>
    <div class="card-body">
        @if($tenants->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Họ Tên</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                        <th>CMND/CCCD</th>
                        <th>Địa Chỉ</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tenants as $key => $tenant)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong>{{ $tenant->name }}</strong>
                        </td>
                        <td>
                            <i class="fas fa-phone text-success"></i>
                            {{ $tenant->formatted_phone ?? $tenant->phone }}
                        </td>
                        <td>
                            @if($tenant->email)
                                <i class="fas fa-envelope text-info"></i>
                                {{ $tenant->email }}
                            @else
                                <span class="text-muted">Chưa có email</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ $tenant->masked_id_card ?? $tenant->id_card }}</span>
                        </td>
                        <td>{{ Str::limit($tenant->address, 30) }}</td>
                        <td>
                            @if(method_exists($tenant, 'hasActiveContract') && $tenant->hasActiveContract())
                                <span class="badge bg-success">
                                    <i class="fas fa-home"></i> Đang Thuê
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-user-clock"></i> Chưa Thuê
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('tenants.show', $tenant) }}" class="btn btn-info btn-sm" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('tenants.edit', $tenant) }}" class="btn btn-warning btn-sm" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tenants.destroy', $tenant) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa khách thuê này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Chưa có khách thuê nào</h5>
            <p class="text-muted">Hãy thêm thông tin khách thuê đầu tiên</p>
            <a href="{{ route('tenants.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> Thêm Khách Thuê Mới
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Thống kê nhanh -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users fa-2x me-3"></i>
                    <div>
                        <h4>{{ $tenants->count() }}</h4>
                        <small>Tổng Khách Thuê</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-home fa-2x me-3"></i>
                    <div>
                        <h4>0</h4>
                        <small>Đang Thuê Phòng</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-clock fa-2x me-3"></i>
                    <div>
                        <h4>{{ $tenants->count() }}</h4>
                        <small>Chưa Thuê Phòng</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-calendar fa-2x me-3"></i>
                    <div>
                        <h4>{{ $tenants->where('created_at', '>=', now()->startOfMonth())->count() }}</h4>
                        <small>Mới Tháng Này</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection