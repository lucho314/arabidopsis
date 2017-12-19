$(function () {
    $('#lista').DataTable({
            "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
            "language": {
                "url": "DataTables-1.10.12/media/Spanish.json"
            }
        });
});

function datos() {
    $('#formulario_modulos').hide();
    $('#formulario_datos').show();
    $('#btn-datos').removeClass('btn-default');
    $('#btn-datos').addClass('btn-success');
    $('#btn-modulos').removeClass('btn-success');
    $('#btn-modulos').addClass('btn-default');
}
function modulos() {

    $('#formulario_datos').hide();
    $('#formulario_modulos').show();
    $('#btn-datos').removeClass('btn-success');
    $('#btn-datos').addClass('btn-default');
    $('#btn-modulos').removeClass('btn-default');
    $('#btn-modulos').addClass('btn-success');
}

$('#datos_usuario_nuevo').submit(function (event) {

    dataString = $(this).serialize();
    var r_pass = $('#rep_pass').val();
    var pass = $('#pass').val();
    event.preventDefault();
    if (validar_contra(pass, r_pass)) {

        dataString += '&funcion=dato_usuario';
        console.log(dataString);

        $.ajax({
            type: "POST",
            url: "ajax_usuario.php",
            data: dataString,
            success: function (data) {
                $('#usuario_id').val(data);
            }
        });
        modulos();
    }
})
$('#modulos_usuario').submit(function () {
    if ($('#usuario_id').val() === '')
    {
        alert('Debe guardar los datos del usuario primero');
        return false;
    } else {
        pasar = false;
        $('.modulos').each(function () {
            if ($(this).is(':checked')) {
                pasar = true;
            }

        })
        if (pasar) {
            return true;
        } else {
            alert('Debe seleccionar al menos un modulo para el usuario');
            return false;
        }
    }

})

$('#rep_pass').focusout(function () {
    var r_pass = $(this).val();
    var pass = $('#pass').val();
    validar_contra(pass, r_pass);
})


$('#datos_usuario_editar').submit(function (event) {

    dataString = $(this).serialize();
    event.preventDefault();

    dataString += '&funcion=editar';

    $.ajax({
        type: "POST",
        url: "ajax_usuario.php",
        data: dataString,
        success: function (data) {
            $('#usuario_id').val($('#id_usuario').val());
        }
    });
    modulos();

})





function validar_contra(pass, r_pass)
{
    $('#tabla_rpas font').remove();
    if (r_pass !== pass)
    {
        $('#tabla_rpas').append("<font style='color: red'> NO COINCIDEN LAS CONTRASE&Ntilde;AS </font>");
        return false;
    }
    return true;
}