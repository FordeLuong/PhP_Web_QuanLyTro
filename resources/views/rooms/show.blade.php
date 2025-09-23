@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-eye"></i> Chi Tiết Phòng {{ $room->room_number }}</h2>
    <div>
        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Sửa
        </a>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay Lại
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông Tin Phòng</h5>
                @if($room->status == 'available')
                    <span class="badge bg-success fs-6">Còn Trống</span>
                @elseif($room->status == 'occupied')
                    <span class="badge bg-warning fs-6">Đã Thuê</span>
                @else
                    <span class="badge bg-danger fs-6">Bảo Trì</span>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-door-open text-primary"></i> Số Phòng:</th>
                                <td><strong class="fs-5">{{ $room->room_number }}</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-building text-info"></i> Tầng:</th>
                                <td>Tầng {{ $room->floor }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-expand text-success"></i> Diện Tích:</th>
                                <td>{{ $room->area }} m²</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-money-bill text-danger"></i> Giá Thuê:</th>
                                <td><strong class="text-danger fs-5">{{ number_format($room->price) }} VNĐ</strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar text-warning"></i> Tạo Lúc:</th>
                                <td>{{ $room->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-edit text-secondary"></i> Cập Nhật:</th>
                                <td>{{ $room->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($room->description)
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h6><i class="fas fa-file-alt"></i> Mô Tả:</h6>
                        <div class="bg-light p-3 rounded">
                            {{ $room->description }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Phần này sẽ hiển thị lịch sử hợp đồng sau -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-history"></i> Lịch Sử Thuê Phòng</h6>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Chức năng lịch sử hợp đồng sẽ được cập nhật sau</p>
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
                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Chỉnh Sửa Phòng
                </a>
                
                @if($room->status == 'available')
                    <button class="btn btn-success" disabled>
                        <i class="fas fa-user-plus"></i> Tạo Hợp Đồng Thuê
                    </button>
                @endif
                
                <button class="btn btn-info" disabled>
                    <i class="fas fa-chart-line"></i> Xem Báo Cáo
                </button>
                
                <hr>
                
                <form action="{{ route('rooms.destroy', $room) }}" method="POST" 
                      onsubmit="return confirm('Bạn có chắc muốn xóa phòng {{ $room->room_number }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="fas fa-trash"></i> Xóa Phòng
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Thông Tin Thêm</h6>
            </div>
            <div class="card-body">
                <small class="text-muted">
                    <strong>ID:</strong> {{ $room->id }}<br>
                    <strong>Tạo:</strong> {{ $room->created_at->diffForHumans() }}<br>
                    <strong>Cập nhật:</strong> {{ $room->updated_at->diffForHumans() }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection