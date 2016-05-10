<?php
    switch (simple_file_type($item->type)) {
        case 'video':
?>
            <video controls>
                <source src="{{ $item->url }}" type="{{ $item->type }}">
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