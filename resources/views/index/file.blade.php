<div class="row">
    <div class="col-md-3">

        @include('index.file.info')

    </div>
    <div class="col-md-9">
        <div>
            <div class="btn-group" role="group" aria-label="...">
                <a
                    href="{{ url($browse->upDir) }}"
                    type="button"
                    class="btn btn-default"
                >
                    Back
                </a>
                <a
                    href="{{ $browse->item->download }}"
                    type="button"
                    class="btn btn-default"
                >
                    Download
                </a>
            </div>
        </div>
        <hr>

        @include('index.file.view')
            
    </div>
</div>