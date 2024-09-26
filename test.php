<?php
function reserveTables($numGuests, $tables)
{
    // Sort tables by capacity in descending order
    $selectedTables = [];
    $remainingGuests = $numGuests;

    usort($tables, function ($a, $b) {
        return $a['table_capacity'] - $b['table_capacity'];
    });

    echo "<pre>";
    print_r($tables);
    echo "</pre>";

    $arrCopy = array_merge([], $tables);

    $i = 0;
    $min = 0;

    while ($remainingGuests > 0) {
        if (empty($arrCopy)) {
            echo "Got Break";
            break;
        }

        for ($b = 0; $b < count($arrCopy); $b++) {
            echo "In arr <br>";
            if (empty($arrCopy)) {
                echo "Got Break";
                break;
            }
            echo "Arr value is: " .  $arrCopy[$b]['table_capacity'] . "<br>";
            if ($remainingGuests <= $arrCopy[$b]['table_capacity']) {
                $min = $b;
                echo "AB min is: " . $min . "<br>";
                $remainingGuests -= $arrCopy[$min]['table_capacity'];
                $selectedTables[] = $arrCopy[$min];
                unset($arrCopy[$min]);
            }

            if ($remainingGuests <= 0) {
                break;
            }
        }

        if ($remainingGuests <= 0) {
            break;
        }

        $min = count($arrCopy) - 1;
        $remainingGuests -= $arrCopy[$min]['table_capacity'];
        $selectedTables[] = $arrCopy[$min];
        unset($arrCopy[$min]);

        // echo "<pre>";
        // print_r($selectedTables);
        // echo "</pre>";

        // echo "*****************************";
    }

    // echo "<pre>";
    // print_r($arrCopy);
    // echo "</pre>";

    // echo "----------------------------";

    // echo "<pre>";
    // print_r($selectedTables);
    // echo "</pre>";





    // echo $selectedTables;
    if ($remainingGuests > 0 && empty($arrCopy)) {
        return "Not enough capacity to accommodate all guests.";
    } else {
        return $selectedTables;
    }

    // return $selectedTables;
}

// Example usage
$tables = [
    ["table_id" => 1, "table_name" => "A", "table_capacity" => 4],
    ["table_id" => 2, "table_name" => "B", "table_capacity" => 6],
    ["table_id" => 3, "table_name" => "C", "table_capacity" => 2],
    ["table_id" => 4, "table_name" => "D", "table_capacity" => 8],
];

$numGuests = 19;
$reservedTables = reserveTables($numGuests, $tables);

if (is_string($reservedTables)) {
    echo $reservedTables;
} else {
    foreach ($reservedTables as $table) {
        echo "Reserved Table: " . $table['table_name'] . " (Capacity: " . $table['table_capacity'] . ")\n";
    }
}
