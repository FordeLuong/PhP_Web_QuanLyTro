<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = Room::all();
        $tenants = \App\Models\Tenant::all();
        return view('rooms.index', compact('rooms', 'tenants')); 
    }


    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'floor' => 'required|integer',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string'
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')
            ->with('success', 'Phòng được tạo thành công.');
    }


    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }


    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id,
            'floor' => 'required|integer',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required|in:available,occupied,maintenance',
            'description' => 'nullable|string'
        ]);

        $room->update($request->all());

        return redirect()->route('rooms.index')
            ->with('success', 'Phòng được cập nhật thành công.');
    }


    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Phòng được xóa thành công.');
    }
}
