<?php
    if (!is_array($field)) {
        $return = $object->$field;
    }
    if (!is_numeric($key)) {
        if (is_array($field)) {
            if (@$field['jsonview']) {
?>
                <div
                    class="jsonview"
                    data-json="{{ $object->$key }}"
                ></div>
<?php
            } elseif (@$field['uaparse']) {
?>
                <div
                >
                    {{ implode(' ', parse_user_agent($object->$key)) }}
                </div>
<?php
            }
        } else {
            $return = "-";
            if (count($object->$key) > 0) {
                $return = "";
                foreach ($object->$key as $_object) {
                    $return .= "<div>";
                    $return .= $_object->$field;
                    $return .= "</div>";
                }
            }
            echo $return;
        }
    } else {
        echo e($return);
    }
?>
