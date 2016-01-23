<?php
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

<!-- Großer Dank an Saran Chamling (http://www.sanwebe.com/2013/05/chat-using-websocket-php-socket), 
ohne dessen Tutorium ich den Chat mit PHP nicht hinbekommen hätte-->

<!--
=== Feedback Alpers, Jan 19 ===

Und genau hier liegt das Problem: Es ist mit den einfachen Mitteln, die Sie in der Veranstaltung kennen gelernt
haben möglich, einen Chat zu realisieren. Der mag dann nicht so komfortabel sein, wie die Arbeit mit Sockets, aber
was Sie hier gemacht haben ist genau das, was Sie nicht tun sollten: Sie haben eine fremde Lösung adaptiert, um
eine selbstgestellte Aufgabe zu lösen.

Deshalb hier nochmal das Ziel des Projekts: Es geht nicht darum, dass Ihr Projekt (perfekt) funktioniert, sondern
darum, dass Sie mit beschränkten Mitteln als Teammitglied einen eigenen Anteil zum Projekt beitragen.

Das Arbeiten mit Bibliotheken gehört dagegen zu den Methoden, die Sie später nutzen werden. 

=== Feedback Alpers, Ende ===
-->
