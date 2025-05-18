<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Bid extends Model
{

    protected $guard = ['id'];
    
    public function ride()
    {
        return $this->belongsTo(Ride::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function scopeRideCompleted($query)
    {
        $query->whereHas('ride', function ($q) {
            $q->where('status', Status::RIDE_COMPLETED);
        });
    }


    public function scopePendingRide($query)
    {
        return $query->whereHas('ride', function ($q) {
            $q->pending()->notRunning();
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::BID_PENDING);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', Status::BID_ACCEPTED);
    }


    public function scopeDriverActiveRide($query)
    {
        return $query->whereHas('ride', function ($q) {
            $q->pending()->running();
        });
    }

    public function scopeCancelRide($query)
    {
        return $query->whereHas('ride', function ($ride) {
            $ride->canceled();
        });
    }

    public function scopeRideNotAccepted($query)
    {
        return $query->whereHas('ride', function ($ride) {
            $ride->notAccepted();
        });
    }

    public function scopeRideAccepted($query)
    {
        return $query->whereHas('ride', function ($ride) {
            $ride->pending()->accepted()->notRunning();
        });
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::BID_PENDING) {
                $html = '<span class="badge badge--primary">' . trans('Pending') . '</span>';
            } elseif ($this->status == Status::BID_ACCEPTED) {
                $html = '<span class="badge badge--success">' . trans('Accepted') . '</span>';
            } elseif ($this->status == Status::BID_REJECTED) {
                $html = '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
            } elseif ($this->status == Status::BID_CANCELED) {
                $html = '<span class="badge badge--warning">' . trans('Canceled') . '</span>';
            }
            return $html;
        });
    }
}
