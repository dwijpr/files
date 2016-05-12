<?php
    $preview = preview_mime_type($browse->item->mimeType);
    switch (head($preview)) {
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
        case 'text':
?>
            <div style="position: relative;">
                <style>
                    #text-editor {
                        position: absolute;
                        top: 0;
                        right: 0;
                        bottom: 0;
                        left: 0;
                        min-height: 256px;
                    }
                </style>
                <pre id="text-editor">{{ $browse->item->get() }}</pre>
<?php
                if (!function_exists('ace_editor_map_ext')) {
                    function ace_editor_map_ext($type) {
                        $maps = [
                            'x-php' => 'php',
                        ];
                        return @$maps[$type]?:$type;
                    }
                }
?>
                <script>
                    $(function(){
                        var editor = ace.edit("text-editor");
                        editor.setReadOnly(true);
                        editor.setTheme("ace/theme/monokai");
                        editor.getSession().setMode("ace/mode/{{
                            ace_editor_map_ext(last($preview))
                        }}");
                    });
                </script>
            </div>
<?php
            break;
        
        default:
?>
            <h1>No Preview Available ... :(</h1>
<?php
            break;
    }
?>