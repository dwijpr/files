<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th style="width: 96px;">Size</th>
                <th style="width: 196px;">Type</th>
                <th style="width: 156px;">Modified</th>
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
            @if (count($items))
                @foreach ($items as $i => $item)
                    <tr
                        onclick="window.location='{{ 
                            url()->current().'/'.$item->name
                        }}'"
                    >
                        <td>{{ $item->name }}</td>
                        <td class="text-right">
                            <?php
                                $size = human_filesize($item->size, true);
                            ?>
                            <span>{{ head($size) }}</span>
                            <div
                                class="text-left"
                                style="width: 24px;display: inline-block;"
                            >
                                {{ last($size) }}
                            </span>
                        </td>
                        <td>{{ $item->type }}</td>
                        <td>
                            {{ read_time('U~'.$item->modified) }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @if (!count($items))
        <h3 class="text-center">
            Nothing to Show ...
        </h3>
    @endif
</div>
