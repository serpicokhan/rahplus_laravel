<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\DriverNotify;
use App\Traits\GlobalStatus;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasApiTokens, DriverNotify, GlobalStatus;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function __construct()
    {
        if (request()->is('api/*')) {
            $this->append('rules');
        }
    }
    protected $hidden = [
        'password',
        'remember_token',
        'ver_code',
        'balance'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'driver_data'       => 'object',
        'rider_rule_id'     => 'object',
        'custom_rules'      => 'object',
        'ver_code_send_at'  => 'datetime',
    ];

    public function exportColumns(): array
    {
        return  [
            'firstname',
            'lastname',
            'username',
            'email',
            'mobile',
            "country_name",
            "balance" => [
                'callback' => function ($item) {
                    return showAmount($item->balance);
                }
            ],
            "created_at" => [
                'name' => "Joined At",
                'callback' => function ($item) {
                    return showDateTime($item->created_at, lang: 'en');
                }
            ],
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'driver_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'driver_id');
    }

    public function ride()
    {
        return $this->hasMany(Ride::class, 'driver_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class, 'driver_id');
    }

    public function bid()
    {
        return $this->hasMany(Bid::class, 'driver_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'driver_id')->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function riderRules()
    {
        return RiderRule::active()->whereIn('id', $this->rider_rule_id ?? [])->get();
    }

    public function rules(): Attribute
    {
        return new Attribute(function () {
            return $this->riderRules()->pluck('name');
        });
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn() => $this->firstname . ' ' . $this->lastname,
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED)->where('vv', Status::VERIFIED);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeDocumentUnverified($query)
    {
        return $query->where('dv', Status::UNVERIFIED);
    }

    public function scopeDocumentVerifyPending($query)
    {
        return $query->where('dv', Status::PENDING);
    }

    public function scopeVehicleUnverified($query)
    {
        return $query->where('vv', Status::UNVERIFIED);
    }

    public function scopeVehicleVerifyPending($query)
    {
        return $query->where('vv', Status::PENDING);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function scopeWithBalance($query)
    {
        return $query->where('balance', '>', 0);
    }

    public function scopeNotRunning($query)
    {
        return $query->whereDoesntHave('ride', function ($ride) {
            $ride->running();
        });
    }

    public function imageSrc(): Attribute
    {
        return new Attribute(
            get: fn() => getImage(getFilePath('driver') . '/' . $this->image, getFilePath('driver'), isAvatar: true),
        );
    }

    public function fullNameShortForm(): Attribute
    {
        return new Attribute(
            get: fn() => strtoupper(substr($this->firstname, 0, 1)) . strtoupper(substr($this->lastname, 0, 1)),
        );
    }
    public function mobileNumber(): Attribute
    {
        return new Attribute(
            get: fn() => $this->dial_code . $this->mobile,
        );
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get: fn() => $this->badgeData(),
        );
    }

    public function documentVerificationBadge(): Attribute
    {
        $html = '';
        if ($this->dv == Status::VERIFIED) {
            $html = '<span class="badge  badge--success">' . trans('Verified') . '</span>';
        } elseif ($this->dv == Status::PENDING) {
            $html = '<span class="badge  badge--warning">' . trans('Pending') . '</span>';
        } else {
            $html = '<span class="badge  badge--danger">' . trans('Unverified') . '</span>';
        }
        return new Attribute(
            get: fn() => $html,
        );
    }
    public function vehicleVerificationBadge(): Attribute
    {
        $html = '';
        if ($this->vv == Status::VERIFIED) {
            $html = '<span class="badge  badge--success">' . trans('Verified') . '</span>';
        } elseif ($this->vv == Status::PENDING) {
            $html = '<span class="badge  badge--warning">' . trans('Pending') . '</span>';
        } else {
            $html = '<span class="badge  badge--danger">' . trans('Unverified') . '</span>';
        }
        return new Attribute(
            get: fn() => $html,
        );
    }
}
