<?php

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
