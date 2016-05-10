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

    public function view($path = false) {
        $response = Response::make(Storage::get($path), 200);
        $response->header("Content-Type", Storage::mimeType($path));
        return $response;
    }

    public function browse($rPath = false) {
        $this->browseInit($rPath);
        $this->checkDestination();
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
            $browse->upDir = to_path($rSegments);
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
        $this->ignoredFiles();
        $this->collectItems('directory');
        $this->collectItems('file');
    }

    private function execFile() {
        $this->browse->item = new Item(
            $this->browse->aPath
            , $this->browse->rPath
        );
    }

    private function checkDestination() {
        if (file_exists($this->browse->aPath)) {
            $this->browse->filetype = filetype($this->browse->aPath);
        } else {
            abort(404);
        }
    }

    private function collectItems($single) {
        $plural = str_plural($single);
        $names = Storage::$plural($this->browse->rPath);
        foreach ($names as $i => $name) {
            $name = last(explode('/', $name));
            if (!in_array($name, $this->browse->ignores)) {
                $this->browse->items[] = new Item(
                    to_path(array_merge($this->browse->aSegments, [$name]))
                    , to_path(
                        array_merge($this->browse->rSegments, [$name])
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
    }
}
