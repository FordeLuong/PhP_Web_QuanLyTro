<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'id_card',
        'address'
    ];

    // Relationship với Contract (chỉ khi đã có bảng contracts)
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

    // Check xem có đang thuê phòng không
    public function hasActiveContract()
    {
        try {
            return $this->currentContract()->exists();
        } catch (\Exception $e) {
            // Nếu chưa có bảng contracts, return false
            return false;
        }
    }

    // Format số điện thoại
    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
            return substr($phone, 0, 4) . '.' . substr($phone, 4, 3) . '.' . substr($phone, 7);
        }
        return $phone;
    }

    // Ẩn một phần CMND/CCCD
    public function getMaskedIdCardAttribute()
    {
        $idCard = $this->id_card;
        if (strlen($idCard) >= 8) {
            return substr($idCard, 0, 3) . '***' . substr($idCard, -3);
        }
        return $idCard;
    }
}