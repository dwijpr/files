{!! Form::open([
    'url' => $___classAttrs->backend.(@$url?:$___classAttrs->single),
    'method' => @$method?:'post',
    'class' => 'form-horizontal',
    'role' => 'form',
]) !!}
    
    @foreach ($___classAttrs->model::toBeFilledFields() as $field => $value)
        <?php
            $data = [
                'name' => $field,
                'label' => ucwords($field),
            ];
            switch ($value) {
                case 'multiple':
                    $data['name'] .= '[]';
                    $data['type'] = 'select';
                    $data['multiple'] = true;
                    break;
                case 'password':
                    $data['type'] = 'password';
                    break;
                default:
                    $data['value'] = @$object->{$field};
                    break;
            }
        ?>
        @include('partials.div_form_group', $data)
    @endforeach

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            @if (!@$readonly)
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-user"></i>
                    {{ @$submitLabel?:'Create' }}
                </button>
            @else
                <a href="{{ url(
                    $___classAttrs->backend.$___classAttrs->single.'/'.$object->id
                ) }}" class="btn btn-info">
                    <i class="fa fa-btn fa-edit"></i>
                    Edit
                </a>
            @endif
        </div>
    </div>

{!! Form::close() !!}
