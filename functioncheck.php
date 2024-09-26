<?php

function roundToGreatest($number)
{

    $intPart = floor($number);

    if ($number == $intPart) {
        return $intPart;
    }
    return $intPart + 1;
}

// Example usage
$number = 5.1;
$roundedNumber = roundToGreatest($number);

echo "$number rounded to the nearest greatest value is: $roundedNumber";
