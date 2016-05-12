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
            @foreach ($browse->rSegments as $i => $segment)
                <?php
                    $active = ($i == count($browse->rSegments) - 1);
                    $url = $active
                        ?'javascript:'
                        :url('browse/'.implode('/', $_segments));
                    $_segments[] = $segment;
                ?>
                <a
                    href="{{ $url }}"
                    class="btn btn-default {{
                        $active?'active':''
                    }}"
                >
                    {{ urldecode($segment) }}
                </a>
            @endforeach
        </div>
        <hr>
    </div>
</div>
