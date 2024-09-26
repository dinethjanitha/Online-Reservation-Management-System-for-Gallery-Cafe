<?php

function check_req_field($req_fields)
{

    $errors = array();

    foreach ($req_fields as $req_field) {
        if (empty(trim($_POST[$req_field]))) {
            $errors[] = $req_field . " is Empty";
        }
    }



    return $errors;
}

function min_len_check($max_len)
{
    $errors = array();

    foreach ($max_len as $field => $len) {
        if (trim(strlen($_POST[$field])) < $len) {
            $errors[] = $field . " minimum required " . $len . " characters";
        }
    }

    return $errors;
}

function query_check($result)
{
    if (!$result) {
        die("Query Fiald! " . mysqli_errno($result));
        // die("Errorrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr");
    }
}


function displayErrors($error)
{

    if (!empty($error)) {
        echo "<h3>Errors</h3>";
        echo "<ul>";
        foreach ($error as $er) {
            echo "<li>" . ucfirst(str_replace("_", " ", $er)) . "</li>";
        }
        echo "</ul>";
    }
}


function reserveTables($numGuests, $tables)
{
    // Sort tables by capacity in descending order
    $selectedTables = [];
    $remainingGuests = $numGuests;

    usort($tables, function ($a, $b) {
        return $a['table_capacity'] - $b['table_capacity'];
    });



    $arrCopy = array_merge([], $tables);

    $i = 0;
    $min = 0;

    while ($remainingGuests > 0) {
        if (empty($arrCopy)) {
            // echo "Got Break";
            break;
        }

        for ($b = 0; $b < count($arrCopy); $b++) {
            // echo "In arr <br>";
            if (empty($arrCopy)) {
                echo "Got Break";
                break;
            }
            // echo "Arr value is: " .  $arrCopy[$b]['table_capacity'] . "<br>";
            if ($remainingGuests <= $arrCopy[$b]['table_capacity']) {
                $min = $b;
                // echo "AB min is: " . $min . "<br>";
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
    }


    if ($remainingGuests > 0 && empty($arrCopy)) {
        return -1;
    } else {
        return $selectedTables;
    }
}

function email_validation($email)
{
    $errors = array();
    if (!preg_match(

        "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",
        $email
    )) {
        $errors[] = "Invalied Email";
    }

    return $errors;
}
