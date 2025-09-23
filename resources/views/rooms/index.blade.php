@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-door-open"></i> Quản Lý Phòng Trọ</h2>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm Phòng Mới
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Danh Sách Phòng Trọ</h5>
    </div>
    <div class="card-body">
        @if($rooms->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>STT</th>
                        <th>Số Phòng</th>
                        <th>Tầng</th>
                        <th>Diện Tích</th>
                        <th>Giá Thuê</th>
                        <th>Trạng Thái</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $key => $room)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td><strong>{{ $room->room_number }}</strong></td>
                        <td>Tầng {{ $room->floor }}</td>
                        <td>{{ $room->area }} m²</td>
                        <td class="text-danger fw-bold">{{ number_format($room->price) }} VNĐ</td>
                        <td>
                            @if($room->status == 'available')
                                <span class="badge bg-success">Còn Trống</span>
                            @elseif($room->status == 'occupied')
                                <span class="badge bg-warning">Đã Thuê</span>
                            @else
                                <span class="badge bg-danger">Bảo Trì</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
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
            <i class="fas fa-home fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Chưa có phòng nào</h5>
            <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm Phòng Mới
            </a>
        </div>
        @endif
    </div>
</div>
@endsection