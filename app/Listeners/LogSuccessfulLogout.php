<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Activity;

class LogSuccessfulLogout
{
    public function handle(Logout $event)
    {
        activity_log([
            'key' => 'LogSuccessfulLogout',
            'event' => $event,
        ]);
    }
}