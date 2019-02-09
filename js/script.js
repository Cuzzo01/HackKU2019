
function validateJoinInfo(){
  codeInput = document.getElementById('codeInput').value;
  nameInput = document.getElementById('nameInput').value;

  if(codeInput.length > 0 && codeInput <= 15){
    if(nameInput.length > 0 && nameInput <= 15){
        //Post command
    }
    else{
      error('The name you entered is greater than 15 characters or empty, please try again.')
    }
  }
  else{
    error('The lobby string you entered is greater than 15 characters or empty, please try again.')
  }
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

function error(message){
  console.log(message);
}
