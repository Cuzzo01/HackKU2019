<?php
$host = 'localhost'; //host
$port = '9000'; //port
$null = NULL; //null var

//Create TCP/IP sream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//reuseable port
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
//bind socket to specified host
socket_bind($socket, 0, $port);
//listen to port
socket_listen($socket);

//create & add listning socket to the list
$clients = array($socket);
$users = array();
//start endless loop, so that our script doesn't stop
while (true) {
	//manage multiple connections
	$changed = $clients;
	//returns the socket resources in $changed array
	socket_select($changed, $null, $null, 0, 10);

	//check for new socket
	if (in_array($socket, $changed)) {
		$socket_new = socket_accept($socket); //accpet new socket
		$clients[] = $socket_new; //add socket to client array

		$header = socket_read($socket_new, 1024); //read data sent by the socket
		perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake

		//make room for new socket
		$found_socket = array_search($socket, $changed);
		unset($changed[$found_socket]);
	}


	//loop through all connected sockets
	foreach ($changed as $changed_socket) {

		//check for any incomming data
		while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
		{
			$received_text = unmask($buf); //unmask data
			$tst_msg = json_decode($received_text, true); //json decode
			$user_type = $tst_msg['type'];
			$user_name = $tst_msg['name']; //sender name
			$user_message = $tst_msg['message']; //message text
			if($tst_msg != NULL){
				if(array_key_exists('page', $tst_msg)){
					$user_page = $tst_msg['page'];
				}
				if($user_type == 'init'){
					if(!array_key_exists($user_message,$users)){
						$users[$user_message] = array();
					}
					if(!array_key_exists($user_name,$users[$user_message])){
						$response_text = mask(json_encode(array('type'=>'message', 'message'=>'reload')));
						send_message($response_text, $user_name,$user_message);
					}
					$users[$user_message][$user_name] = $changed_socket;
				}
				elseif($user_type == 'sync') {
					sync($user_name,$user_message,$user_page);
				}
				elseif($user_type == 'reload'){
					$response_text = mask(json_encode(array('type'=>'message', 'message'=>'reload')));
					send_message($response_text, $user_name,$user_message); //send data
				}
			}

			//prepare data to be sent to client

			break 2; //exist this loop
		}

		$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
		if ($buf === false) { // check disconnected client
			// remove client for $clients array
			$found_socket = array_search($changed_socket, $clients);
			unset($clients[$found_socket]);
		}
	}
}

// close the listening socket
socket_close($socket);
function sync($username,$lobby,$page){
	global $clients;
	global $users;
	$msg = mask(json_encode(array('type'=>'message', 'message'=>'sync', 'page'=>$page)));
	foreach($users[$lobby] as $name => $changed_socket)
	{
		if($name != $username){
			@socket_write($changed_socket,$msg,strlen($msg));
		}
	}
}
function send_message($msg, $username,$lobby)
{
	global $clients;
	global $users;
	foreach($users[$lobby] as $name => $changed_socket)
	{
		if($name != $username){
			@socket_write($changed_socket,$msg,strlen($msg));
		}
	}
	return true;
}
//Unmask incoming framed message
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
//Encode message for transfer to client.
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
	"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
}
