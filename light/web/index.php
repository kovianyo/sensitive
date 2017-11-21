<?php

// sudo apt-get install wiringpi

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </head>
  <body>
    <h1>Kovi light switch</h1>
    <div id="state" style="margin: 5px; background-color: grey; padding: 10px; cursor: pointer;">unknown</div>
<script type="text/javascript">

function updateState(state){
	$("#state")
	.attr("data-state", state)
	.text(state == "0" ? "off" : "on")
	.css("background-color", state == "0" ? "green" : "red");
}

function onError(jqXHR, textStatus, errorThrown){
	// console.log(textStatus);
	// console.log(errorThrown);
	
	if (textStatus == "error" && errorThrown == "Unauthorized") {
		window.location.href = "auth.php";
	}

}

function getState(){
	$.ajax({ url: "switch.php", error: onError })
	.done(function( result ) { 
		console.log(result); 
		updateState(result); 
	}); 
}

function setState(state){
$.ajax({
  url: "switch.php",
method: "POST",
data: { "state": state }
})
  .done(function( result ) {
    console.log(result);
    updateState(result); 
  });
}

function stateClick(element){
	var originalState = $("#state").attr("data-state");
	$("#state").text("updating...").css("background-color", "lightgray");
	if (originalState == "0") { setState("1"); } else {setState("0");}
}



$(function(){ 
	$("#state").click(function(){ stateClick(); });
	getState();  

	$(window).focus(function(){ getState(); });
});
</script>
';

echo date('m/d/Y h:i:s a', time());

echo '
  </body>
</html>';

?>
