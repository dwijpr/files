<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Storage;

class IndexController extends Controller
{
    public function index() {
        $ignores = (explode("\n", Storage::get('.filesignore')));
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
        return view('index', ['items' => $items]);
    }
}

class Item{
    var $name, $type, $size, $modified;

    public function __construct($name, $type) {
        $this->name = $name;
        $this->type = $type;
        $this->size = Storage::size($name);
        $this->modified = Storage::lastModified($name);
    }
}
