
function validarEmail(email){
 emailcheck = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,3}$/i;
 if(!emailcheck.test(email.value)){
   document.getElementById('emailinfo').textContent='Email no valido';
 }
}

function validarPostal(postal){
 postalcheck = /^\d{5}$/;
 if(!postalcheck.test(postal.value)){
   document.getElementById('postalinfo').textContent='postal no valido';
 }
}

function validarTelefono(tlf){
 telefonocheck = /^(\(\+[0-9]{2}\))?\s*[0-9]{3}\s*[0-9]{6}$/;
 if(!telefonocheck.test(tlf.value)){
   document.getElementById('tlfinfo').textContent='telefono no valido';
 }
}


    /*$('#checkEmail').on('blur', function() {

        $('#emailinfo').html('existe').fadeOut(1000);

        var username = $(this).val();
        var dataString = 'username='+username;

        $.ajax({
            type: "POST",
            url: "../../core/ajax/validarEmail.php",
            data: dataString,
            success: function(data) {
              alert("hola");
                $('#emailinfo').fadeIn(1000).html(data);

            }
        });

});*/
