<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use MyModel;

    protected $table = 'activity_log';

    /*
     * MyModel Trait
     */

    public static function listFields() {
        return [
            'id', 
            'user_id',
            'text' => [ 'jsonview' => true ],
            'ip_address',
            'created_at',
        ];
    }

    public static function toBeFilledFields(){
        return [];
    }
}
