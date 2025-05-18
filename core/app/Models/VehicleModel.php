<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    use GlobalStatus;

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }
}
