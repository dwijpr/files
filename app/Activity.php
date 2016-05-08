<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use MyModel;

    protected $fillable = [
        'user_id', 'data', 'key', 'user_agent', 'ip_address',
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
            'user_agent',
            'ip_address',
            'data' => [ 'jsonview' => true ],
            'created_at',
        ];
    }

    public static function toBeFilledFields(){
        return [];
    }
}
