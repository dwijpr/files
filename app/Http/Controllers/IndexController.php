<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Storage, Response;

class IndexController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->items = [];
        $this->_ = "filesystems.disks.local.root";
    }

    public function fileView($params) {
        $params = "/".$params;
        $params = str_replace(config($this->_), '', $params);
        $response = Response::make(Storage::get($params), 200);
        $response->header("Content-Type", Storage::mimeType($params));
        return $response;
    }

    private function upDir() {
        $segments = request()->segments();
        array_shift($segments);
        if (count($segments) > 0) {
            unset($segments[count($segments)-1]);
            return implode('/', $segments);
        }
        return false;
    }

    private function destDir() {
        $segments = request()->segments();
        array_shift($segments);
        if (count($segments) > 0) {
            if ($this->dest->type !== 'directory') {
                array_pop($segments);
            }
            $uri = "/".urldecode(implode('/', $segments));
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
                $this->items[] = new Item($item, $single, $this->params);
            }
        }
    }

    private function changeStorageRoot() {
        $path = config($this->_).$this->destDir();
        config([$this->_ => $path]);
    }

    private function getDestPath() {
        $segments = request()->segments();
        array_shift($segments);
        $uri = "/".urldecode(implode('/', $segments));
        $destPath = $uri;
        return $destPath;
    }

    private function checkDest() {
        $dest = new \stdClass;
        $destPath = config($this->_).$this->getDestPath();
        if (file_exists($destPath)) {
            $dest->type = 'unknown';
            if (is_dir($destPath)) {
                $dest->type = 'directory';
            } elseif (is_file($destPath)) {
                $dest->type = 'file';
            }
        } else {
            abort(404);
        }
        $this->dest = $dest;
    }

    private function execDirectory() {
        $this->ignoredFiles();
        $this->collectItems('directory');
        $this->collectItems('file');
        return [
            'items' => $this->items,
        ];
    }

    private function execFile() {
        $item = new Item(
            urldecode(last(request()->segments()))
            , 'file'
            , $this->params
        );
        return [
            'item' => $item,
        ];
    }

    public function index($params = false) {
        $this->params = $params;
        $this->checkDest();
        $this->changeStorageRoot();
        $data = [];
        switch ($this->dest->type) {
            case 'directory':
            case 'file':
                $data = $this->{'exec'.ucfirst($this->dest->type)}();
                break;
            default:
                abort(503);
        }
        $segments = request()->segments();
        array_shift($segments);
        view()->share([
            'up_dir' => $this->upDir(),
            'segments' => $segments,
        ]);
        return view('index', $data);
    }
}

class Item{
    var $name, $type, $size, $modified;

    public function __construct($name, $type, $params) {
        $this->name = $name;
        $this->type = $type;
        $storagePath  = Storage::disk('local')
            ->getDriver()->getAdapter()->getPathPrefix();
        $this->filepath = $storagePath."/".$name;
        if ($type === 'file') {
            $mime_type = mime_type($this->filepath);
            if ($mime_type !== false AND @$mime_type['mime_type']) {
                $this->type = $mime_type['mime_type'];
            } else {
                $this->type = Storage::mimeType($name);
            }
            $this->size = Storage::size($name);
            $this->src = url('view'.$this->filepath);
        } else {
            $this->size = directory_size($this->filepath);
        }
        $this->modified = Storage::lastModified($name);
        $this->url = url('browse/'.$params.'/'.$name);
    }
}
