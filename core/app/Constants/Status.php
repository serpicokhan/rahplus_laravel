<?php

namespace App\Constants;

class Status
{

    const ENABLE  = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO  = 0;

    const UNVERIFIED          = 0;
    const VERIFIED            = 1;
    const PENDING             = 2;
    const VERIFICATION_REJECT = 9;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS  = 1;
    const PAYMENT_PENDING  = 2;
    const PAYMENT_REJECT   = 3;

    const TICKET_OPEN   = 0;
    const TICKET_ANSWER = 1;
    const TICKET_REPLY  = 2;
    const TICKET_CLOSE  = 3;

    const PRIORITY_LOW    = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM  = 3;

    const DISCOUNT_PERCENT = 1;
    const DISCOUNT_FIXED   = 2;

    const RIDE_PENDING   = 0;
    const RIDE_COMPLETED = 1;
    const RIDE_ACTIVE    = 2;
    const RIDE_RUNNING   = 3;
    const RIDE_END       = 4;
    const RIDE_CANCELED  = 9;

    const BID_PENDING  = 0;
    const BID_ACCEPTED = 1;
    const BID_CANCELED = 8;
    const BID_REJECTED = 9;

    const PAYMENT_TYPE_GATEWAY = 1;
    const PAYMENT_TYPE_CASH    = 2;
    
    const UNPAID                   = 0;
    const PAID                     = 1;
    const WAITING_FOR_CASH_PAYMENT = 3;

    const CITY_RIDE       = 1;
    const INTER_CITY_RIDE = 2;

    const USER   = 1;
    const DRIVER = 2;
}
