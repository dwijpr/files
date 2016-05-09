<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Storage;

class IndexController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->items = [];
        $this->_ = "filesystems.disks.local.root";
    }

    private function upDir() {
        $segments = request()->segments();
        if (count($segments) > 0) {
            unset($segments[count($segments)-1]);
            return implode('/', $segments);
        }
        return false;
    }

    private function destDir() {
        $segments = request()->segments();
        if (count($segments) > 0) {
            $uri = "/".urldecode(implode('/', $segments));
            if (!file_exists(config($this->_).$uri)) {
                abort(404);
            }
            return $uri;
        }
        return false;
    }

    private function ignoredFiles() {
        $ignores = ['.files', '.filesignore'];
        if (Storage::exists('.filesignore')) {
            $ignores = array_merge(
                $ignores, to_lines(Storage::get('.filesignore'))
            );
        }
        return $this->ignores = $ignores;
    }

    private function collectItems($single) {
        $plural = str_plural($single);
        $items = Storage::$plural();
        foreach ($items as $i => $item) {
            if (!in_array($item, $this->ignores)) {
                $this->items[] = new Item($item, $single);
            }
        }
    }

    private function changeStorageRoot() {
        $path = config($this->_).$this->destDir();
        config([$this->_ => $path]);
    }

    public function index($params = false) {
        $this->changeStorageRoot();
        $this->ignoredFiles();
        $this->collectItems('directory');
        $this->collectItems('file');
        return view('index', [
            'items' => $this->items,
            'up_dir' => $this->upDir(),
            'segments' => request()->segments(),
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
            if ($mime_type !== false AND @$mime_type['mime_type']) {
                $this->type = $mime_type['mime_type'];
            } else {
                $this->type = Storage::mimeType($name);
            }
        }
        $this->size = Storage::size($name);
        $this->modified = Storage::lastModified($name);
    }
}
