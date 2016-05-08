<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogAuthenticationAttempt
{
    public function handle(Attempting $event) {
        activity_log('authentication_attempt', [
            'event' => $event,
        ]);
    }
}