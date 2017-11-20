<?php

session_start();

if ($_POST["username"] == "<username>" && $_POST["password"] == "<username>")
{
	$_SESSION["username"] = "<username>";
	
	header('Location: index.php');
	exit();
}

if ($_POST["logout"] == "Logout")
{
	unset($_SESSION["username"]);
}

// var_dump($_POST);

echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="yellow">
    <title>Kovi light switch</title>
    <link rel="manifest" href="/light/manifest.json">
    <!--<link rel="stylesheet" href="style.css"> -->
    <!--<script src="script.js"></script>-->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
  </head>
  <body>
    <h1>Kovi light switch</h1>
    <form method="post">';

if ($_SESSION["username"] == "<username>")
{
	echo '<input type="submit" value="Logout" name="logout">';
}
else 
{
	if (isset($_POST["username"]))
	{
		echo '<div>Login error!</div>';
	}

echo'
	<table>
		<tr><td>Username:</td><td><input type="text" name="username" /></td></tr>
		<tr><td>Password</td><td><input type="password" name="password" /></td></tr>
		<tr><td><input type="submit" value="Login" /></td></tr>
	</table>';
}
echo '
    </form>
  </body>
</html>
';

//var_dump($_SESSION);

?>
