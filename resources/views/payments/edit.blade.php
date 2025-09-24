@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-edit"></i> Chỉnh Sửa Thanh Toán #{{ $payment->id }}</h2>
    <div>
        <a href="{{ route('payments.show', $payment) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Xem Chi Tiết
        </a>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cập Nhật Thông Tin Thanh Toán</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('payments.update', $payment) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="contract_id" class="form-label">Chọn Hợp Đồng <span class="text-danger">*</span></label>
                            <select class="form-control @error('contract_id') is-invalid @enderror" id="contract_id" name="contract_id">
                                <option value="">-- Chọn hợp đồng --</option>
                                @foreach($contracts as $contract)
                                    <option value="{{ $contract->id }}" 
                                            {{ old('contract_id', $payment->contract_id) == $contract->id ? 'selected' : '' }}
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
                                <option value="rent" {{ old('type', $payment->type) == 'rent' ? 'selected' : '' }}>Tiền Thuê Phòng</option>
                                <option value="deposit" {{ old('type', $payment->type) == 'deposit' ? 'selected' : '' }}>Tiền Cọc</option>
                                <option value="electricity" {{ old('type', $payment->type) == 'electricity' ? 'selected' : '' }}>Tiền Điện</option>
                                <option value="water" {{ old('type', $payment->type) == 'water' ? 'selected' : '' }}>Tiền Nước</option>
                                <option value="other" {{ old('type', $payment->type) == 'other' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Số Tiền (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" 
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
                                   id="payment_date" name="payment_date" 
                                   value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}">
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Hạn Thanh Toán</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                   id="due_date" name="due_date" 
                                   value="{{ old('due_date', $payment->due_date ? $payment->due_date->format('Y-m-d') : '') }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng Thái <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="paid" {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>Đã Thanh Toán</option>
                            <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Chờ Thanh Toán</option>
                            <option value="overdue" {{ old('status', $payment->status) == 'overdue' ? 'selected' : '' }}>Quá Hạn</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô Tả</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="VD: Thanh toán tiền thuê tháng 9/2025...">{{ old('description', $payment->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-secondary me-md-2">
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
                        <th>Phòng:</th>
                        <td>{{ $payment->contract->room->room_number }}</td>
                    </tr>
                    <tr>
                        <th>Khách Thuê:</th>
                        <td>{{ $payment->contract->tenant->name }}</td>
                    </tr>
                    <tr>
                        <th>Loại:</th>
                        <td><span class="badge bg-info">{{ $payment->type_name }}</span></td>
                    </tr>
                    <tr>
                        <th>Số Tiền:</th>
                        <td class="text-danger fw-bold">{{ number_format($payment->amount) }} VNĐ</td>
                    </tr>
                    <tr>
                        <th>Trạng Thái:</th>
                        <td>
                            <span class="badge bg-{{ $payment->status_class }}">
                                {{ $payment->status_name }}
                            </span>
                        </td>
                    </tr>
                </table>
                
                <hr>
                
                <h6><i class="fas fa-history"></i> Lịch Sử</h6>
                <small class="text-muted">
                    <strong>Tạo:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Cập nhật:</strong> {{ $payment->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-calculator"></i> Tính Nhanh</h6>
            </div>
            <div class="card-body" id="contract-info">
                <div class="d-flex justify-content-between mb-2">
                    <span>Tiền thuê/tháng:</span>
                    <strong id="monthly-rent">{{ number_format($payment->contract->monthly_rent) }} VNĐ</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Tiền cọc:</span>
                    <strong id="deposit-amount">{{ number_format($payment->contract->deposit) }} VNĐ</strong>
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
        
        @if($payment->isOverdue())
        <div class="card mt-3 border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Cảnh Báo</h6>
            </div>
            <div class="card-body">
                <p class="text-danger mb-0">
                    Thanh toán đã quá hạn {{ $payment->overdue_days }} ngày!
                </p>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Khi chọn hợp đồng
document.getElementById('contract_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    
    if (selectedOption.value) {
        const rent = selectedOption.dataset.rent;
        const deposit = selectedOption.dataset.deposit;
        
        document.getElementById('monthly-rent').textContent = new Intl.NumberFormat('vi-VN').format(rent) + ' VNĐ';
        document.getElementById('deposit-amount').textContent = new Intl.NumberFormat('vi-VN').format(deposit) + ' VNĐ';
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

// Auto update contract info on page load
document.addEventListener('DOMContentLoaded', function() {
    const contractSelect = document.getElementById('contract_id');
    const selectedOption = contractSelect.options[contractSelect.selectedIndex];
    
    if (selectedOption.value) {
        // Contract info already populated from PHP
    }
});
</script>
@endsection