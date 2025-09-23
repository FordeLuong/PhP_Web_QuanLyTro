<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'floor', 
        'area',
        'price',
        'status',
        'description'
    ];

    protected $casts = [
        'area' => 'decimal:2',
        'price' => 'decimal:2'
    ];

    // Relationship với Contract
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    // Lấy hợp đồng hiện tại
    public function currentContract()
    {
        return $this->hasOne(Contract::class)
                   ->where('status', 'active')
                   ->latest();
    }

    // Check xem phòng có đang được thuê không
    public function isOccupied()
    {
        return $this->status === 'occupied';
    }

    // Lấy tenant hiện tại
    public function currentTenant()
    {
        $contract = $this->currentContract;
        return $contract ? $contract->tenant : null;
    }
}