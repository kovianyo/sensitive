<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
<meta charset="UTF-8" />
<title>Current temperatures</title>
</head>
<body>
<h1>Current temperatures</h1>
<?php

$mysqli = new mysqli("localhost", "kovi", "", "ajto");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}


$rows = $mysqli->query("SELECT date, value, value1, value2, value3 FROM temperature ORDER BY id DESC LIMIT 1");

 foreach ($rows as $row)
    {
      echo "<table>\n";
      echo "<tr><td>Room:</td><td>" . $row["value"] . " °C</td></tr>\n";
      echo "<tr><td>Fridge:</td><td>" . $row["value1"] . " °C</td></tr>\n";
      echo "<tr><td>Balcon:</td><td>" . $row["value2"] . " °C</td></tr>\n";
      echo "<tr><td>Proc:</td><td>" . $row["value3"] . " °C</td></tr>\n";
      echo "</table>\n";
    }

?>
</body>
</html>

