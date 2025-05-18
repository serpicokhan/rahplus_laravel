<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use  GlobalStatus;

    protected $casts = [
        'coordinates'  => "array"
    ];
}
