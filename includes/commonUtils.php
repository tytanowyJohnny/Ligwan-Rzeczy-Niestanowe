<?php


function searchIn2DimArray($array, $field, $value)
{
    foreach ($array as $key => $item) {
        if ($item[$field] === $value)
            return $key;
    }
    return false;
}

function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function parseInputForJSON($inputString) {
    return trim(preg_replace('/\s\s+/', ' ', $inputString));
}


?>