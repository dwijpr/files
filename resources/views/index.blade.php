@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $i => $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-right">{{ $item->size }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->modified }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
