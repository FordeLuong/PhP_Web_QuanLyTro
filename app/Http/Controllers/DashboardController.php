<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Tenant;
use App\Models\Contract;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng quan
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;
        
        $totalTenants = Tenant::count();
        $activeContracts = Contract::where('status', 'active')->count();
        
        // Doanh thu tháng này
        $monthlyRevenue = Contract::where('status', 'active')->sum('monthly_rent');
        $averageRent = $activeContracts > 0 ? round($monthlyRevenue / $activeContracts) : 0;
        
        // Hợp đồng sắp hết hạn (30 ngày tới)
        $expiringContracts = Contract::where('status', 'active')
            ->where('end_date', '<=', now()->addDays(30))
            ->with(['room', 'tenant'])
            ->get();
        
        // Dữ liệu gần đây
        $recentRooms = Room::latest()->take(5)->get();
        $recentTenants = Tenant::latest()->take(5)->get();
        $recentContracts = Contract::with(['room', 'tenant'])->latest()->take(5)->get();
        
        return view('dashboard', compact(
            'totalRooms',
            'availableRooms', 
            'occupancyRate',
            'totalTenants',
            'activeContracts',
            'monthlyRevenue',
            'averageRent',
            'expiringContracts',
            'recentRooms',
            'recentTenants',
            'recentContracts'
        ));
    }
}