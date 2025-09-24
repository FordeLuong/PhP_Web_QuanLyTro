@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Chỉnh Sửa Hợp Đồng #{{ $contract->id }}</h2>
    <div>
        <a href="{{ route('contracts.show', $contract) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Xem Chi Tiết
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
                <h5 class="mb-0">Cập Nhật Thông Tin Hợp Đồng</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('contracts.update', $contract) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_id" class="form-label">Chọn Phòng <span class="text-danger">*</span></label>
                            <select class="form-control @error('room_id') is-invalid @enderror" id="room_id" name="room_id">
                                <option value="">-- Chọn phòng --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" 
                                            {{ old('room_id', $contract->room_id) == $room->id ? 'selected' : '' }}>
                                        Phòng {{ $room->room_number }} - Tầng {{ $room->floor }} 
                                        ({{ number_format($room->price) }} VNĐ/tháng)
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tenant_id" class="form-label">Chọn Khách Thuê <span class="text-danger">*</span></label>
                            <select class="form-control @error('tenant_id') is-invalid @enderror" id="tenant_id" name="tenant_id">
                                <option value="">-- Chọn khách thuê --</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" 
                                            {{ old('tenant_id', $contract->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }} - {{ $tenant->phone }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tenant_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Ngày Bắt Đầu <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" 
                                   value="{{ old('start_date', $contract->start_date->format('Y-m-d')) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Ngày Kết Thúc <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" 
                                   value="{{ old('end_date', $contract->end_date->format('Y-m-d')) }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="deposit" class="form-label">Tiền Cọc (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('deposit') is-invalid @enderror" 
                                   id="deposit" name="deposit" value="{{ old('deposit', $contract->deposit) }}" 
                                   placeholder="VD: 5000000">
                            @error('deposit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="monthly_rent" class="form-label">Tiền Thuê/Tháng (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('monthly_rent') is-invalid @enderror" 
                                   id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent', $contract->monthly_rent) }}" 
                                   placeholder="VD: 3000000">
                            @error('monthly_rent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="active" {{ old('status', $contract->status) == 'active' ? 'selected' : '' }}>Đang Hiệu Lực</option>
                            <option value="expired" {{ old('status', $contract->status) == 'expired' ? 'selected' : '' }}>Hết Hạn</option>
                            <option value="terminated" {{ old('status', $contract->status) == 'terminated' ? 'selected' : '' }}>Đã Chấm Dứt</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="terms" class="form-label">Điều Khoản Hợp Đồng</label>
                        <textarea class="form-control @error('terms') is-invalid @enderror" 
                                  id="terms" name="terms" rows="4" 
                                  placeholder="VD: Khách thuê phải trả tiền đúng hạn, giữ gìn vệ sinh phòng...">{{ old('terms', $contract->terms) }}</textarea>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi Chú</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="Ghi chú thêm về hợp đồng...">{{ old('notes', $contract->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('contracts.show', $contract) }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Cập Nhật Hợp Đồng
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
                        <th>Phòng:</th>
                        <td>{{ $contract->room->room_number }}</td>
                    </tr>
                    <tr>
                        <th>Khách Thuê:</th>
                        <td>{{ $contract->tenant->name }}</td>
                    </tr>
                    <tr>
                        <th>Thời Gian:</th>
                        <td>{{ $contract->duration_in_months }} tháng</td>
                    </tr>
                    <tr>
                        <th>Tiền Thuê:</th>
                        <td class="text-danger fw-bold">{{ number_format($contract->monthly_rent) }} VNĐ</td>
                    </tr>
                    <tr>
                        <th>Tiền Cọc:</th>
                        <td class="text-warning fw-bold">{{ number_format($contract->deposit) }} VNĐ</td>
                    </tr>
                    <tr>
                        <th>Trạng Thái:</th>
                        <td>
                            @if($contract->status == 'active')
                                <span class="badge bg-success">Đang Hiệu Lực</span>
                            @elseif($contract->status == 'expired')
                                <span class="badge bg-danger">Hết Hạn</span>
                            @else
                                <span class="badge bg-secondary">Đã Chấm Dứt</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                <hr>
                
                <h6><i class="fas fa-history"></i> Lịch Sử</h6>
                <small class="text-muted">
                    <strong>Tạo:</strong> {{ $contract->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Cập nhật:</strong> {{ $contract->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Lưu Ý</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> Thay đổi trạng thái sẽ ảnh hưởng đến trạng thái phòng</li>
                    <li><i class="fas fa-info-circle text-info"></i> Hợp đồng "Đã chấm dứt" sẽ giải phóng phòng</li>
                    <li><i class="fas fa-check text-success"></i> Tất cả thay đổi được lưu ngay lập tức</li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-clock"></i> Thời Gian</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Còn lại:</span>
                    <strong>{{ $contract->remaining_time }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tổng thời hạn:</span>
                    <strong>{{ $contract->duration_in_months }} tháng</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection