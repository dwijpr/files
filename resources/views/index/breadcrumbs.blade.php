<div class="row">
    <div
        class="col-md-12 affix nav-dir"
        style="width: 100%;overflow: auto;border-bottom: 1px solid #e7e7e7;"
    >
        <ol class="breadcrumb breadcrumb-nav">
            <li>
                <a href="{{ url('browse/') }}">
                    <i class="glyphicon glyphicon-home"></i>
                </a>
            </li>
            <?php
                $_segments = [];
            ?>
            @foreach ($browse->rSegments as $i => $segment)
                <?php
                    $active = ($i == count($browse->rSegments) - 1);
                    $_segments[] = $segment;
                    $url = $active
                        ?'javascript:'
                        :url('browse/'.implode('/', $_segments));
                ?>
                <li {{ @$active?'class="active"':'' }}>
                    @if (!$active)
                        <a
                            href="{{ $url }}"
                        >
                    @endif
                        {{ urldecode($segment) }}
                    @if (!$active)
                        </a>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>
