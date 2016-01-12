<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8' />
<style type="text/css">
<!--
.chat_wrapper {
	width: 500px;
	margin-right: auto;
	margin-left: auto;
	background: #C0C0C0;
	border: 1px solid #999999;
	padding: 0px;
	font: 12px 'verdana';
}
.chat_wrapper .message_box {
	background: #FFFFFF;
	height: 200px;
	overflow: auto;
	padding: 10px;
	border: 1px solid #999999;
}
.chat_wrapper .panel input{
	padding: 2px 2px 2px 5px;
}
.system_msg{color: #BDBDBD;font-style: italic;}
.user_name{font-weight:bold;}
.user_message{color: #000000;}
-->
</style>
</head>
<body>

<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

$user = $_SESSION["username"];
$colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($colours); 

	if(isset($user)){
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script language="javascript" type="text/javascript">  
$(document).ready(function(){
	var wsUri = "ws://localhost:1313/hawtalk/login/server.php"; //neues WebSocket Objekt
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) { 	//Verbindung herstellen und User informieren
		$('#message_box').append("<div class=\"system_msg\">You've been connected</div>"); 
	}

	$('#send-btn').click(function(){ //Drücken des Sendbuttons	
		var mymessage = $('#message').val(); //Nachricht speichern
		var myname = '<?php echo $user; ?>' //Namen aus der PHP nehmen
		
		if(mymessage == ""){ //leere Nachricht?
			alert("Enter a message Please!");
			return;
		}
		
		//Json Daten vorbereiten
		var msg = {
		message: mymessage,
		name: myname,
		color : '<?php echo $colours[$user_colour]; ?>'
		};
		//konvertieren und schicken
		websocket.send(JSON.stringify(msg));
	});
	
	//Nachricht vom Server empfangen?
	websocket.onmessage = function(ev) {
		var msg = JSON.parse(ev.data);
		var type = msg.type; 
		var umsg = msg.message; 
		var uname = msg.name; 
		var ucolor = msg.color; 

		if(type == 'usermsg') 
		{
			$('#message_box').append("<div><span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");
		}
		if(type == 'system')
		{
			$('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
		}
		
		$('#message').val(''); //reset text
	};
	
	websocket.onerror	= function(ev){$('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");}; 
	websocket.onclose 	= function(ev){$('#message_box').append("<div class=\"system_msg\">Connection Closed</div>");}; 
});
</script>

<?php
	}
	else{
		header("index.php"); 
	}
?>

<div class="chat_wrapper">
<div class="message_box" id="message_box"></div>
<div class="panel">
<input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:87%" />
<button id="send-btn">Send</button>
</div>
</div>

</body>
</html>

<!-- Großer Dank an Saran Chamling (http://www.sanwebe.com/2013/05/chat-using-websocket-php-socket), 
ohne dessen Tutorium ich den Chat mit PHP nicht hinbekommen hätte-->
