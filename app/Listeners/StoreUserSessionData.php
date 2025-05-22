<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Session;
class StoreUserSessionData
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event)
    {
        $user = $event->user;

        // Simpan data tambahan ke session
        Session::put('role', $user->role->name ?? '');
        Session::put('name', $user->name);
    }
}
