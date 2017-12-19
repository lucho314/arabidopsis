//onload
$(function () {
    $('#descripcion').prop('required', false);
    $('.tabla_descripcion').hide();
    bloq_seg_identidad($('#identidad_id').val());
    if (accion == 'edit')//declaro variables globales para no perderlas si me cambia el tipo de indentidad id, por si quiere volver.
    {
        Gidentidad_id = $('#identidad_id').val();
        Gnombre = $('#nombre').val();
        Gapellido = $('#apellido').val();
        Grazon_social = $('#razon_social').val();
        Gdni=$('#dni').val();
        
    }
})


$('#nombre').focusout(function () {
    generar_razon_social();

})
$('#apellido').focusout(function () {
    generar_razon_social();
});
$('#identidad_id').change(function () {
    bloq_seg_identidad($(this).val());
    if ($(this).val() != 3 && ($('#dni').val()>6)) {
        cuit = get_cuil_cuit($('#dni').val(), $(this).val());
        $('#cuit').val(cuit)
    }
    if (accion === 'edit')
    {
        if ($(this).val() === Gidentidad_id)
        {
            $('#identidad_id').val(Gidentidad_id);
            $('#nombre').val(Gnombre);
            $('#apellido').val(Gapellido);
            $('#razon_social').val(Grazon_social);
            $('#dni').val(Gdni).focusout();
        }
    }

    ;
})

$('#cuit').focusout(function () {
    $('.tabla_cuit font').remove();
    if (!validar_cuit($(this).val()))
    {
        $('.tabla_cuit').eq(1).append("<font style='color: red'> CUIT INVALIDO</font>");
    }
})




function bloq_seg_identidad(id, edit = false) {
    $('.tabla_dni').show();
    $('.tabla_nombre').show();
    $('.tabla_apellido').show();
    if (id === '1' || id === '2')
    {
        $('.tabla_razon_social').hide();
        if ($('#dni').val() === '-')
            $('#dni').val('');
        if ($('#nombre').val() === '-')
            $('#nombre').val('');
        if ($('#apellido').val() === '-')
            $('#apellido').val('');
        if (typeof (modificar) === "undefined") {
           // get_cuit();
        }

    } else {
        $('.tabla_razon_social').show();
        $('.tabla_dni').hide();
        $('.tabla_nombre').hide();
        $('.tabla_apellido').hide();
        $('#dni').val('-');
        $('#nombre').val('-');
        $('#apellido').val('-');
    }

}
function generar_razon_social() {
    nombre = $('#nombre').val();
    apellido = $('#apellido').val();
    $('#razon_social').val(nombre + ' ' + apellido);
}
$('#dni').focusout(function () {
    cuit = get_cuil_cuit($(this).val(), $('#identidad_id').val());
    $('#cuit').val(cuit);
})


$('#cuit').on('keyup', function (event) {
    if ($('#identidad_id').val() !== '4') {
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
    }

})

$('#cuit').focusout(function () {
    $('.tabla_cuit font').remove();

    if (!validar_cuit($(this).val()))
    {
        $('.tabla_cuit').eq(1).append("<font style='color: red'> CUIT INVALIDO</font>");
    }
})


function validar_cuit(cuit)
{
    total = 0;
    var array_cuit = cuit.split('-');
    if (array_cuit.length !== 3) {
        return false
    }
    ;
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


function llenar_localidad(id) {
    $.post('reporte_get_localidad.php', {id: id}, function (data) {
        $('#localidad_id').html(data);
    }, "html");
    $('#localidad_id').val('').change();
}
function creardescripcion() {

    razon = document.getElementById('razon_social').value;
    localidad = $('#localidad_id option:selected').text();
    domicilio = $('#domicilio').val();
    descripcion = razon + ' - ' + domicilio + ', ' + localidad;
    document.getElementById('descripcion').value = descripcion.toUpperCase();
    document.forms.crear.submit();
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


$('form').submit(function () {
    if (!validateEmail()) {
        return false;
    }


})


function get_cuil_cuit(document_number, gender) {
    /**
     * Cuil format is: AB - document_number - C
     * Author: Nahuel Sanchez, Woile
     *
     * @param {str} document_number -> string solo digitos
     * @param {str} gender -> debe contener HOMBRE, MUJER o SOCIEDAD
     *
     * @return {str}
     **/
    'use strict';
    var HOMBRE = ['HOMBRE', 'M', 'MALE', '1'],
            MUJER = ['MUJER', 'F', 'FEMALE', '2'],
            SOCIEDAD = ['SOCIEDAD', 'S', 'SOCIETY', '3'];
    var AB, C;

    /**
     * Verifico que el document_number tenga exactamente ocho numeros y que
     * la cadena no contenga letras.
     */
    if (document_number.length != 8 || isNaN(document_number)) {
        if (document_number.length == 7 && !isNaN(document_number)) {
            document_number = '0'.concat(document_number);
        } else {
            // Muestro un error en caso de no serlo.
            throw 'El numero de document_number ingresado no es correcto.';
        }
    }

    /**
     * De esta manera permitimos que el gender venga en minusculas,
     * mayusculas y titulo.
     */
    gender = gender.toUpperCase();

    // Defino el valor del prefijo.
    if (HOMBRE.indexOf(gender) >= 0) {
        AB = '20';
    } else if (MUJER.indexOf(gender) >= 0) {
        AB = '27';
    } else {
        AB = '30';
    }

    /*
     * Los numeros (excepto los dos primeros) que le tengo que
     * multiplicar a la cadena formada por el prefijo y por el
     * numero de document_number los tengo almacenados en un arreglo.
     */
    var multiplicadores = [3, 2, 7, 6, 5, 4, 3, 2];

    // Realizo las dos primeras multiplicaciones por separado.
    var calculo = ((parseInt(AB.charAt(0)) * 5) + (parseInt(AB.charAt(1)) * 4));

    /*
     * Recorro el arreglo y el numero de document_number para
     * realizar las multiplicaciones.
     */
    for (var i = 0; i < 8; i++) {
        calculo += (parseInt(document_number.charAt(i)) * multiplicadores[i]);
    }

    // Calculo el resto.
    var resto = (parseInt(calculo)) % 11;

    /*
     * Llevo a cabo la evaluacion de las tres condiciones para
     * determinar el valor de C y conocer el valor definitivo de
     * AB.
     */
    if ((SOCIEDAD.indexOf(gender) < 0) && (resto == 1)) {
        if (HOMBRE.indexOf(gender) >= 0) {
            C = '9';
        } else {
            C = '4';
        }
        AB = '23';
    } else if (resto === 0) {
        C = '0';
    } else {
        C = 11 - resto;
    }

    // Show example
    console.log([AB, document_number, C].join('-'));

    // Generate cuit
    var cuil_cuit = [AB, document_number, C].join('-');

    return cuil_cuit;

}