<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th style="width: 96px;">Size</th>
                <th style="width: 156px;">Modified</th>
            </tr>
        </thead>
        <tbody>
            @if ($browse->upDir !== false)
                <tr
                    onclick="window.location='{{ 
                        url($browse->upDir)
                    }}'"
                >
                    <td colspan="4">..</td>
                </tr>
            @endif
            @if (count($browse->items))
                @foreach ($browse->items as $i => $item)
                    <tr
                        onclick="window.location='{{ 
                            url($item->url)
                        }}'"
                    >
                        <td>
                            <i
                                class="fa fa-{{ to_icon($item->mimeType) }}"
                                title="{{ $item->mimeType }}"
                            ></i>
                            {{ $item->name }}
                        </td>
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
                        <td>
                            {{ read_time('U~'.$item->modified) }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @if (!count($browse->items))
        <h3 class="text-center">
            Nothing to Show ...
        </h3>
    @endif
</div>
