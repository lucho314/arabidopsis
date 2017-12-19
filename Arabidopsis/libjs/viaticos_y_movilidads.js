var validacion = false;
$(function () {
    $('#total_km').prop('readonly', true);
})
function total() {
    var kilometro_inicial = $('#kilometraje_inicial').val();
    var kilometro_final = $('#kilometraje_final').val();
    var kilometro_total = kilometro_final - kilometro_inicial;
    $('#total_km').val(kilometro_total);
}

$('#kilometraje_inicial').focusout(function () {
    validar_natural($(this).val(), '.tabla_kilometraje_inicial');
    total();
})
$('#kilometraje_final').focusout(function () {
    if (validar_natural($(this).val(), '.tabla_kilometraje_final')) {
        validar_inicio_final();
        total();
    }
})
function validar_natural(numero, tabla) {
    $(tabla + ' #positivo').remove();
    var tes = /^\d*$/;
    if (tes.test(numero)) {
        validacion = true;
        return true;
    } else {
        $(tabla).eq(1).append("<font id='positivo' style='color: red'> Solo numeros naturales positivos</font>");
        validacion = false;
        return false
    }

}

function validar_inicio_final() {
    var inicio = parseInt($('#kilometraje_inicial').val());
    var final = parseInt($('#kilometraje_final').val());
    $('.tabla_kilometraje_final font').remove();
    if (inicio < final)
    {

        return true;
    }

    $('.tabla_kilometraje_final').eq(1).append("<font style='color: red'> Kilometros finales debe ser mayor que kilometros iniciales</font>");
    return false;
}

$('form').submit(function () {
   return (validacion && validar_inicio_final());

})

function creardescripcion() {
    document.forms.crear_.submit();
};