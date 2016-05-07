<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        activity_log([
            'key' => 'Request',
            'params' => [
                'requestUri' => request()->getRequestUri(),
                'method' => request()->getMethod(),
                'user-agent' => request()->header('User-Agent'),
            ]
        ]);
        if (method_exists($this, 'init')) {
            $this->init();
        }
    }
}
