<?php

$mysqli = new mysqli("localhost", "kovi", "", "ajto");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


echo "Date,Temperature,Fridge,Balcon\n";

$rows = $mysqli->query("SELECT * FROM temperature WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)-- WHERE value > 0 AND value1 > 0");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["value"] . "," . $row["value1"] . "," . $row["value2"] . "\n";
    }


?>
