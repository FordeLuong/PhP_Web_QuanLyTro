@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-money-bill"></i> Quản Lý Thanh Toán</h2>
    <a href="{{ route('payments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Thanh Toán Mới
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh Sách Thanh Toán</h5>
    </div>
    <div class="card-body">
        @if($payments->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Phòng</th>
                        <th>Khách Thuê</th>
                        <th>Ngày Thanh Toán</th>
                        <th>Loại</th>
                        <th>Số Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Hạn Thanh Toán</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $key => $payment)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong class="text-primary">{{ $payment->contract->room->room_number }}</strong>
                            <br><small class="text-muted">Tầng {{ $payment->contract->room->floor }}</small>
                        </td>
                        <td>
                            <strong>{{ $payment->contract->tenant->name }}</strong>
                            <br><small class="text-muted">{{ $payment->contract->tenant->phone }}</small>
                        </td>
                        <td>
                            <strong>{{ $payment->payment_date->format('d/m/Y') }}</strong>
                            <br><small class="text-muted">{{ $payment->payment_date->diffForHumans() }}</small>
                        </td>
                        <td>
                            <i class="fas {{ $payment->type_icon }} me-1"></i>
                            <span class="badge bg-info">{{ $payment->type_name }}</span>
                        </td>
                        <td>
                            <strong class="text-danger">{{ number_format($payment->amount) }} VNĐ</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ $payment->status_class }}">
                                {{ $payment->status_name }}
                            </span>
                            @if($payment->isOverdue())
                                <br><small class="text-danger">Quá hạn {{ $payment->overdue_days }} ngày</small>
                            @endif
                        </td>
                        <td>
                            @if($payment->due_date)
                                <strong>{{ $payment->due_date->format('d/m/Y') }}</strong>
                                @if($payment->isOverdue())
                                    <br><small class="text-danger">Quá hạn</small>
                                @else
                                    <br><small class="text-muted">Còn {{ $payment->due_date->diffInDays(now()) }} ngày</small>
                                @endif
                            @else
                                <span class="text-muted">Không có</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-info btn-sm" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning btn-sm" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa thanh toán này?')">
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
            <i class="fas fa-money-bill fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Chưa có thanh toán nào</h5>
            <p class="text-muted">Hãy thêm thanh toán đầu tiên</p>
            <a href="{{ route('payments.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Thanh Toán Mới
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Thống kê nhanh -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h4>{{ $payments->where('status', 'paid')->count() }}</h4>
                        <small>Đã Thanh Toán</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-clock fa-2x me-3"></i>
                    <div>
                        <h4>{{ $payments->where('status', 'pending')->count() }}</h4>
                        <small>Chờ Thanh Toán</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h4>{{ $payments->where('status', 'overdue')->count() }}</h4>
                        <small>Quá Hạn</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-money-bill fa-2x me-3"></i>
                    <div>
                        <h4>{{ number_format($payments->where('status', 'paid')->sum('amount')) }}</h4>
                        <small>Tổng Đã Thu (VNĐ)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lọc nhanh -->
<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0"><i class="fas fa-filter"></i> Lọc Nhanh</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="d-grid">
                    <button class="btn btn-outline-success" onclick="filterPayments('paid')">
                        <i class="fas fa-check-circle"></i> Đã Thanh Toán
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid">
                    <button class="btn btn-outline-warning" onclick="filterPayments('pending')">
                        <i class="fas fa-clock"></i> Chờ Thanh Toán
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid">
                    <button class="btn btn-outline-danger" onclick="filterPayments('overdue')">
                        <i class="fas fa-exclamation-triangle"></i> Quá Hạn
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-grid">
                    <button class="btn btn-outline-primary" onclick="filterPayments('all')">
                        <i class="fas fa-list"></i> Tất Cả
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function filterPayments(status) {
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            const statusBadge = row.querySelector('.badge').textContent.toLowerCase();
            if (
                (status === 'paid' && statusBadge.includes('đã thanh toán')) ||
                (status === 'pending' && statusBadge.includes('chờ thanh toán')) ||
                (status === 'overdue' && statusBadge.includes('quá hạn'))
            ) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
}
</script>
@endsection