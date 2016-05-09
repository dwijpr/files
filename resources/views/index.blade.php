@extends('layouts.app')


@section('styles')

    <style>
        /** The Magic **/
        .btn-breadcrumb .btn:not(:last-child):after {
          content: " ";
          display: block;
          width: 0;
          height: 0;
          border-top: 17px solid transparent;
          border-bottom: 17px solid transparent;
          border-left: 10px solid white;
          position: absolute;
          top: 50%;
          margin-top: -17px;
          left: 100%;
          z-index: 3;
        }
        .btn-breadcrumb .btn:not(:last-child):before {
          content: " ";
          display: block;
          width: 0;
          height: 0;
          border-top: 17px solid transparent;
          border-bottom: 17px solid transparent;
          border-left: 10px solid rgb(173, 173, 173);
          position: absolute;
          top: 50%;
          margin-top: -17px;
          margin-left: 1px;
          left: 100%;
          z-index: 3;
        }

        /** The Spacing **/
        .btn-breadcrumb .btn {
          padding:6px 12px 6px 24px;
        }
        .btn-breadcrumb .btn:first-child {
          padding:6px 6px 6px 10px;
        }
        .btn-breadcrumb .btn:last-child {
          padding:6px 18px 6px 24px;
        }

        /** Default button **/
        .btn-breadcrumb .btn.btn-default:not(:last-child):after {
          border-left: 10px solid #fff;
        }
        .btn-breadcrumb .btn.btn-default:not(:last-child):before {
          border-left: 10px solid #ccc;
        }
        .btn-breadcrumb .btn.btn-default:hover:not(:last-child):after {
          border-left: 10px solid #ebebeb;
        }
        .btn-breadcrumb .btn.btn-default:hover:not(:last-child):before {
          border-left: 10px solid #adadad;
        }

        /** Primary button **/
        .btn-breadcrumb .btn.btn-primary:not(:last-child):after {
          border-left: 10px solid #428bca;
        }
        .btn-breadcrumb .btn.btn-primary:not(:last-child):before {
          border-left: 10px solid #357ebd;
        }
        .btn-breadcrumb .btn.btn-primary:hover:not(:last-child):after {
          border-left: 10px solid #3276b1;
        }
        .btn-breadcrumb .btn.btn-primary:hover:not(:last-child):before {
          border-left: 10px solid #285e8e;
        }

        /** Success button **/
        .btn-breadcrumb .btn.btn-success:not(:last-child):after {
          border-left: 10px solid #5cb85c;
        }
        .btn-breadcrumb .btn.btn-success:not(:last-child):before {
          border-left: 10px solid #4cae4c;
        }
        .btn-breadcrumb .btn.btn-success:hover:not(:last-child):after {
          border-left: 10px solid #47a447;
        }
        .btn-breadcrumb .btn.btn-success:hover:not(:last-child):before {
          border-left: 10px solid #398439;
        }

        /** Danger button **/
        .btn-breadcrumb .btn.btn-danger:not(:last-child):after {
          border-left: 10px solid #d9534f;
        }
        .btn-breadcrumb .btn.btn-danger:not(:last-child):before {
          border-left: 10px solid #d43f3a;
        }
        .btn-breadcrumb .btn.btn-danger:hover:not(:last-child):after {
          border-left: 10px solid #d2322d;
        }
        .btn-breadcrumb .btn.btn-danger:hover:not(:last-child):before {
          border-left: 10px solid #ac2925;
        }

        /** Warning button **/
        .btn-breadcrumb .btn.btn-warning:not(:last-child):after {
          border-left: 10px solid #f0ad4e;
        }
        .btn-breadcrumb .btn.btn-warning:not(:last-child):before {
          border-left: 10px solid #eea236;
        }
        .btn-breadcrumb .btn.btn-warning:hover:not(:last-child):after {
          border-left: 10px solid #ed9c28;
        }
        .btn-breadcrumb .btn.btn-warning:hover:not(:last-child):before {
          border-left: 10px solid #d58512;
        }

        /** Info button **/
        .btn-breadcrumb .btn.btn-info:not(:last-child):after {
          border-left: 10px solid #5bc0de;
        }
        .btn-breadcrumb .btn.btn-info:not(:last-child):before {
          border-left: 10px solid #46b8da;
        }
        .btn-breadcrumb .btn.btn-info:hover:not(:last-child):after {
          border-left: 10px solid #39b3d7;
        }
        .btn-breadcrumb .btn.btn-info:hover:not(:last-child):before {
          border-left: 10px solid #269abc;
        }

        body {
            padding-top: 50px;
        }
        .navbar {
            margin-bottom: 0;
        }
        .nav-dir {
            padding-top: 24px;
            z-index: 1;
            background: white;
        }
        .nav-dir hr {
            margin-bottom: 0;
        }
        .content {
            padding-top: 96px;
        }
    </style>

@endsection


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div
                class="col-md-12 affix nav-dir"
                style="width: 100%;overflow: auto;"
            >
                <div class="btn-group btn-breadcrumb">
                    <a href="{{ url('/') }}" class="btn btn-default">
                        <i class="glyphicon glyphicon-home"></i>
                    </a>
                    <?php
                        $_segments = [];
                    ?>
                    @foreach ($segments as $i => $segment)
                        <?php
                            $_segments[] = $segment;
                        ?>
                        <a
                            href="{{ url(implode('/', $_segments)) }}"
                            class="btn btn-default"
                        >
                            {{ urldecode($segment) }}
                        </a>
                    @endforeach
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="content">
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
    </div>

@endsection
