<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use GlobalStatus;

    public function models()
    {
        return $this->hasMany(VehicleModel::class, 'brand_id');
    }
}
