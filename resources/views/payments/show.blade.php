@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-money-bill"></i> Chi Tiết Thanh Toán #{{ $payment->id }}</h2>
    <div>
        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Chỉnh Sửa
        </a>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông Tin Thanh Toán</h5>
                <span class="badge bg-{{ $payment->status_class }} fs-6">
                    {{ $payment->status_name }}
                </span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-home text-primary"></i> Thông Tin Hợp Đồng</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Phòng:</th>
                                <td><strong class="text-primary">{{ $payment->contract->room->room_number }}</strong></td>
                            </tr>
                            <tr>
                                <th>Tầng:</th>
                                <td>Tầng {{ $payment->contract->room->floor }}</td>
                            </tr>
                            <tr>
                                <th>Khách Thuê:</th>
                                <td><strong>{{ $payment->contract->tenant->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Điện Thoại:</th>
                                <td>
                                    <a href="tel:{{ $payment->contract->tenant->phone }}" class="text-decoration-none">
                                        {{ $payment->contract->tenant->phone }}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="col-md-6">
                        <h6><i class="fas {{ $payment->type_icon }} text-success"></i> Chi Tiết Thanh Toán</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Loại:</th>
                                <td>
                                    <span class="badge bg-info">{{ $payment->type_name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Số Tiền:</th>
                                <td><strong class="text-danger fs-5">{{ number_format($payment->amount) }} VNĐ</strong></td>
                            </tr>
                            <tr>
                                <th>Ngày Thanh Toán:</th>
                                <td><strong>{{ $payment->payment_date->format('d/m/Y') }}</strong></td>
                            </tr>
                            <tr>
                                <th>Hạn Thanh Toán:</th>
                                <td>
                                    @if($payment->due_date)
                                        <strong>{{ $payment->due_date->format('d/m/Y') }}</strong>
                                        @if($payment->isOverdue())
                                            <br><small class="text-danger">Quá hạn {{ $payment->overdue_days }} ngày</small>
                                        @else
                                            <br><small class="text-success">Còn {{ $payment->due_date->diffInDays(now()) }} ngày</small>
                                        @endif
                                    @else
                                        <span class="text-muted">Không có hạn</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($payment->description)
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6><i class="fas fa-file-alt text-dark"></i> Mô Tả</h6>
                        <div class="bg-light p-3 rounded">
                            {{ $payment->description }}
                        </div>
                    </div>
                </div>
                @endif
                
                <hr>
                
                <div class="row">
                    <div class="col-12">
                        <h6><i class="fas fa-info-circle text-info"></i> Thông Tin Hệ Thống</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>ID Thanh Toán:</strong> #{{ $payment->id }}<br>
                                    <strong>Tạo Lúc:</strong> {{ $payment->created_at->format('d/m/Y H:i') }}<br>
                                    <strong>Cập Nhật:</strong> {{ $payment->updated_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <strong>Hợp Đồng ID:</strong> #{{ $payment->contract->id }}<br>
                                    <strong>Thời Gian Tạo:</strong> {{ $payment->created_at->diffForHumans() }}<br>
                                    <strong>Thời Gian Sửa:</strong> {{ $payment->updated_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-tools"></i> Thao Tác</h6>
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Chỉnh Sửa Thanh Toán
                </a>
                
                @if($payment->status === 'pending')
                <form action="{{ route('payments.update', $payment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="contract_id" value="{{ $payment->contract_id }}">
                    <input type="hidden" name="payment_date" value="{{ $payment->payment_date->format('Y-m-d') }}">
                    <input type="hidden" name="amount" value="{{ $payment->amount }}">
                    <input type="hidden" name="type" value="{{ $payment->type }}">
                    <input type="hidden" name="status" value="paid">
                    <input type="hidden" name="description" value="{{ $payment->description }}">
                    @if($payment->due_date)
                    <input type="hidden" name="due_date" value="{{ $payment->due_date->format('Y-m-d') }}">
                    @endif
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-check"></i> Đánh Dấu Đã Thanh Toán
                    </button>
                </form>
                @endif
                
                <button class="btn btn-info" disabled>
                    <i class="fas fa-print"></i> In Biên Lai
                </button>
                
                <a href="tel:{{ $payment->contract->tenant->phone }}" class="btn btn-outline-success">
                    <i class="fas fa-phone"></i> Gọi Khách Thuê
                </a>
                
                <a href="{{ route('contracts.show', $payment->contract) }}" class="btn btn-outline-primary">
                    <i class="fas fa-file-contract"></i> Xem Hợp Đồng
                </a>
                
                <hr>
                
                <form action="{{ route('payments.destroy', $payment) }}" method="POST" 
                      onsubmit="return confirm('Bạn có chắc muốn xóa thanh toán này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Xóa Thanh Toán
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Thông tin liên quan -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-link"></i> Liên Quan</h6>
            </div>
            <div class="card-body">
                <h6 class="text-primary">Hợp Đồng #{{ $payment->contract->id }}</h6>
                <ul class="list-unstyled small">
                    <li><strong>Thời hạn:</strong> {{ $payment->contract->start_date->format('d/m/Y') }} - {{ $payment->contract->end_date->format('d/m/Y') }}</li>
                    <li><strong>Tiền thuê:</strong> {{ number_format($payment->contract->monthly_rent) }} VNĐ</li>
                    <li><strong>Tiền cọc:</strong> {{ number_format($payment->contract->deposit) }} VNĐ</li>
                    <li><strong>Trạng thái:</strong> 
                        @if($payment->contract->status == 'active')
                            <span class="badge bg-success">Đang hiệu lực</span>
                        @else
                            <span class="badge bg-secondary">{{ $payment->contract->status }}</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Cảnh báo -->
        @if($payment->isOverdue())
        <div class="card mt-3 border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0"><i class="fas fa-exclamation-triangle"></i> Cảnh Báo</h6>
            </div>
            <div class="card-body">
                <p class="text-danger mb-2">
                    <strong>Thanh toán đã quá hạn {{ $payment->overdue_days }} ngày!</strong>
                </p>
                <small class="text-muted">
                    Hạn thanh toán: {{ $payment->due_date->format('d/m/Y') }}
                </small>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection