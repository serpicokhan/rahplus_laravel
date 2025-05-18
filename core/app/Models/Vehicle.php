<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $casts = [
        'form_data' => 'object',
    ];

    protected $appends = [
        'image_src'
    ];

    public function model()
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }
    public function year()
    {
        return $this->belongsTo(VehicleYear::class, 'year_id');
    }
    public function color()
    {
        return $this->belongsTo(VehicleColor::class, 'color_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function imageSrc(): Attribute
    {
        return new Attribute(
            get: fn() => getImage(getFilePath('vehicle') . '/' . $this->image),
        );
    }
}
