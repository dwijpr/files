<?php
    $crudActionFormID = "crud-action-form-{$object->id}";
?>

<div class="btn-group" role="group" aria-label="Action">
    <button
        type="submit"
        class="btn btn-default"
        title="Delete"
        id="{{ $crudActionFormID }}-button"
        data-form="{{ $crudActionFormID }}"
    >
        <i class="fa fa-trash"></i>
    </button>
    <a href="{{ url(
        $___classAttrs->backend.$___classAttrs->single.'/'.$object->id
    ) }}" class="btn btn-default">
        <i class="fa fa-edit"></i>
    </a>
    <a href="{{ url(
        $___classAttrs->backend.$___classAttrs->plural.'/'.$object->id
    ) }}" class="btn btn-default">
        <i class="fa fa-eye"></i>
    </a>
</div>

{!! Form::open([
    'url' => $___classAttrs->backend.$___classAttrs->single.'/'.$object->id,
    'id' => $crudActionFormID,
    'method' => 'delete',
]) !!}
{!! Form::close() !!}

<script>
    $("#{{ $crudActionFormID }}-button").click(function(){
        var b = confirm("Are You sure?");
        if(b){
            var id = "#"+$(this).data('form');
            console.log(id);
            $(id).submit();
        }
    });
</script>