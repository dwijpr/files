<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Storage, Response;

class IndexController extends Controller
{
    protected $disk = 'local';

    public function __construct() {
        parent::__construct();
    }

    public function download($path = false) {
        $this->browseInit($path);
        if(!is_file($this->browse->aPath)) {
            abort(404);
        }
        return response()->download($this->browse->aPath);
    }

    public function view($path = false) {
        $response = Response::make(Storage::get($path), 200);
        $response->header("Content-Type", Storage::mimeType($path));
        return $response;
    }

    public function browse($rPath = false) {
        $this->browseInit($rPath);
        $this->checkDestination();
        $this->ignoredFiles();
        switch ($this->browse->filetype) {
            case 'dir':
            case 'file':
                $this->{'exec'.ucfirst($this->browse->filetype)}();
                break;
            default:
                abort(503);
        }
        return view('index', [
            'browse' => $this->browse
        ]);
    }

    private function browseInit($rPath) {
        $browse = new \stdClass;
        $browse->storageConfigKey = "filesystems.disks.{$this->disk}.root";
        $browse->storageRootPath = config($browse->storageConfigKey);
        $browse->storageRootSegments = to_segments($browse->storageRootPath);
        $browse->rPath = $rPath;
        $browse->rSegments = to_segments($rPath);
        $browse->aSegments = array_merge(
            $browse->storageRootSegments
            , $browse->rSegments
        );
        $browse->aPath = to_path($browse->aSegments);
        $browse->upDir = false;
        $rSegments = $browse->rSegments;
        if (count($rSegments)) {
            array_pop($rSegments);
            $browse->upDir = to_path(array_merge(['browse'], $rSegments));
        }
        $browse->items = [];
        $this->browse = $browse;
    }

    private function ignoredFiles() {
        $ignores = ['.files', '.filesignore'];
        if (Storage::exists($this->browse->rPath.'/.filesignore')) {
            $ignores = array_merge(
                $ignores
                , to_lines(Storage::get($this->browse->rPath.'/.filesignore'))
            );
        }
        return $this->browse->ignores = $ignores;
    }

    private function execDir() {
        $this->collectItems('directory');
        $this->collectItems('file');
    }

    private function execFile() {
        $rSegments = $this->browse->rSegments;
        array_pop($rSegments);
        $this->collectItems(
            'file'
            , to_path($rSegments, false)
        );
        $this->browse->item = new Item(
            $this->browse->aPath
            , $this->browse->rPath
        );
        $itemIndex = 0;
        foreach ($this->browse->items as $i => $item) {
            if ($item->name === $this->browse->item->name) {
                $itemIndex = $i;
                break;
            }
        }
        $itemPrevIndex = $itemIndex-1;
        $itemNextIndex = $itemIndex+1;
        $this->browse->prevItem = ($itemPrevIndex<0)
            ?false:$this->browse->items[$itemPrevIndex];
        $this->browse->nextItem = ($itemNextIndex>=count($this->browse->items))
            ?false:$this->browse->items[$itemNextIndex];
    }

    private function checkDestination() {
        if (file_exists($this->browse->aPath)) {
            $this->browse->filetype = filetype($this->browse->aPath);
        } else {
            abort(404);
        }
    }

    private function collectItems($single, $rPath = false) {
        $aSegments = $this->browse->aSegments;
        $rSegments = $this->browse->rSegments;
        if ($rPath) {
            array_pop($aSegments);
            array_pop($rSegments);
        }
        $rPath = $rPath?:$this->browse->rPath;
        $plural = str_plural($single);
        $names = Storage::$plural($rPath);
        foreach ($names as $i => $name) {
            $name = last(explode('/', $name));
            if (!in_array($name, $this->browse->ignores)) {
                $this->browse->items[] = new Item(
                    to_path(array_merge($aSegments, [$name]))
                    , to_path(
                        array_merge($rSegments, [$name])
                        , false
                    )
                );
            }
        }
    }
}

class Item{

    public function __construct($aPath, $rPath) {
        $this->name = last(to_segments($aPath));
        $this->mimeType = mime_type($aPath);
        if ($this->mimeType === 'directory') {
            $this->size = directory_size($aPath);
        } else {
            $this->size = Storage::size($rPath);
        }
        $this->modified = Storage::lastModified($rPath);
        $this->url = url('browse/'.$rPath);
        $this->src = url('view/'.$rPath);
        $this->download = url('download/'.$rPath);
        $this->rPath = $rPath;
    }

    public function get() {
        return Storage::get($this->rPath);
    }
}
