let url = "ws://localhost:9000/server.php";
let ws = new WebSocket(url);
ws.onmessage = function(e){
  let msg = JSON.parse(e.data);

}
function validateJoinInfo(){
  codeInput = document.getElementById('codeInput').value;
  console.log(codeInput);
  nameInput = document.getElementById('nameInput').value;

  if(codeInput.length == 4){
    if(nameInput.length > 0 && nameInput.length <= 15){
      let form = document.getElementById('loginData');
      let gameCodeInput = document.getElementById('codeInput');
      gameCodeInput.disabled = false;
      gameCodeInput.value = gameCodeInput.value.toUpperCase()
      form.method = 'post';
      form.action = '../helpers/joinLobby.php';
      let msg = {
        name: nameInput,
        message: "reload"
      };
      form.submit();
      ws.send(JSON.stringify(msg))
      redirect('../helpers/joinLobby.php', 'POST');
    }
    else{
      error('The name you entered is greater than 15 characters or empty, please try again.')
    }
  }
  else{
    error('The lobby string you entered is greater than 15 characters or empty, please try again.')
  }
}
function sendMsg(){

}
function readVariables(){
    let query = window.location.search.substring(1);
    if(query.length > 0){
      let variables = query.split('?');
      for(let i=0;i<variables.length;i++){
        let name = query.split('=')[0];
        let value = query.split('=')[1];
        if(name == "gameCode"){
          isHost(value);
        }
        else if(name == "err") {
          if(value == "1") {
            error("The join code was invalid")
          }
        }
      }
    }
}
function isHost(code){
    gameCodeInput = document.getElementById('codeInput');
    gameCodeInput.value = code;
    gameCodeInput.disabled = true;
}
function possibleBet(){
  let amount = document.getElementById('betInput').value;
  let funds = document.getElementById('coins');
  let form = document.getElementById('betInfo');
  console.log(amount);
  console.log(funds.textContent );
  if(amount <= funds){
    form.method = 'post';
    form.action = '../helpers/setBet.php';
    form.submit();
    redirect('../helpers/setBet.php', 'POST');
  }

}
function error(message){
  console.log(message);
}
