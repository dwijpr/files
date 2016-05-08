<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Activity;

class ActivityController extends CRUDController
{
    use AuthTrait;

    protected $model = Activity::class;
    protected $viewOnly = true;

    public function _init() {
        if (!$this->authorized('manage-users')) abort(403);
    }
}
