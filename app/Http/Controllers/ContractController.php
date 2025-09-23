<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with(['room', 'tenant'])->latest()->get();
        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $tenants = Tenant::all();
        return view('contracts.create', compact('rooms', 'tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:tenants,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'deposit' => 'required|numeric|min:0',
            'monthly_rent' => 'required|numeric|min:0',
            'terms' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        // Tạo hợp đồng
        $contract = Contract::create($request->all());

        // Cập nhật trạng thái phòng thành "đã thuê"
        $room = Room::find($request->room_id);
        $room->update(['status' => 'occupied']);

        return redirect()->route('contracts.index')
                        ->with('success', 'Hợp đồng được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load(['room', 'tenant', 'payments']);
        return view('contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $rooms = Room::where('status', 'available')
                     ->orWhere('id', $contract->room_id)
                     ->get();
        $tenants = Tenant::all();
        return view('contracts.edit', compact('contract', 'rooms', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:tenants,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deposit' => 'required|numeric|min:0',
            'monthly_rent' => 'required|numeric|min:0',
            'status' => 'required|in:active,expired,terminated',
            'terms' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $contract->update($request->all());

        // Cập nhật trạng thái phòng
        $room = Room::find($request->room_id);
        if ($request->status === 'active') {
            $room->update(['status' => 'occupied']);
        } else {
            $room->update(['status' => 'available']);
        }

        return redirect()->route('contracts.index')
                        ->with('success', 'Hợp đồng được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        // Cập nhật trạng thái phòng về available
        $contract->room->update(['status' => 'available']);
        
        $contract->delete();

        return redirect()->route('contracts.index')
                        ->with('success', 'Hợp đồng được xóa thành công.');
    }
}