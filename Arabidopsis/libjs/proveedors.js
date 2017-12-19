$(function () {
    $('#descripcion').prop('required', false);
    $('.tabla_descripcion').hide();


})

$('#cuit').focusout(function () {
    $('.tabla_cuit font').remove();

    if (!validar_cuit($(this).val()))
    {
        $('.tabla_cuit').eq(1).append("<font style='color: red'> CUIT INVALIDO</font>");
    }
})

$('#cuit').on('keyup', function (event) {
    valor = $(this).val();
    cuit = $(this).val().replace(/-/g, '');
    if (isNaN(cuit)) {
        $('.tabla_cuit font').remove();
        $('.tabla_cuit').eq(1).append("<font style='color: red'> CUIT INVALIDO</font>");
    } else {
        $('.tabla_cuit font').remove();
    }
    if (valor.length === 2 && event.which !== 8)
    {
        if (!isNaN(valor))
        {
            nuevo = $(this).val() + '-';
            $(this).val(nuevo);
        }
    }
    if (valor.length === 11 && event.which !== 8) {
        valor2 = valor.substring(2, 10);

        if (!isNaN(valor2))
        {
            nuevo = $(this).val() + '-';
            $(this).val(nuevo);
        }
    }
    if (valor.length === 13 && event.which !== 8) {
        digito_verif = valor.substring(12, 13);
        if (!isNaN(digito_verif)) {
            if (!validar_cuit(valor)) {
                $('.tabla_cuit').eq(1).append("<font style='color: red'> CUIT INVALIDO</font>");
            } else {
                bandera = 0;
            }
        } else
            $('.tabla_cuit').eq(1).append("<font style='color: red'> CUIT INVALIDO</font>")
    }
    if (valor.length > 13 && event.which !== 8)
    {

        $('.tabla_cuit').eq(1).append("<font style='color: red'> CUIT INVALIDO</font>")
    }

})



function validar_cuit(cuit)
{

    total = 0;
    var array_cuit=cuit.split('-');
    if(array_cuit.length!==3) {return false};
    cuit = cuit.replace(/-/g, '');
    mult = ['5', '4', '3', '2', '7', '6', '5', '4', '3', '2'];
    cuitchart = cuit.split('');
    for (i = 0; i < mult.length; i++) {
        total += cuitchart[i] * mult[i];
    }
    resto = total % 11;
    dig_verificador = resto === 0 ? 0 : resto === 1 ? 9 : 11 - resto;
    digito = cuit.substring(cuit.length - 1, cuit.length);
    if (parseInt(dig_verificador) === parseInt(digito))
    {
        return true;
    }
    return false;
}


function creardescripcion() {

    cuit = document.getElementById('cuit').value;
    razon_social = document.getElementById('razon_social').value;
    localidad = $('#localidad_id option:selected').text();
    domicilio = $('#direccion').val();
    descripcion = razon_social + ' - ' + cuit + ' - ' + domicilio + ', ' + localidad;
    document.getElementById('descripcion').value = descripcion;
    document.forms.crear.submit();
}


function llenar_localidad(id) {
    $.post('reporte_get_localidad.php', {id: id}, function (data) {
        $('#localidad_id').html(data);
    }, "html");
    $('#localidad_id').val('').change();
}

function validateEmail() {
    var email = $('#email').val();
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    $('.tabla_email font').remove();
    if (re.test(email))
    {
        return true;
    } else {
        $('.tabla_email').eq(1).append("<font style='color: red'> EMAIL INVALIDO</font>");
        return false;
    }
}

$('#email').focusout(function () {
    validateEmail();
})

$('form').submit(function(){
    
     if (!validateEmail()) {
        return false;
    } 
    return true;
    
});