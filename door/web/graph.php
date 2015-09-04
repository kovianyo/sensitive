<?php

// TODO: css

class Graph
{
  function Render($rows)
  {
    $result = "";
    $maxcount = 0;

    foreach ($rows as $row) { if ($row["count"] > $maxcount) $maxcount = $row["count"];  }

    $result .= "<style>.oszlop {width: 4.16%;} .firstRow {height: 20px;}  .columnsRow {height: 200px;} .thirdRow {height: 20px;}</style>";
    $result .= "<style>.oszlop2 {background-color: LightBlue; width: 100%; height: 100%; border: 1px solid black;} </style>";
    $result .= '<div style="width:800px; border: 1px solid black; padding: 4px;">';

    $result .= '<div class="firstRow" style="width:100%; margin-bottom: 5px;">';
    foreach ($rows as $row)
      {
        $result .= '<div class="oszlop" style="float:left; text-align: center;">' . $row["count"] . '</div>';
      }
    $result .= '</div>';


    $result .= '<div class="columnsRow" style="width:100%; margin-bottom: 6px;">';
    foreach ($rows as $row)
      {
        $height = (1 - $row["count"] / $maxcount) * 100;
        $result .= '<div class="oszlop" style="height:100%; float:left; margin-top:0px; margin-bottom:0px;">';
        $result .= '<div style="margin-left:2px; margin-right:4px; margin-top:0px; margin-bottom:0px;">';
        $result .= '<div style="background-color: white; height: ' . $height . '%; width: 100%;"></div>';
        $result .= '<div style="height: ' . (100 - $height) . '%; width: 100%;">';
        $result .= '<div class="oszlop2"></div>';
        $result .= '</div>';
        $result .= '</div>';
        $result .= '</div>';
      }
    $result .= '</div>';


    $result .= '<div class="thirdRow" style="width:100%; margin-bottom: 5px;">';
    foreach ($rows as $row)
      {
        $result .= '<div class="oszlop" style="float:left; text-align: center;">' . $row["hour"] . '</div>';
      }
    $result .= '</div>';

    $result .= '</div>';

    return $result;
  }

}

function QueryStat($mysqli, $filter = null)
{
  $q1 = "select orak.id - 1 as hour, CASE WHEN sum(state) IS NULL THEN 0 ELSE sum(state) END as count from orak LEFT JOIN log ON HOUR(date) = (orak.id - 1)";
  $q2 = " GROUP BY orak.id";
  $c = "";

  if ($filter == "weekdays")
    {
      $c = " AND (DAYOFWEEK(date) NOT IN (1,7))";
      $weekdays = $mysqli->query($q1 . $c . $q2);
      return $weekdays;
    }

  if ($filter == "weekend")
    {
      $c = " AND (DAYOFWEEK(date) IN (1,7))";
      $weekend = $mysqli->query($q1 . $c . $q2);
      return $weekend;
    }

  $res = $mysqli->query($q1 . $c . $q2);
  return $res;
}


function QueryStatSimple($mysqli, $filter = null)
{
  $select = "select (orak.id - 1) as hour, count(*) as count from orak LEFT JOIN log ON HOUR(date) = (orak.id - 1) ";
  $where = "";
  $groupby = " GROUP BY hour";

  if ($filter == "weekdays")
    {
      $where = " WHERE DAYOFWEEK(date) NOT IN (1,7)";
    }

  if ($filter == "weekend")
    {
      $where = " WHERE DAYOFWEEK(date) IN (1,7)";
    }


  $res = $mysqli->query($select . $where . $groupby);
  return $res;
}

function FillUntil($rows, $indexColumn, $until)
{

  $result = array();
  for ($i = 0; $i <= $until; $i++)
    {
      $found = false;
      foreach ($rows as $row) 
	{ 
	  if ($row[$indexColumn] == $i) { array_push($result, $row); $found = true; }
	}
      if (!$found)
	{
	  $newRow = array();
	  $newRow[$indexColumn] = $i;
	  $newRow["count"] = 0;
	  array_push($result, $newRow);
	}

    }

  return $result;
}

function SecondToTime($seconds)
{
  $hours = floor($seconds / 3600);
  $mins = floor(($seconds - ($hours*3600)) / 60);
  return $hours . ":" . (($mins < 10)? "0" : "") .  $mins;
}


function RenderNap($mysqli, $nap = 0)
{

  $markCurrentTime = $nap == 0;
  $markCurrentTime = false;

  $date = date('Y-m-d');
  $time = strtotime($date . ' - ' . $nap . ' days');
  echo "<div>". date('Y-m-d l', $time) ."</div>";
  $ma = $mysqli->query("SELECT TIME_TO_SEC(date) as sec FROM log WHERE (DATE(date) = SUBDATE(DATE(NOW()), INTERVAL " . $nap . " DAY)) AND state = 1;");


  $last = 0;
  $intervals = array();
  foreach ($ma as $row)
    {
      $item = array();
      $item["start"] = $last;
      $item["end"] = $row["sec"];
      array_push($intervals, $item);
      $last = $row["sec"];
    }

  if ($markCurrentTime)
    {
      $currentSeconds = date("G")*60*60 + date("i")*60 + date("s");
      echo $currentSeconds;
      $item = array();
      $item["start"] = $last;
      $item["end"] = $currentSeconds;
      array_push($intervals, $item);
    }


  echo "<div style='width:100%; height:40px; border:1px solid darkgreen; background-color: rgb(234, 250, 234); margin-top:5px; margin-bottom:5px;'>";
  $title = "";
  foreach ($intervals as $item)
    { 
      $title = SecondToTime($item["end"]);
      echo '<div style="float:left; width:'. ($item["end"] - $item["start"]) * 100 / (60*60*24) .'%; height:100%;" title="' . $title . '">';
      echo '<div style="width:100%; height:100%; border-right:1px solid black; overflow:hidden;">';
      echo '<div style="text-align:right; padding-right: 8px; padding-top: 8px; float:right;">' . $title . '</div>';
      echo '</div>';
      echo '</div>';
    }
  //<div style='float:left; width:20%; height:100%; border:1px solid black;'></div><div style='float:left;'></div>
  echo "</div>";
  // border-right:1px solid black;

  $dow = date('N', $time);
  if ($dow == 1 || $dow == 6) echo '<div style="width:100%; border-bottom:'. ($dow == 6 ? 1 : 2) . 'px solid black;margin-bottom: 4px; padding-top: 2px;"></div>';
}

function RenderTimeTable()
{
  // vonalak
  echo "<div style='width:100%; height:10px; border-top:1px solid black; border-left:1px solid black; border-right:1px solid black;'>";
  for ($i=0; $i<23; $i++) echo "<div style='float:left; height:100%; width:". (100/24) ."%;'><div style='width:100%; height:100%; border-right:1px solid black;'></div></div>";
  echo "</div>";
  
  // órák
  echo "<div style='width:100%; margin-top:2px; margin-bottom:2px;'>";
  echo "<div style='float:left; width:" . (100/48) . "%;'>0:00</div>";
  for ($i=0; $i<23; $i++) echo "<div style='float:left; width:". (100/24) ."%; text-align:center'>" . ($i+1) .":00</div>";
  echo "<div style='float:left; width:" . (100/48) . "%; text-align: right;'>24:00</div>";
  echo "</div>";

  echo "<div style='clear:both; margin-bottom:10px;'></div>";
}

echo "<html><head><title>Kovi ajto log graph</title>";
//echo "<style>table, th, td { border: 1px solid black; } th, td { padding: 4px; } </style>";
echo '<meta charset="UTF-8" />';
echo "</head><body><h1>Ajto log graph</h1>"; 

$mysqli = new mysqli("localhost", "kovi", "", "ajto");
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//echo $mysqli->host_info . "\n";

echo "<div style='padding-bottom:10px;'><a href='?'>[hours]</a> <a href='?type=daily'>[days]</a></div>";

if (isset($_GET["type"]) && $_GET["type"] == "daily")
  {
    echo '<div style="margin-left:10px; margin-right:20px;">';
    RenderTimeTable();
    $dayLimit = 14;
    for ($i = 0; $i < $dayLimit; $i++)
      {
	RenderNap($mysqli, $i);
      }
    echo '</div>';
  }
else
  {

    $all = QueryStatSimple($mysqli);
    $weekdays = QueryStatSimple($mysqli, "weekdays");
    $weekend = QueryStatSimple($mysqli, "weekend");

    $weekdays = FillUntil($weekdays, "hour", 23);
    $weekend = FillUntil($weekend, "hour", 23);

    $graph = new Graph();

    echo "<h2>Minden nap</h2>";
    echo $graph->Render($all);

    echo "<h2>Hétköznap</h2>";
    echo $graph->Render($weekdays);

    echo "<h2>Hétvége</h2>";
    echo $graph->Render($weekend);

    echo "</body></html>";
  }

?>
