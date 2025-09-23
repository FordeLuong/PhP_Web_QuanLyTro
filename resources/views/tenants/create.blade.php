@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-plus"></i> Thêm Khách Thuê Mới</h2>
    <a href="{{ route('tenants.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông Tin Khách Thuê</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('tenants.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="VD: Nguyễn Văn A">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" 
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
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="VD: example@gmail.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="id_card" class="form-label">CMND/CCCD <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('id_card') is-invalid @enderror" 
                                   id="id_card" name="id_card" value="{{ old('id_card') }}" 
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
                                  placeholder="VD: 123 Đường ABC, Phường XYZ, Quận 1, TP.HCM">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('tenants.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Thêm Khách Thuê
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Hướng Dẫn</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success"></i> Họ tên phải đầy đủ</li>
                    <li><i class="fas fa-check text-success"></i> Số điện thoại phải hợp lệ</li>
                    <li><i class="fas fa-check text-success"></i> CMND/CCCD phải duy nhất</li>
                    <li><i class="fas fa-check text-success"></i> Email không bắt buộc</li>
                    <li><i class="fas fa-check text-success"></i> Địa chỉ càng chi tiết càng tốt</li>
                </ul>
                
                <hr>
                
                <h6><i class="fas fa-shield-alt"></i> Bảo Mật</h6>
                <p class="small text-muted">
                    Thông tin cá nhân được bảo mật theo quy định pháp luật về bảo vệ dữ liệu cá nhân.
                </p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-lightbulb"></i> Gợi Ý</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li><strong>Số điện thoại:</strong> 10-11 số</li>
                    <li><strong>CMND:</strong> 9 hoặc 12 số</li>
                    <li><strong>CCCD:</strong> 12 số</li>
                    <li><strong>Email:</strong> Để liên lạc nhanh</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection