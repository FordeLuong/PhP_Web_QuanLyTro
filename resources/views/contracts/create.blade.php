@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-contract"></i> Tạo Hợp Đồng Thuê Phòng</h2>
    <a href="{{ route('contracts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông Tin Hợp Đồng</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('contracts.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_id" class="form-label">Chọn Phòng <span class="text-danger">*</span></label>
                            <select class="form-control @error('room_id') is-invalid @enderror" id="room_id" name="room_id">
                                <option value="">-- Chọn phòng trống --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
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
                                    <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
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
                                   id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Ngày Kết Thúc <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="deposit" class="form-label">Tiền Cọc (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('deposit') is-invalid @enderror" 
                                   id="deposit" name="deposit" value="{{ old('deposit') }}" 
                                   placeholder="VD: 5000000">
                            @error('deposit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="monthly_rent" class="form-label">Tiền Thuê/Tháng (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('monthly_rent') is-invalid @enderror" 
                                   id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent') }}" 
                                   placeholder="VD: 3000000">
                            @error('monthly_rent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="terms" class="form-label">Điều Khoản Hợp Đồng</label>
                        <textarea class="form-control @error('terms') is-invalid @enderror" 
                                  id="terms" name="terms" rows="4" 
                                  placeholder="VD: Khách thuê phải trả tiền đúng hạn, giữ gìn vệ sinh phòng...">{{ old('terms') }}</textarea>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi Chú</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3" 
                                  placeholder="Ghi chú thêm về hợp đồng...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('contracts.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-file-signature"></i> Tạo Hợp Đồng
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
                    <li><i class="fas fa-check text-success"></i> Chỉ hiển thị phòng trống</li>
                    <li><i class="fas fa-check text-success"></i> Ngày kết thúc phải sau ngày bắt đầu</li>
                    <li><i class="fas fa-check text-success"></i> Tiền cọc thường bằng 1 tháng tiền thuê</li>
                    <li><i class="fas fa-check text-success"></i> Điều khoản giúp bảo vệ quyền lợi</li>
                </ul>
                
                <hr>
                
                <h6><i class="fas fa-lightbulb"></i> Thông Tin</h6>
                <div class="small text-muted">
                    <strong>Phòng trống:</strong> {{ $rooms->count() }} phòng<br>
                    <strong>Khách thuê:</strong> {{ $tenants->count() }} người<br>
                    <strong>Trạng thái:</strong> Hợp đồng sẽ có hiệu lực ngay sau khi tạo
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-calculator"></i> Tính Nhanh</h6>
            </div>
            <div class="card-body">
                <div class="small">
                    <div class="d-flex justify-content-between">
                        <span>Hợp đồng 6 tháng:</span>
                        <span class="text-muted">~180 ngày</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Hợp đồng 1 năm:</span>
                        <span class="text-muted">~365 ngày</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Tiền cọc thường:</span>
                        <span class="text-muted">1 tháng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto calculate end date khi chọn start date
document.getElementById('start_date').addEventListener('change', function() {
    let startDate = new Date(this.value);
    let endDate = new Date(startDate);
    endDate.setMonth(endDate.getMonth() + 12); // Mặc định 1 năm
    
    document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
});

// Auto fill monthly rent khi chọn room
document.getElementById('room_id').addEventListener('change', function() {
    let selectedOption = this.options[this.selectedIndex];
    if (selectedOption.text) {
        let priceMatch = selectedOption.text.match(/\(([0-9,]+)/);
        if (priceMatch) {
            let price = priceMatch[1].replace(/,/g, '');
            document.getElementById('monthly_rent').value = price;
            document.getElementById('deposit').value = price * 1; // Cọc = 1 tháng
        }
    }
});
</script>
@endsection