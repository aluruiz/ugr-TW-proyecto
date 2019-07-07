
function validarEmail(email){
 emailcheck = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$/i;
 if(!emailcheck.test(email.value)){
   document.getElementById('emailinfo').textContent='Email no valido';
 }
}

function validarPostal(postal){
 postalcheck = /^\d{5}$/;
 if(!postalcheck.test(postal.value)){
   document.getElementById('postalinfo').textContent='Postal no valido';
 }
}

function validarTelefono(tlf){
 telefonocheck = /^\d{3}\s\d{6}$/;
 if(!telefonocheck.test(tlf.value)){
   document.getElementById('tlfinfo').textContent='Telefono no valido';
 }
}

function validarContraseña(constrasenia){
  contraseniacheck = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{5,20}$/;
  if(!contrasenia.value.match(contraseniacheck)){
    document.getElementById('contraseniainfo').textContent='Contraseña no valida';
  }

}
