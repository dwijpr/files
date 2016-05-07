<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">{{$label}}</label>

    <div class="col-md-6">
        <?php
            $type = @$type?:'text';
        ?>
        <?php
            switch ($type) {
                case 'select':
                    echo Form::{$type}(
                        $name
                        , objectsToArrayKeyValue($hasManyObjects, 'id', 'name')
                        , objectsToArray(@$object->{$___classAttrs->hasMany}, 'id')
                        , [
                            'class' => 'form-control',
                            'readonly' => @$readonly,
                            'multiple' => @$multiple,
                        ]
                    );
                    break;
                case 'password':
                    echo Form::{$type}($name, [
                        'class' => 'form-control',
                        'readonly' => @$readonly,
                    ]);
                    break;
                default:
                    echo Form::{$type}($name, (@$value?:""), [
                        'class' => 'form-control',
                        'readonly' => @$readonly,
                    ]);
                    break;
            }
        ?>
        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>
