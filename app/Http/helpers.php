<?php

use Carbon\Carbon;
use \GetId3\GetId3Core as GetId3;

if (!function_exists('to_lines')) {
    function to_lines($string) {
        return preg_split('/\n|\r/', $string, -1, PREG_SPLIT_NO_EMPTY);
    }
}

if (!function_exists('mime_type')) {
    function mime_type($path) {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (!in_array($ext, ['mp3'])){
            return false; 
        }
        $getId3 = new GetId3();
        $mimeType = $getId3
            ->analyze($path);
        return $mimeType;
    }
}

if (!function_exists('human_filesize')) {
    function human_filesize($bytes, $decimals = 2) {
        if(!$bytes){
            return "";
        }
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor))
            .@$size[$factor];
    }
}

if (!function_exists('read_time')) {
    function read_time($dateTime) {
        if (is_string($dateTime)) {
            $dateTime = explode('~', $dateTime);
            $dateTime = Carbon::createFromFormat(
                head($dateTime), last($dateTime)
            );
        }
        return $dateTime->diffForHumans();
    }
}

if (!function_exists('bool_val')) {
    function bool_val($bool) {
        $text = $bool?'true':'false';
        return $text;
    }
}

if (!function_exists('root_url')) {
    function root_url($path = false) {
        $url = $_SERVER['SERVER_NAME'].($path?"/".$path:"");
        return "//".preg_replace('~/+~', '/', $url);
    }
}

if (!function_exists('to_words')) {
    function to_words($string) {
        $words = explode('_', $string);
        return implode(' ', $words);
    }
}

if (!function_exists('activity_log')) {
    function activity_log($key, $object = []) {
        $stringObject = json_encode($object);
        \App\Activity::create([
            'user_id' => @auth()->user()->id,
            'key' => $key,
            'uri' => request()->getRequestUri(),
            'method' => request()->getMethod(),
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
            'app_name' => config('app.name'),
            'data' => $stringObject,
        ]);
    }
}

if (!function_exists('objectsToArray')) {
    function objectsToArray($objects, $key = 'id') {
        $return = [];
        if (count($objects) > 0) {
            foreach ($objects as $o) {
                $return[] = $o->$key;
            }
        }
        return $return;
    }
}

if (!function_exists('objects_to_array_key_value')) {
    function objectsToArrayKeyValue($objects, $idKey, $valueKey) {
        $return = [];
        if (count($objects) > 0) {
            foreach ($objects as $o) {
                $return[$o->$idKey] = $o->$valueKey;
            }
        }
        return $return;
    }
}