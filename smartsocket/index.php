<?php

echo '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:;base64,=">
    <title>SmartSocket</title>
  </head>
  <body>
    <h1>SmartSocket</h1>
     <form method="post">
        <input type="submit" name="command" value="on">
        <input type="submit" name="command" value="off">
    </form>
  </body>
</html>';

if ($_POST["command"] != "")
{
  echo $_POST["command"];

  $url = 'http://192.168.1.108/' . $_POST["command"];

  // exit;

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => ""
    )
);

  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
  // if ($result === FALSE) { echo "error";  /* Handle error */ }

  // var_dump($result);

}
?>
