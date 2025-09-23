@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-file-contract"></i> Quản Lý Hợp Đồng</h2>
    <a href="{{ route('contracts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tạo Hợp Đồng Mới
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh Sách Hợp Đồng</h5>
    </div>
    <div class="card-body">
        @if($contracts->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Phòng</th>
                        <th>Khách Thuê</th>
                        <th>Thời Gian</th>
                        <th>Tiền Thuê</th>
                        <th>Tiền Cọc</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contracts as $key => $contract)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong class="text-primary">{{ $contract->room->room_number }}</strong>
                            <br><small class="text-muted">Tầng {{ $contract->room->floor }}</small>
                        </td>
                        <td>
                            <strong>{{ $contract->tenant->name }}</strong>
                            <br><small class="text-muted">{{ $contract->tenant->phone }}</small>
                        </td>
                        <td>
                            <strong>{{ $contract->start_date->format('d/m/Y') }}</strong>
                            <br>đến <strong>{{ $contract->end_date->format('d/m/Y') }}</strong>
                            <br><small class="text-muted">{{ $contract->duration_in_months }} tháng</small>
                        </td>
                        <td class="text-danger">
                            <strong>{{ number_format($contract->monthly_rent) }} VNĐ</strong>
                            <br><small class="text-muted">/tháng</small>
                        </td>
                        <td class="text-warning">
                            <strong>{{ number_format($contract->deposit) }} VNĐ</strong>
                        </td>
                        <td>
                            @if($contract->status == 'active')
                                @if($contract->isActive())
                                    <span class="badge bg-success">Đang Hiệu Lực</span>
                                @else
                                    <span class="badge bg-warning">Sắp Hết Hạn</span>
                                @endif
                            @elseif($contract->status == 'expired')
                                <span class="badge bg-danger">Hết Hạn</span>
                            @else
                                <span class="badge bg-secondary">Đã Hủy</span>
                            @endif
                            <br>
                            @if($contract->remaining_days > 0)
                                <small class="text-muted">Còn {{ $contract->remaining_time }}</small>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('contracts.show', $contract) }}" class="btn btn-info btn-sm" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('contracts.edit', $contract) }}" class="btn btn-warning btn-sm" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('contracts.destroy', $contract) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa hợp đồng này?')">
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
            <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Chưa có hợp đồng nào</h5>
            <p class="text-muted">Hãy tạo hợp đồng thuê phòng đầu tiên</p>
            <a href="{{ route('contracts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tạo Hợp Đồng Mới
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
                    <i class="fas fa-file-contract fa-2x me-3"></i>
                    <div>
                        <h4>{{ $contracts->where('status', 'active')->count() }}</h4>
                        <small>Hợp Đồng Hiệu Lực</small>
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
                        <h4>{{ $contracts->where('status', 'expired')->count() }}</h4>
                        <small>Hết Hạn</small>
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
                        <h4>{{ number_format($contracts->where('status', 'active')->sum('monthly_rent')) }}</h4>
                        <small>Tổng Thu Nhập/Tháng</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-list fa-2x me-3"></i>
                    <div>
                        <h4>{{ $contracts->count() }}</h4>
                        <small>Tổng Hợp Đồng</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection