<?php

session_start();

if (!isset($_SESSION["username"]))
{
	header('HTTP/1.0 401 Unauthorized');
	exit();
}

if (isset($_POST["state"]))
{
	if ($_POST["state"] == "0")
	{
		shell_exec("/usr/bin/gpio -g write 7 1");
	}

	if ($_POST["state"] == "1")
	{
		shell_exec("/usr/bin/gpio -g write 7 0");
	}
}

$state = trim(shell_exec("/usr/bin/gpio -g read 7"));
if ($state == "0")
{
	echo "1";
}
else
{
	echo "0";
}

?>
