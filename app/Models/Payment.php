<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'payment_date',
        'amount',
        'type',
        'status',
        'description',
        'due_date'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2'
    ];

    // Relationship với Contract
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    // Lấy tên loại thanh toán
    public function getTypeNameAttribute()
    {
        $types = [
            'rent' => 'Tiền Thuê',
            'deposit' => 'Tiền Cọc',
            'electricity' => 'Tiền Điện',
            'water' => 'Tiền Nước',
            'other' => 'Khác'
        ];

        return $types[$this->type] ?? 'Không xác định';
    }

    // Lấy tên trạng thái
    public function getStatusNameAttribute()
    {
        $statuses = [
            'paid' => 'Đã Thanh Toán',
            'pending' => 'Chờ Thanh Toán',
            'overdue' => 'Quá Hạn'
        ];

        return $statuses[$this->status] ?? 'Không xác định';
    }

    // Check xem thanh toán có quá hạn không
    public function isOverdue()
    {
        return $this->status !== 'paid' && 
               $this->due_date && 
               $this->due_date < now();
    }

    // Tính số ngày quá hạn
    public function getOverdueDaysAttribute()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return $this->due_date->diffInDays(now());
    }

    // Lấy CSS class cho trạng thái
    public function getStatusClassAttribute()
    {
        switch ($this->status) {
            case 'paid':
                return 'success';
            case 'pending':
                return 'warning';
            case 'overdue':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    // Lấy icon cho loại thanh toán
    public function getTypeIconAttribute()
    {
        switch ($this->type) {
            case 'rent':
                return 'fa-home';
            case 'deposit':
                return 'fa-piggy-bank';
            case 'electricity':
                return 'fa-bolt';
            case 'water':
                return 'fa-tint';
            default:
                return 'fa-money-bill';
        }
    }
}