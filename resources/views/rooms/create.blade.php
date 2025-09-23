@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Thêm Phòng Mới</h2>
    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông Tin Phòng Trọ</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_number" class="form-label">Số Phòng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                                   id="room_number" name="room_number" value="{{ old('room_number') }}" 
                                   placeholder="VD: P101, A01, 201...">
                            @error('room_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="floor" class="form-label">Tầng <span class="text-danger">*</span></label>
                            <select class="form-control @error('floor') is-invalid @enderror" id="floor" name="floor">
                                <option value="">Chọn tầng</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('floor') == $i ? 'selected' : '' }}>
                                        Tầng {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Diện Tích (m²) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('area') is-invalid @enderror" 
                                   id="area" name="area" value="{{ old('area') }}" 
                                   placeholder="VD: 25.5">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Giá Thuê (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" 
                                   placeholder="VD: 3000000">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">Chọn trạng thái</option>
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>
                                Còn Trống
                            </option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>
                                Đã Thuê
                            </option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                Đang Bảo Trì
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Mô tả về phòng: nội thất, tiện ích, ghi chú...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu Phòng
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
                    <li><i class="fas fa-check text-success"></i> Số phòng phải duy nhất</li>
                    <li><i class="fas fa-check text-success"></i> Diện tích tính theo m²</li>
                    <li><i class="fas fa-check text-success"></i> Giá thuê tính theo tháng</li>
                    <li><i class="fas fa-check text-success"></i> Mô tả giúp khách hiểu rõ hơn</li>
                </ul>
                
                <hr>
                
                <h6><i class="fas fa-palette"></i> Trạng Thái Phòng</h6>
                <ul class="list-unstyled">
                    <li><span class="badge bg-success">Còn Trống</span> - Có thể cho thuê</li>
                    <li><span class="badge bg-warning">Đã Thuê</span> - Đang có người ở</li>
                    <li><span class="badge bg-danger">Bảo Trì</span> - Đang sửa chữa</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection