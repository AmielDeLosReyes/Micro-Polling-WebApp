<?php

    try {
        
        // Establish Database Connection
        $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");
        $answerId = $_POST['answerId'];
        $voteDt = date("Y-m-d");
        
        $query = "INSERT INTO Votes (answer_id, vote_dt) VALUES ('$answerId', '$voteDt')";
        $result = $db->exec($query);
        
        $query = "SELECT COUNT(*) as vote_count FROM Votes WHERE answer_id = '$answerId'";                 
        $result = $db->query($query, PDO::FETCH_ASSOC);

        $array = [];
        $row = $result->fetch();
        $array[] = $row;
        
        // JSON object
        echo json_encode($array[0]);
    }catch(PDOException $e) {
        echo "PDO Error: " . $e->getMessage() . "\n<br />";
    }

?>