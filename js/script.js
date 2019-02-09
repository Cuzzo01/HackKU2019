
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
function error(message){
  console.log(message);
}
