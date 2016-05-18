<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'IndexController@browse');

Route::get('/browse/{path?}', 'IndexController@browse')->where('path', '(.)*');
Route::get('/view/{path?}', 'IndexController@view')->where('path', '(.)*');
Route::get('/download/{path?}', 'IndexController@download')->where('path', '(.)*');
Route::get('/custom/asset/{path?}', 'IndexController@customAsset')->where('path', '(.)*');

$objects = [];

foreach ($objects as $i => $v) {
    $object = new \stdClass;
    $object->class = $v;
    $object->singularName = strtolower($v);
    $object->pluralName = str_plural($object->singularName);
    CRUDRoutes($object);
}

function _route($method, $uri, $controller){
    $root = "/dashboard/";
    Route::$method($root.$uri, $controller);
}

function CRUDRoutes($object){
    $controller = $object->class.'Controller@';
    $plural = $object->pluralName;
    $single = $object->singularName;

    _route('get',    $plural,                   $controller.'index');
    _route('get',    $plural.'/'."{{$single}}", $controller.'view');
    _route('get',    $single,                   $controller.'create');
    _route('post',   $single,                   $controller.'store');
    _route('get',    $single.'/'."{{$single}}", $controller.'edit');
    _route('patch',  $single.'/'."{{$single}}", $controller.'update');
    _route('delete', $single.'/'."{{$single}}", $controller.'destroy');
}