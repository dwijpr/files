<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Storage;

class IndexController extends Controller
{
    public function index($param = false, $params = false) {
        $segments = request()->segments();
        $parent = false;
        $_segments = "/";
        if (count($segments) > 0) {
            $_segments .= urldecode(implode('/', $segments));
            unset($segments[count($segments)-1]);
            $parent = implode('/', $segments);
        }
        config([
            'filesystems.disks.local.root'
            => config('filesystems.disks.local.root').$_segments
        ]);
        if (Storage::exists('.filesignore')) {
            $ignores = (explode("\n", Storage::get('.filesignore')));
        }
        $ignores[] = '.filesignore';
        $items = [];
        $directories = Storage::directories();
        foreach ($directories as $key => $value) {
            if (!in_array($value, $ignores)) {
                $items[] = new Item($value, 'directory');
            }
        }
        $files = Storage::files();
        foreach ($files as $key => $value) {
            if (!in_array($value, $ignores)) {
                $items[] = new Item($value, 'file');
            }
        }
        return view('index', [
            'items' => $items,
            'attrs' => [
                'parent' => $parent,
            ]
        ]);
    }
}

class Item{
    var $name, $type, $size, $modified;

    public function __construct($name, $type) {
        $this->name = $name;
        $this->type = $type;
        $storagePath  = Storage::disk('local')
            ->getDriver()->getAdapter()->getPathPrefix();
        if ($type === 'file') {
            $mime_type = mime_type($storagePath."/".$name);
            if (@$mime_type['mime_type']) {
                $this->type = $mime_type['mime_type'];
            } else {
                $this->type = Storage::mimeType($name);
            }
        }
        $this->size = Storage::size($name);
        $this->modified = Storage::lastModified($name);
    }
}
