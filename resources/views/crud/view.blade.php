@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                @include('crud.partials.form', [
                    'url' => $___classAttrs->single.'/'.$object->id,
                    'method' => 'patch',
                    'submitLabel' => 'Update',
                    'readonly' => true,
                ])
            </div>
        </div>
    </div>

@endsection
