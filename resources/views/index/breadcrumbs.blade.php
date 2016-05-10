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
