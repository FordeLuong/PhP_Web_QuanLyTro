<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'tenant_id',
        'start_date',
        'end_date',
        'deposit',
        'monthly_rent',
        'status',
        'terms',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'deposit' => 'decimal:2',
        'monthly_rent' => 'decimal:2'
    ];

    // Relationship với Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relationship với Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Relationship với Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Check xem hợp đồng có còn hiệu lực không
    public function isActive()
    {
        return $this->status === 'active' && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }

    // Check xem hợp đồng đã hết hạn chưa
    public function isExpired()
    {
        return $this->end_date < now() || $this->status === 'expired';
    }

    // Tính số tháng của hợp đồng
    public function getDurationInMonthsAttribute()
    {
        return $this->start_date->diffInMonths($this->end_date);
    }

    // Tính số ngày còn lại
    public function getRemainingDaysAttribute()
    {
        if ($this->isExpired()) {
            return 0;
        }
        return max(0, now()->diffInDays($this->end_date, false));
    }

    // Format thời gian còn lại ngắn gọn
    public function getRemainingTimeAttribute()
    {
        $days = $this->remaining_days;
        
        if ($days <= 0) {
            return 'Hết hạn';
        } elseif ($days < 30) {
            return $days . ' ngày';
        } elseif ($days < 365) {
            $months = round($days / 30);
            return $months . ' tháng';
        } else {
            $years = round($days / 365, 1);
            return $years . ' năm';
        }
    }

    // Tổng số tiền đã thanh toán
    public function getTotalPaidAttribute()
    {
        return $this->payments()->where('status', 'paid')->sum('amount');
    }

    // Tổng số tiền còn phải trả
    public function getTotalDueAttribute()
    {
        return $this->payments()->whereIn('status', ['pending', 'overdue'])->sum('amount');
    }
}