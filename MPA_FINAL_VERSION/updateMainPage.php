<?php

try {

    // establish connection to server
    $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");
    $query = "SELECT * FROM Polls ORDER BY created_dt DESC LIMIT 5";
    $result = $db->query($query);

    // JSON encode
    $array = [];
    while($row = $result->fetch()) {
        // Get matching polls for the current user.
        $array[] = $row;        
    }
    
    // Send back JSON object
    echo json_encode($array);

    $db = null;
}catch (PDOException $e) {
    echo "PDO Error: " . $e->getMessage() . "\n<br />";
}

?>
