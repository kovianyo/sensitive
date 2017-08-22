<?php

// CREATE TABLE power(id INT NOT NULL AUTO_INCREMENT KEY, 
// power DOUBLE NULL, 
// voltage DOUBLE NULL, 
// current DOUBLE NULL, 
// energy DOUBLE NULL, 
// date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP);

$mysqli = new mysqli("localhost", "kovi", "", "ajto");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

if ($_GET["type"] == "power")
{
  echo "Date,Power\n";

  $rows = $mysqli->query("SELECT date, power FROM power WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["power"] . "\n";
    }
}


if ($_GET["type"] == "voltage")
{
  echo "Date,Voltage\n";

  $rows = $mysqli->query("SELECT date, voltage FROM power WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["voltage"] . "\n";
    }
}

if ($_GET["type"] == "current")
{
  echo "Date,Current\n";

  $rows = $mysqli->query("SELECT date, current FROM power WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["current"] . "\n";
    }
}

if ($_GET["type"] == "energy")
{
  echo "Date,Energy\n";

  $rows = $mysqli->query("SELECT date, energy FROM power WHERE date > DATE_SUB(NOW(), INTERVAL 5 DAY)");

  foreach ($rows as $row)
    {
      echo $row["date"] . "," . $row["energy"] . "\n";
    }
}

?>
