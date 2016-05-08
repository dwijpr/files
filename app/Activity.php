<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use MyModel;

    protected $fillable = [
        'user_id', 'data', 'key', 'uri', 'method', 'user_agent', 'ip_address',
        'app_name',
    ];
    protected $connection = 'super';

    /*
     * MyModel Trait
     */

    public static function listFields() {
        return [
            'id', 
            'user_id',
            'key',
            'uri',
            'method',
            'user_agent' => [ 'uaparse' => true ],
            'ip_address',
            'app_name',
            'data' => [ 'jsonview' => true ],
            'created_at',
        ];
    }

    public static function toBeFilledFields(){
        return [];
    }
}
