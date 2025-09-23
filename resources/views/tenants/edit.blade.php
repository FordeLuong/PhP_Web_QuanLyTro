@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-edit"></i> Chỉnh Sửa Khách Thuê</h2>
    <div>
        <a href="{{ route('tenants.show', $tenant) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Xem Chi Tiết
        </a>
        <a href="{{ route('tenants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập Nhật Thông Tin Khách Thuê</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tenants.update', $tenant) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $tenant->name) }}" 
                                   placeholder="VD: Nguyễn Văn A">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $tenant->phone) }}" 
                                   placeholder="VD: 0987654321">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $tenant->email) }}" 
                                   placeholder="VD: example@gmail.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="id_card" class="form-label">CMND/CCCD <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('id_card') is-invalid @enderror" 
                                   id="id_card" name="id_card" value="{{ old('id_card', $tenant->id_card) }}" 
                                   placeholder="VD: 123456789012">
                            @error('id_card')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa Chỉ <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" 
                                  placeholder="VD: 123 Đường ABC, Phường XYZ, Quận 1, TP.HCM">{{ old('address', $tenant->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('tenants.show', $tenant) }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Cập Nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Thông Tin Hiện Tại</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th>Họ Tên:</th>
                        <td>{{ $tenant->name }}</td>
                    </tr>
                    <tr>
                        <th>Điện Thoại:</th>
                        <td>{{ $tenant->phone }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $tenant->email ?: 'Chưa có' }}</td>
                    </tr>
                    <tr>
                        <th>CMND/CCCD:</th>
                        <td>{{ $tenant->id_card }}</td>
                    </tr>
                </table>
                
                <hr>
                
                <h6><i class="fas fa-history"></i> Lịch Sử</h6>
                <small class="text-muted">
                    <strong>Tạo:</strong> {{ $tenant->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Cập nhật:</strong> {{ $tenant->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Lưu Ý</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li><i class="fas fa-check text-success"></i> Thay đổi sẽ được lưu ngay lập tức</li>
                    <li><i class="fas fa-check text-success"></i> CMND/CCCD phải duy nhất</li>
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Cẩn thận khi thay đổi thông tin</li>
                </ul>
                
                <hr>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small">Trạng thái:</span>
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