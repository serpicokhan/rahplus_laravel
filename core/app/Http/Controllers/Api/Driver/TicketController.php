<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Traits\SupportTicketManager;

class TicketController extends Controller
{
    use SupportTicketManager;

    public function __construct()
    {
        $this->userType   = 'driver';
        $this->column     = 'driver_id';
        $this->user       = auth()->user();
        $this->apiRequest = true;
    }
}
