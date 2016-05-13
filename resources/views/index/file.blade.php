<div class="row">
    <!--
    <div class="col-md-3">

        @include('index.file.info')

    </div>
    -->

    <div class="col-md-12">
        <div class="btn-group" role="group" aria-label="...">
                <a 
                    @if ($browse->prevItem)
                        title="{{ $browse->prevItem->name }}"
                        href="{{ url($browse->prevItem->url) }}"
                        class="btn btn-default" 
                    @else
                        class="btn btn-default disabled" 
                    @endif
                >
                    <i class="fa fa-btn fa-caret-left"></i>
                    Prev
                </a>
            <a
                href="{{ url($browse->upDir) }}"
                type="button"
                class="btn btn-default"
            >
                <i class="fa-btn">..</i>
                Back
            </a>
            <a
                href="{{ $browse->item->download }}"
                type="button"
                class="btn btn-default"
            >
                <i class="fa fa-btn fa-download"></i>
                Download
            </a>
                <a
                    @if ($browse->nextItem)
                        title="{{ $browse->nextItem->name }}"
                        href="{{ url($browse->nextItem->url) }}"
                        class="btn btn-default" 
                    @else
                        class="btn btn-default disabled" 
                    @endif
                >
                    <span class="fa-btn">Next</span>
                    <i class="fa fa-caret-right"></i>
                </a>
        </div>

        <hr>

        <div class="text-center">
            <div class="file-preview">
                @include('index.file.view')
            </div>
        </div>

        <hr>
            
    </div>
</div>