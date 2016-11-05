<?php
	session_start();

	include 'openDb.php';
	
    $key=$_GET['key'];
    $array = array();
	
    $result = dbConnect()->prepare("SELECT * FROM event
												WHERE e_name LIKE '%{$key}%'");
				$result->execute();
    while($rows = $result->fetch())
    {
      $array[] = $rows['e_name'];
    }
    echo json_encode($array);
?>
