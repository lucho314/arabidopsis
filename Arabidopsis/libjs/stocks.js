
$(function () {
    $('#descripcion').prop('required', false);
    $('.tabla_descripcion').hide();
    $('#lista').DataTable({
        "bSort": false,
        "pagingType": "full_numbers",
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Baja Stock',
                action: function (e, dt, node, config) {
                    id = $('#producto').val();
                    obtener_stock(id);
                    $('#abrir-alta').click();
                }
            },
              {
                text: 'Ver Movimientos Stock',
                action: function (e, dt, node, config) {
                   location.href='movimientos_stoks.php';
                }
            }

        ],
        "language": {
            "url": "DataTables-1.10.12/media/Spanish.json"
        }
    });
})



function creardescripcion() {

    var cantidad = $('#disponibles').val();
    var nombre = $('#producto_id option:selected').html();
    descripcion = nombre;

    document.getElementById('descripcion').value = descripcion;
    document.forms.crear.submit();
}

$('#disponibles').focusout(function () {
    validar_stock($(this).val());
})

function validar_stock(stock) {
    $('.tabla_disponibles font').remove();
    var patron = /^\d*$/;
    if (patron.test(stock)) {

        return true;
    } else {
        $('.tabla_disponibles').eq(1).append("<font style='color: red'> Stock invalido</font>");

        return false
    }

}

$('#costo').focusout(function () {
    validar_numero_positivo($(this).val());
})

function validar_numero_positivo(num)
{
    $('.tabla_costo font').remove();
    if (isNaN(num))
    {
        $('.tabla_costo').eq(1).append("<font style='color: red'> Solo numeros</font>");

        return false;
    } else {

        if (num < 0) {
            $('.tabla_costo').eq(1).append("<font style='color: red'> Solo numeros reales positivos</font>");
            validacion = false;
            return false;
        }

        return true;
    }
}



function obtener_stock(id_producto) {
    $.post('ajax_baja_stock.php', {funcion: 'obtener_total', producto: id_producto}, function (data) {
        $('#disponible_modal').val(data);
    }, "html");

}

function baja_stock(id_producto, cantidad,motivo)
{
    $.post('ajax_baja_stock.php', {funcion: 'dar_baja', producto: id_producto, cantidad: cantidad,motivo:motivo}, function (data) {
        console.log(data);
        location.href='stocks.php';
    }, "html");
}

function aceptar_bajar_stock()
{
    if (validacion_required()) {
        var cantidad=$('#cantidad_modal').val();
        var disponible=$('#disponible_modal').val();
        if(parseInt(disponible)>=parseInt(cantidad)){
        baja_stock($('#producto').val(), $('#cantidad_modal').val(),$('#motivo').val());
        $('#cerrar').click();}
        else{
            $('.tabla_cantidad_modal').append("<font style='color: red'>No puede superar el Stock disponible</font>");
        }
    }
}

function validacion_required() {
    bandera = 0;

    $(".requerido").each(function () {
        var tabla = $(this).attr('id');
        $('.tabla_' + tabla + ' font').remove();
        if ($(this).val() === '')
        {

            $('.tabla_' + tabla).append("<font style='color: red'>DEBE COMPLETAR ESTE CAMPO</font>");
            bandera = 1
            return false
        }
    })
    if (bandera === 1) {
        return false;
    }
    return true;
}




$('#crear_').submit(function () {
    return (validar_numero_positivo($('#costo').val()) && validar_stock($('#disponibles').val()));

})
