<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use GlobalStatus;

    public function scopeActive($query)
    {
        return $query->whereDate('start_from', '<=', now())->whereDate('end_at', '>=', now())->where('status', Status::ENABLE);
    }

    public function rides()
    {
        return $this->hasMany(Ride::class, 'applied_coupon_id');
    }
}
