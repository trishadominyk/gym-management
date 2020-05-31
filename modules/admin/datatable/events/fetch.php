<?php
try {
	include('../db.php');
    
	// Connect to database
    //$connection = new PDO($url, $username, $password);

    // Prepare and execute query
    $query = "SELECT * FROM tbl_event";
    $sth = $connection->prepare($query);
    $sth->execute();

    // Returning array
    $events = array();

    // Fetch results
    while ($row = $sth->fetch(PDO::FETCH_ASSOC) {

        $e = array();
        $e['id'] = $row['evn_id'];
        $e['name'] = $row['evn_name'];
        $e['start'] = $row['evn_date_start'];
        $e['end'] = $row['evn_date_end'];
        $e['allDay'] = $row['evn_allday'];

        // Merge the event array into the return array
        array_push($events, $e);

    }

    // Output json for our calendar
    echo json_encode($events);
    exit();

} catch (PDOException $e){
    echo $e->getMessage();
}