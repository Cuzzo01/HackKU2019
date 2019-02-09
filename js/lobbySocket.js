let url = "ws://localhost:9000/server.php";
let ws = new WebSocket(url);
ws.onmessage = function(e){
  let msg = JSON.parse(e.data);
  switch(msg.message) {
    case 'reload':
      location.reload();
      break;
  }
}
