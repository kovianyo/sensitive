<?php

$mysqli = new mysqli("localhost", "kovi", "", "ajto");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if ($_GET["type"] == "room")
{
  echo "Date,Room,Balcon\n";

  $rows = $mysqli->query("SELECT date, value, value2 FROM temperature WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)-- WHERE value > 0 AND value1 > 0");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["value"] . "," . $row["value2"] . "\n";
    }
}


if ($_GET["type"] == "fridge")
{
  echo "Date,Fridge\n";

  $rows = $mysqli->query("SELECT date, value1 FROM temperature WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)-- WHERE value > 0 AND value1 > 0");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["value1"] . "\n";
    }
}

if ($_GET["type"] == "proc")
{
  echo "Date,Proc\n";

  $rows = $mysqli->query("SELECT date, value3 FROM temperature WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)-- WHERE value > 0 AND value1 > 0");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["value3"] . "\n";
    }
}


?>
