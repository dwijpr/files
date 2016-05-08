<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

use App\Http\Requests;


abstract class CRUDController extends Controller {

    public function __construct() {
        parent::__construct();
        view()->share(
            '___classAttrs'
            , $this->buildVars()
        );
        $this->middleware('crud.view_only', ['only' => [
            'create', 'store', 'destroy', 'edit', 'update',
        ]]);
        $this->middleware('crud.has_many_objects', [ 'only' => [
            'view', 'create', 'edit',
        ]]);
    }

    private function buildVars() {
        $___vars = new \stdClass;
        $___vars->model = $this->model;
        $modelName = last(explode('\\', $this->model));
        $___vars->single = strtolower($modelName);
        $___vars->plural = str_plural($___vars->single);
        $___vars->backend = 'dashboard/';
        $___vars->redirect = $___vars->backend.$___vars->plural;
        if (@$this->hasManyObjects()) {
            $___vars->hasMany = str_plural(strtolower($this->hasManyObjects()));
            request()->request->add([
                'crud.hasManyObjects' => $this->hasManyObjectsAvailable()
            ]);
        }
        $___vars->viewOnly = @$this->viewOnly;
        request()->request->add(['crud.viewOnly' => $___vars->viewOnly]);
        $___vars->actionViewPath = 'crud.partials.action';
        return $this->___vars = $___vars;
    }

    public function index() {
        return view('crud.index', [
            'objects' =>
                $this->___vars->model::paginate(
                    config('app.values.pagination')
                ),
        ]);
    }

    public function view($id) {
        return view('crud.view', [
            'object' => $this->___vars->model::findOrFail($id)
        ]);
    }

    public function create() {
        return view('crud.create');
    }

    public function store() {
        $this->validate(request(), $this->validation());
        $this->___vars->model::create($this->data());
        return redirect($this->___vars->redirect);
    }

    public function destroy($id) {
        $this->___vars->model::findOrFail($id)->delete();
        return redirect($this->___vars->redirect);
    }

    public function edit($id) {
        return view('crud.edit', [
            'object' => $this->___vars->model::findOrFail($id),
        ]);
    }

    public function update($id) {
        $object = $this->___vars->model::findOrFail($id);
        $this->validate(
            request()
            , $this->validation($object->id)
        );
        $object->update($this->data(request()));
        return redirect($this->___vars->redirect);
    }

    protected function validation($id = false) {
        return [];
    }
    
    protected function data() {
        return [];
    }

    protected function hasManyObjects() {
        return false;
    }

    protected function hasManyObjectsAvailable() {
        return $this->hasManyObjects()::all();
    }
}
