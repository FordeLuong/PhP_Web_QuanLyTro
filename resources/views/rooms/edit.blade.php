@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Chỉnh Sửa Phòng {{ $room->room_number }}</h2>
    <div>
        <a href="{{ route('rooms.show', $room) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Xem Chi Tiết
        </a>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập Nhật Thông Tin Phòng</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('rooms.update', $room) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_number" class="form-label">Số Phòng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('room_number') is-invalid @enderror" 
                                   id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}" 
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
                                    <option value="{{ $i }}" {{ old('floor', $room->floor) == $i ? 'selected' : '' }}>
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
                                   id="area" name="area" value="{{ old('area', $room->area) }}" 
                                   placeholder="VD: 25.5">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Giá Thuê (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $room->price) }}" 
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
                            <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>
                                Còn Trống
                            </option>
                            <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>
                                Đã Thuê
                            </option>
                            <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>
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
                                  placeholder="Mô tả về phòng: nội thất, tiện ích, ghi chú...">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Cập Nhật Phòng
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
                        <th>Số Phòng:</th>
                        <td>{{ $room->room_number }}</td>
                    </tr>
                    <tr>
                        <th>Tầng:</th>
                        <td>Tầng {{ $room->floor }}</td>
                    </tr>
                    <tr>
                        <th>Diện Tích:</th>
                        <td>{{ $room->area }} m²</td>
                    </tr>
                    <tr>
                        <th>Giá Thuê:</th>
                        <td class="text-danger">{{ number_format($room->price) }} VNĐ</td>
                    </tr>
                    <tr>
                        <th>Trạng Thái:</th>
                        <td>
                            @if($room->status == 'available')
                                <span class="badge bg-success">Còn Trống</span>
                            @elseif($room->status == 'occupied')
                                <span class="badge bg-warning">Đã Thuê</span>
                            @else
                                <span class="badge bg-danger">Bảo Trì</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                <hr>
                
                <h6><i class="fas fa-history"></i> Lịch Sử</h6>
                <small class="text-muted">
                    <strong>Tạo:</strong> {{ $room->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Cập nhật:</strong> {{ $room->updated_at->format('d/m/Y H:i') }}
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
                    <li><i class="fas fa-check text-success"></i> Số phòng phải duy nhất</li>
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Cẩn thận khi thay đổi trạng thái</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection