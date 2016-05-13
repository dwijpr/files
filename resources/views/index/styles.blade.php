@section('styles')

    <style>
        .breadcrumb.breadcrumb-nav {
            background: none;
            white-space: nowrap;
        }
        .breadcrumb.breadcrumb-nav > li + li:before {
            content: ">";
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

        .file-info table td:nth-child(2) {
            padding-left: 16px;
        }

        .file-preview video {
            display: inline-block;
            max-width: 100%;
            max-height: 384px;
        }
    </style>

@endsection
