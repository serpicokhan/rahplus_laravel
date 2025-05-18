<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ride extends Model
{
    protected $guard = ['id'];

    public function exportColumns(): array
    {
        return  [
            'rider_id' => [
                'name' => "Rider",
                "callback" => function ($item) {
                    return  @$item->user->username;
                }
            ],
            'driver_id' => [
                'name' => "Driver",
                "callback" => function ($item) {
                    return  @$item->driver->username;
                }
            ],
            'pickup_location' => [
                'name' => "Pickup Location",
            ],
            'destination' => [
                'name' => "Destination",
            ],
            'amount' => [
                'name' => "Ride Fare",
                "callback" => function ($item) {
                    return  showAmount($item->amount);
                }
            ]
        ];
    }


    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'applied_coupon_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function sosAlert()
    {
        return $this->hasMany(SosAlert::class);
    }

    public function userReview()
    {
        return $this->hasOne(Review::class)->where('driver_id', '0');
    }

    public function driverReview()
    {
        return $this->hasOne(Review::class)->where('user_id', 0);
    }

    public function payment()
    {
        return $this->hasOne(Deposit::class, 'ride_id')->where('status', Status::PAYMENT_SUCCESS);
    }

    public function pickupZone()
    {
        return $this->belongsTo(Zone::class, 'pickup_zone_id');
    }
    public function destinationZone()
    {
        return $this->belongsTo(Zone::class, 'destination_zone_id');
    }
    public function acceptBid()
    {
        return $this->hasOne(Bid::class)->where('status', Status::BID_ACCEPTED);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeCheckNoBid($query)
    {
        return $query->whereDoesntHave('bids', function ($q) {
            $q->where('driver_id', '=', auth()->id());
        });
    }

    public function scopeCanceled($query)
    {
        return $query->where('status', Status::RIDE_CANCELED);
    }

    public function scopePending($query)
    {
        return $query->where('status', Status::RIDE_PENDING);
    }

    public function scopeRunning($query)
    {
        return $query->where('status', Status::RIDE_RUNNING);
    }

    public function scopeNotRunning($query)
    {
        return $query->where('status', "!=", Status::RIDE_RUNNING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', Status::RIDE_COMPLETED);
    }

    public function scopeRidePaymentSuccess($query)
    {
        return $query->where('payment_status', Status::PAYMENT_SUCCESS);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::RIDE_PENDING) {
                $html = '<span class="badge badge--primary">' . trans('Pending') . '</span>';
            } elseif ($this->status == Status::RIDE_COMPLETED) {
                $html = '<span class="badge badge--success">' . trans('Completed') . '</span>';
            } elseif ($this->status == Status::RIDE_ACTIVE) {
                $html = '<span class="badge badge--info">' . trans('Active') . '</span>';
            } elseif ($this->status == Status::RIDE_RUNNING) {
                $html = '<span class="badge badge--warning">' . trans('Running') . '</span>';
            } elseif ($this->status == Status::RIDE_END) {
                $html = '<span class="badge badge--success">' . trans('End') . '</span>';
            } elseif ($this->status == Status::RIDE_CANCELED) {
                $html = '<span class="badge badge--danger">' . trans('Canceled') . '</span>';
            }
            return $html;
        });
    }

    public function paymentTypes(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->payment_type == Status::PAYMENT_TYPE_GATEWAY) {
                $html = '<span class="badge badge--warning">' . '<i class="far fa-credit-card me-2"></i>' . trans('Gateway') . '</span>';
            } elseif ($this->payment_type == Status::PAYMENT_TYPE_CASH) {
                $html = '<span class="badge badge--success">' . '<i class="fas fa-money-bill me-2"></i>' . trans('Cash') . '</span>';
            } else {
                $html = '<span class="badge badge--primary">' . '<i class="fas fa-wallet me-2"></i>' . trans('Wallet') . '</span>';
            }
            return $html;
        });
    }

    public function paymentStatusType(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->payment_status == Status::PAYMENT_SUCCESS) {
                $html = '<span class="badge badge--success">' . '<i class="las la-check me-2"></i>' . trans('Paid') . '</span>';
            } else {
                $html = '<span class="badge badge--warning">' . '<i class="las la-redo-alt me-2"></i>' . trans('Pending') . '</span>';
            }
            return $html;
        });
    }
}
