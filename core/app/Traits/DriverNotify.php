<?php
namespace App\Traits;

use App\Constants\Status;

trait DriverNotify
{
    public static function notifyToDriver(){
        return [
            'allDrivers'               => 'All Drivers',
            'selectedDrivers'          => 'Selected Drivers',
            'withBalance'              => 'With Balance Drivers',
            'emptyBalanceDrivers'      => 'Empty Balance Drivers',
            'twoFaDisableDrivers'      => '2FA Disable User',
            'twoFaEnableDrivers'       => '2FA Enable User',
            'hasDepositedDrivers'      => 'Deposited Drivers',
            'notDepositedDrivers'      => 'Not Deposited Drivers',
            'pendingDepositedDrivers'  => 'Pending Deposited Drivers',
            'rejectedDepositedDrivers' => 'Rejected Deposited Drivers',
            'topDepositedDrivers'      => 'Top Deposited Drivers',
            'hasWithdrawDrivers'       => 'Withdraw Drivers',
            'pendingWithdrawDrivers'   => 'Pending Withdraw Drivers',
            'rejectedWithdrawDrivers'  => 'Rejected Withdraw Drivers',
            'notLoginDrivers'          => 'Last Few Days Not Login Drivers',
        ];
    }

    public function scopeSelectedDrivers($query)
    {
        return $query->whereIn('id', request()->user ?? []);
    }

    public function scopeAllDrivers($query)
    {
        return $query;
    }

    public function scopeEmptyBalanceDrivers($query)
    {
        return $query->where('balance', '<=', 0);
    }

    public function scopeTwoFaDisableDrivers($query)
    {
        return $query->where('ts', Status::DISABLE);
    }

    public function scopeTwoFaEnableDrivers($query)
    {
        return $query->where('ts', Status::ENABLE);
    }

    public function scopeHasDepositedDrivers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        });
    }

    public function scopeNotDepositedDrivers($query)
    {
        return $query->whereDoesntHave('deposits', function ($q) {
            $q->successful();
        });
    }

    public function scopePendingDepositedDrivers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->pending();
        });
    }

    public function scopeRejectedDepositedDrivers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->rejected();
        });
    }

    public function scopeTopDepositedDrivers($query)
    {
        return $query->whereHas('deposits', function ($deposit) {
            $deposit->successful();
        })->withSum(['deposits'=>function($q){
            $q->successful();
        }], 'amount')->orderBy('deposits_sum_amount', 'desc')->take(request()->number_of_top_deposited_driver ?? 10);
    }

    public function scopeHasWithdrawDrivers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->approved();
        });
    }

    public function scopePendingWithdrawDrivers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->pending();
        });
    }

    public function scopeRejectedWithdrawDrivers($query)
    {
        return $query->whereHas('withdrawals', function ($q) {
            $q->rejected();
        });
    }

 

    public function scopeNotLoginDrivers($query)
    {
        return $query->whereDoesntHave('loginLogs', function ($q) {
            $q->whereDate('created_at', '>=', now()->subDays(request()->number_of_days ?? 10));
        });
    }

}