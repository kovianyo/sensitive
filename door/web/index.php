<?php

function createRow($row)
{
	$result = "";
	foreach ($row as $key=>$val)
	{
		$result .= "<td>" . $val . "</td>";
	}
	
	return $result;
}

echo "<html><head><title>Kovi ajto log</title>";
echo "<style>table, th, td { border: 1px solid black; } th, td { padding: 4px; } </style>";
echo "</head><body><h1>Ajto log</h1>"; 

$mysqli = new mysqli("localhost", "kovi", "", "ajto");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//echo $mysqli->host_info . "\n";
$minimumRowCount = 20;
$res = $mysqli->query("SELECT * FROM log WHERE (DATE(NOW()) = DATE(date)) OR ((SELECT id FROM log ORDER BY id DESC LIMIT 1) - id < ".$minimumRowCount.") ORDER BY id DESC");

//print_r($res);

$rows = array();

while ($row = $res->fetch_assoc()) {
    array_push($rows, $row);
}

if (count($rows) > 0)
{
	$first = $rows[0];
	if ($first['state'] == "0") 
	{
		$text = "csukva";
		$color = "greenyellow";
	}
	else if ($first['state'] == "1") 
	{	
		$color = "orangered";
		$text = "nyitva";
	}
	echo "<div style='padding-bottom: 14px;'>";
	echo "<span style='padding:4px; border:1px solid black; background-color:". $color .";'>" . $text . "</span>";
	echo "</div>";
}

echo "<table style='background-color: aliceblue; border-collapse: collapse;'>";
echo "<tr><th>id</th><th>state</th><th>date</th></tr>";

foreach ($rows as $row) {
    echo "<tr>" . createRow($row) . "</tr>";
}

echo "</table>";


echo "</body></html>";

?>
