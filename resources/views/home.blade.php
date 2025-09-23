@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-tachometer-alt"></i> Dashboard - Hệ thống quản lý nhà trọ
            </div>
            <div class="card-body">
                <h5>Chào mừng, {{ Auth::user()->name }}!</h5>
                <p>Chào mừng đến với hệ thống quản lý nhà trọ.</p>
                
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-door-open"></i><br>
                            Quản lý phòng trọ
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('tenants.index') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-users"></i><br>
                            Quản lý khách thuê
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection