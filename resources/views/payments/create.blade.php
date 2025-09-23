@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-plus"></i> Thêm Thanh Toán Mới</h2>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay Lại
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Thông Tin Thanh Toán</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="contract_id" class="form-label">Chọn Hợp Đồng <span class="text-danger">*</span></label>
                            <select class="form-control @error('contract_id') is-invalid @enderror" id="contract_id" name="contract_id">
                                <option value="">-- Chọn hợp đồng --</option>
                                @foreach($contracts as $contract)
                                    <option value="{{ $contract->id }}" {{ old('contract_id') == $contract->id ? 'selected' : '' }}
                                            data-rent="{{ $contract->monthly_rent }}" data-deposit="{{ $contract->deposit }}">
                                        Phòng {{ $contract->room->room_number }} - {{ $contract->tenant->name }} 
                                        ({{ number_format($contract->monthly_rent) }} VNĐ/tháng)
                                    </option>
                                @endforeach
                            </select>
                            @error('contract_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Loại Thanh Toán <span class="text-danger">*</span></label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="">-- Chọn loại --</option>
                                <option value="rent" {{ old('type') == 'rent' ? 'selected' : '' }}>Tiền Thuê Phòng</option>
                                <option value="deposit" {{ old('type') == 'deposit' ? 'selected' : '' }}>Tiền Cọc</option>
                                <option value="electricity" {{ old('type') == 'electricity' ? 'selected' : '' }}>Tiền Điện</option>
                                <option value="water" {{ old('type') == 'water' ? 'selected' : '' }}>Tiền Nước</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Số Tiền (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount') }}" 
                                   placeholder="VD: 3000000">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="payment_date" class="form-label">Ngày Thanh Toán <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                   id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}">
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Hạn Thanh Toán</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                   id="due_date" name="due_date" value="{{ old('due_date') }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Đã Thanh Toán</option>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Chờ Thanh Toán</option>
                            <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Quá Hạn</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="VD: Thanh toán tiền thuê tháng 9/2025...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Lưu Thanh Toán
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
                    <li><i class="fas fa-check text-success"></i> Chọn hợp đồng trước</li>
                    <li><i class="fas fa-check text-success"></i> Hệ thống sẽ tự động điền số tiền</li>
                    <li><i class="fas fa-check text-success"></i> Hạn thanh toán không bắt buộc</li>
                    <li><i class="fas fa-check text-success"></i> Có thể ghi nhận thanh toán trước</li>
                </ul>
                
                <hr>
                
                <h6><i class="fas fa-palette"></i> Loại Thanh Toán</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-home text-primary"></i> <strong>Tiền thuê:</strong> Hàng tháng</li>
                    <li><i class="fas fa-piggy-bank text-warning"></i> <strong>Tiền cọc:</strong> Lúc ký hợp đồng</li>
                    <li><i class="fas fa-bolt text-danger"></i> <strong>Tiền điện:</strong> Theo số đồng hồ</li>
                    <li><i class="fas fa-tint text-info"></i> <strong>Tiền nước:</strong> Theo số khối</li>
                    <li><i class="fas fa-money-bill text-success"></i> <strong>Khác:</strong> Phí dịch vụ, sửa chữa...</li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-calculator"></i> Tính Nhanh</h6>
            </div>
            <div class="card-body" id="contract-info" style="display: none;">
                <div class="d-flex justify-content-between mb-2">
                    <span>Tiền thuê/tháng:</span>
                    <strong id="monthly-rent">0 VNĐ</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tiền cọc:</span>
                    <strong id="deposit-amount">0 VNĐ</strong>
                </div>
                <hr>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="fillAmount('rent')">
                        Điền tiền thuê
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm" onclick="fillAmount('deposit')">
                        Điền tiền cọc
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Khi chọn hợp đồng
document.getElementById('contract_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const contractInfo = document.getElementById('contract-info');
    
    if (selectedOption.value) {
        const rent = selectedOption.dataset.rent;
        const deposit = selectedOption.dataset.deposit;
        
        document.getElementById('monthly-rent').textContent = new Intl.NumberFormat('vi-VN').format(rent) + ' VNĐ';
        document.getElementById('deposit-amount').textContent = new Intl.NumberFormat('vi-VN').format(deposit) + ' VNĐ';
        
        contractInfo.style.display = 'block';
    } else {
        contractInfo.style.display = 'none';
    }
});

// Khi chọn loại thanh toán
document.getElementById('type').addEventListener('change', function() {
    const contractSelect = document.getElementById('contract_id');
    const selectedContract = contractSelect.options[contractSelect.selectedIndex];
    
    if (selectedContract.value && this.value) {
        let amount = 0;
        
        if (this.value === 'rent') {
            amount = selectedContract.dataset.rent;
        } else if (this.value === 'deposit') {
            amount = selectedContract.dataset.deposit;
        }
        
        if (amount > 0) {
            document.getElementById('amount').value = amount;
        }
    }
});

// Fill amount functions
function fillAmount(type) {
    const contractSelect = document.getElementById('contract_id');
    const selectedContract = contractSelect.options[contractSelect.selectedIndex];
    
    if (selectedContract.value) {
        let amount = 0;
        
        if (type === 'rent') {
            amount = selectedContract.dataset.rent;
            document.getElementById('type').value = 'rent';
        } else if (type === 'deposit') {
            amount = selectedContract.dataset.deposit;
            document.getElementById('type').value = 'deposit';
        }
        
        document.getElementById('amount').value = amount;
    }
}

// Auto fill due date (30 ngày sau payment date)
document.getElementById('payment_date').addEventListener('change', function() {
    if (this.value) {
        const paymentDate = new Date(this.value);
        const dueDate = new Date(paymentDate);
        dueDate.setMonth(dueDate.getMonth() + 1); // Thêm 1 tháng
        
        document.getElementById('due_date').value = dueDate.toISOString().split('T')[0];
    }
});
</script>
@endsection