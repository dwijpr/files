<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Activity;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        activity_log('successful_login', [
            'event' => $event,
        ]);
    }
}