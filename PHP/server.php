<?php
$host = 'localhost';
$port = '1313';
$null = NULL;

//TCP/IP Stream Socket erzeugen
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//wiederverwendbarer Port
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

//Socket auf Host binden
socket_bind($socket, 0, $port);

//auf Port hören
socket_listen($socket);

$clients = array($socket);

//Herstellen einer Endlosschleife
while (true) {
	//mehrere Verbindungen möglich machen
	$changed = $clients;
	//Socket resources ind $changed array zurückgeben
	socket_select($changed, $null, $null, 0, 10);
	
	//auf neuen Socket prüfen
	if (in_array($socket, $changed)) {
		$socket_new = socket_accept($socket); //neuen Socket akzeptieren
		$clients[] = $socket_new; //Socket dem client array hinzufügen
		
		$header = socket_read($socket_new, 1024); //Daten lesen welche vom Socket geschickt wurden
		perform_handshaking($header, $socket_new, $host, $port); //websocket handshake
		
		socket_getpeername($socket_new, $ip); //ip kriegen
		$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' connected'))); //json data vorbereiten
		send_message($response); //alle User informieren wenn jemand joined
		
		//Platz schaffen für neuen Socket
		$found_socket = array_search($socket, $changed);
		unset($changed[$found_socket]);
	}
	
	//Schleife durch alle verbundenen Sockets
	foreach ($changed as $changed_socket) {	
		
		//auf neue Daten prüfen
		while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
		{
			$received_text = unmask($buf); //Daten unmasken
			$tst_msg = json_decode($received_text); //json dekodieren 
			$user_name = $tst_msg->name; //Name des Sender
			$user_message = $tst_msg->message; //Nachrichtentext
			$user_color = $tst_msg->color; //Farbe
			
			//Daten vorbereiten
			$response_text = mask(json_encode(array('type'=>'usermsg', 'name'=>$user_name, 'message'=>$user_message, 'color'=>$user_color)));
			send_message($response_text); //Daten senden
			break 2; //Loop verlassen
		}
		
		$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
		if ($buf === false) { // getrennte Clients prüfen
			// Client aus $clients löschen
			$found_socket = array_search($changed_socket, $clients);
			socket_getpeername($changed_socket, $ip);
			unset($clients[$found_socket]);
			
			//User informieren
			$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' disconnected')));
			send_message($response);
		}
	}
}

socket_close($sock);

function send_message($msg)
{
	global $clients;
	foreach($clients as $changed_socket)
	{
		@socket_write($changed_socket,$msg,strlen($msg));
	}
	return true;
}


function unmask($text) {
	$length = ord($text[1]) & 127;
	if($length == 126) {
		$masks = substr($text, 4, 4);
		$data = substr($text, 8);
	}
	elseif($length == 127) {
		$masks = substr($text, 10, 4);
		$data = substr($text, 14);
	}
	else {
		$masks = substr($text, 2, 4);
		$data = substr($text, 6);
	}
	$text = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
}

//Nachricht encoden
function mask($text)
{
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);
	
	if($length <= 125)
		$header = pack('CC', $b1, $length);
	elseif($length > 125 && $length < 65536)
		$header = pack('CCn', $b1, 126, $length);
	elseif($length >= 65536)
		$header = pack('CCNN', $b1, 127, $length);
	return $header.$text;
}

//neuen Client "handshaken"
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
	$headers = array();
	$lines = preg_split("/\r\n/", $receved_header);
	foreach($lines as $line)
	{
		$line = chop($line);
		if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
		{
			$headers[$matches[1]] = $matches[2];
		}
	}

	$secKey = $headers['Sec-WebSocket-Key'];
	$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
	//hand shaking header
	$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
	"Upgrade: websocket\r\n" .
	"Connection: Upgrade\r\n" .
	"WebSocket-Origin: $host\r\n" .
	"WebSocket-Location: ws://$host:$port/hawtalk/login/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
}


// Großer Dank an Saran Chamling (http://www.sanwebe.com/2013/05/chat-using-websocket-php-socket), 
// ohne dessen Tutorium ich den Chat mit PHP nicht hinbekommen hätte und die Server Implementierung schon recht nicht.
