<?php

use Carbon\Carbon;
use \GetId3\GetId3Core as GetId3;

if (!function_exists('to_path')) {
    function to_path($segments, $absolute = true) {
        $segments = array_filter($segments, function($value) {
            return $value;
        });
        return ($absolute?"/":"").implode('/', $segments);
    }
}

if (!function_exists('to_segments')) {
    function to_segments($path) {
        $segments = explode('/', $path);
        return array_filter($segments, function($value) {
            return $value;
        });
    }
}

if (!function_exists('directory_size')) {
    function directory_size($path) {
        $size = 0;
        foreach (glob(rtrim($path, '/').'/*', GLOB_NOSORT) as $target) {
            $size += is_file($target)?filesize($target):directory_size($target);
        }
        return $size;
    }
}

if (!function_exists('preview_mime_type')) {
    function preview_mime_type($mime_type) {
        $maps = [
            'application/javascript' => ['text', 'javascript'],
            'application/json' => ['text', 'json'],
        ];
        return @$maps[$mime_type]?:explode('/', $mime_type);
    }
}

if (!function_exists('to_lines')) {
    function to_lines($string) {
        return preg_split('/\n|\r/', $string, -1, PREG_SPLIT_NO_EMPTY);
    }
}

if (!function_exists('mime_type')) {
    function mime_type($a_path) {
        $mime_type = mime_content_type($a_path);
        if(
            !in_array(
                $mime_type
                , ['directory', 'text/x-php', 'audio/x-m4a']
            )
        ) {
            $repository = new Dflydev\ApacheMimeTypes\PhpRepository;
            $ext = pathinfo($a_path, PATHINFO_EXTENSION);
            $mime_type = $repository->findType($ext);
            $extensions = $repository->findExtensions($mime_type);
        }
        return $mime_type;
    }
}

if (!function_exists('human_filesize')) {
    function human_filesize($bytes, $as_array = false, $decimals = 2) {
        if(!$bytes){
            if ($as_array) {
                return [ 0, 'B'];
            } else {
                return "";
            }
        }
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        if ($as_array) {
            return [
                sprintf("%.{$decimals}f ", $bytes / pow(1024, $factor)),
                @$size[$factor],
            ];
        }
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