<?php

function reserveTables($numGuests, $tables)
{
    // Sort tables by capacity in descending order
    usort($tables, function ($a, $b) {
        return $b['table_capacity'] - $a['table_capacity'];
    });

    $n = count($tables);
    $dp = array_fill(0, $numGuests + 1, PHP_INT_MAX);
    $dp[0] = 0;
    $selectedTables = array_fill(0, $numGuests + 1, []);

    for ($i = 0; $i < $n; $i++) {
        $capacity = $tables[$i]['table_capacity'];
        for ($j = $numGuests; $j >= $capacity; $j--) {
            if ($dp[$j - $capacity] != PHP_INT_MAX && $dp[$j - $capacity] + 1 < $dp[$j]) {
                $dp[$j] = $dp[$j - $capacity] + 1;
                $selectedTables[$j] = $selectedTables[$j - $capacity];
                $selectedTables[$j][] = $tables[$i];
            }
        }
    }

    if ($dp[$numGuests] == PHP_INT_MAX) {
        return "Not enough capacity to accommodate all guests.";
    }

    return $selectedTables[$numGuests];
}

// Example usage
$tables = [
    ["table_id" => 1, "table_name" => "A", "table_capacity" => 4],
    ["table_id" => 2, "table_name" => "B", "table_capacity" => 6],
    ["table_id" => 3, "table_name" => "C", "table_capacity" => 2],
    ["table_id" => 4, "table_name" => "D", "table_capacity" => 8],
];

// Test with a single number of guests
$numGuests = 19;
$reservedTables = reserveTables($numGuests, $tables);

echo "For $numGuests guests:\n";
if (is_string($reservedTables)) {
    echo $reservedTables . "\n";
} else {
    foreach ($reservedTables as $table) {
        echo "Reserved Table: " . $table['table_name'] . " (Capacity: " . $table['table_capacity'] . ")\n";
    }
}
