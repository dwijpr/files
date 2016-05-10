@extends('layouts.app')


@include('index.styles')


@section('content')

    <div class="container-fluid">

        @include('index.breadcrumbs')

        <div class="row">
            <div class="col-md-12">
                <div class="content">

                    @if (!@$browse->item)

                        @include('index.list')

                    @else

                        @include('index.file')

                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
