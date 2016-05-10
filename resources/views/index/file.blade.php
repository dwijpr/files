<div class="row">
    <div class="col-md-3">

        @include('index.file.info')

    </div>
    <div class="col-md-9">
        <div>
            <div class="btn-group" role="group" aria-label="...">
                <a
                    href="{{ url('browse/'.$browse->upDir) }}"
                    type="button"
                    class="btn btn-default"
                >
                    Back
                </a>
                <button type="button" class="btn btn-default">
                    Download
                </button>
            </div>
        </div>
        <hr>

        @include('index.file.view')

    </div>
</div>