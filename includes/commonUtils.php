<?php


function searchIn2DimArray($array, $field, $value)
{
    foreach ($array as $key => $item) {
        if ($item[$field] === $value)
            return $key;
    }
    return false;
}


?>