let url = "ws://localhost:9000/server.php";
let ws = new WebSocket(url);
let lobby;
let name;
let cookie = document.cookie;
let parts = cookie.split('; ');
for(let i=0;i < parts.length; i++){
  let entry = parts[i].split('=');
  if(entry[0]=='lobby'){
    lobby = entry[1];
  }
  else if(entry[0]=='name') {
    name = entry[1];
  }
}
ws.onopen = function(e){
  let msg = {
    type: 'init',
    name: name,
    message: lobby
  };
  ws.send(JSON.stringify(msg));
}

ws.onmessage = function(e){
  let msg = JSON.parse(e.data);
  switch(msg.message) {
    case 'reload':
      window.location = window.location.href.split("?")[0];
      break;
    case 'sync':
      if(window.location.pathname.split("/").pop() != msg.page){
        location.reload();
      }
      break;
  }
}
function sendReload(){
  let msg = {
    type: 'reload',
    name: name,
    message: lobby
  };
  setTimeout( function() {
    ws.send(JSON.stringify(msg));
    window.location = window.location.href.split("?")[0];
  }, 500);

}
function sendSync(){
  if(window.location.href.split("?")[1]=="reload=true"){
    sendReload();
    return;
  }
  console.log('Sent sync' + window.location.pathname.split("/").pop());
  let msg = {
    type: 'sync',
    name: name,
    message: lobby,
    page: window.location.pathname.split("/").pop()
  };
  setTimeout( function() {
    ws.send(JSON.stringify(msg));
  }, 500);
}
