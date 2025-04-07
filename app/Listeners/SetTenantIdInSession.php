<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SetTenantIdInSession
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if (Auth::check() && Auth::user()) {
            Session::put('tenant_id', Auth::user()->tenant_id);
        }
    }
}
