<?php
    switch (simple_file_type($browse->item->mimeType)) {
        case 'video':
?>
            <video controls>
                <source
                    src="{{ $browse->item->src }}"
                    type="{{ $browse->item->mimeType }}"
                >
                Your browser does not support the preview ... :(
            </video>
<?php
            break;
        
        default:
?>
            <h1>No Preview Available ... :(</h1>
<?php
            break;
    }
?>