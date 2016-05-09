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
                                <th style="width: 108px;">Size</th>
                                <th>Type</th>
                                <th style="width: 148px;">Modified</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($up_dir !== false)
                                <tr
                                    onclick="window.location='{{ 
                                        url($up_dir)
                                    }}'"
                                >
                                    <td colspan="4">..</td>
                                </tr>
                            @endif
                            @foreach ($items as $i => $item)
                                <tr
                                    @if ($item->type === 'directory')
                                        onclick="window.location='{{ 
                                            url()->current().'/'.$item->name
                                        }}'"
                                    @endif
                                >
                                    <td>{{ $item->name }}</td>
                                    <td class="text-right">
                                        {{ human_filesize($item->size) }}
                                    </td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        {{ read_time('U~'.$item->modified) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
