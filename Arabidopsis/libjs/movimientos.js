//---------------------Inicio configuraciones por defecto------------------------------------------------
$(function () {
    $('#forma_de_pago_id').addClass("validar-select");
    $('#descripcion').prop('required', false);
    $('.tabla_descripcion').hide();
    $(".tabla_tipo_movimiento_id").hide();
    switch (accion)
    {
        case 'list':
            break;
        case 'new':
            $('#monto').val('0').change();
            $('#tipo_movimiento_id').val('1').change();
            $('#forma_de_pago_id').val('1').change();
            $('#tipo_moneda_id').val('1').change();
            $('#valor_moneda').val('1');
            $('#colaborador_id').val('1').change();
            $('#evento_id').val('1').change();
            $('#producto_id').val('1').change();
             $('#fecha_cierre').val('');
            $('#fecha_vencimiento').val('');
            break;
        case 'edit':
            $('#tipo_movimiento_id').change();
            $('#tipo_moneda_id').change();
            $('#valor_moneda').change();
            $('#forma_de_pago_id').change();
            concepto($('#tipo_movimiento_id').val());
            $('#tipo_movimiento_id').prop('disabled', true);
            break;
    }
    if (typeof (id_genera_recibo) != "undefined") {
        window.open("vista_previa_recibo.php?id=" + id_genera_recibo, "_blank", "toolbar=no,scrollbars=yes,resizable=yes,top=100,left=100,width=1024,height=600");
    }

    //atatable a la lista de movimientos
    if (!$.fn.dataTable.isDataTable('#lista')) {
        $('#lista').DataTable({
            "lengthMenu": [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
            "language": {
                "url": "DataTables-1.10.12/media/Spanish.json"
            }
        });
    }

    //Monto en pesos bloqueado porque se calcula en base al monto * valor moneda.  
    $("#monto_en_pesos").prop("readonly", true);
    $('#nro_recibo_fundacion').prop('readonly', true);


});
//---------------------Fin configuraciones por defecto------------------------------------------------


//Si el monto cambia, calculo el monto en pesos.
$('#monto').focusout(function () {
    pesos = $(this).val();
    var n = pesos.replace(",", ".");
    if (validar_numero_positivo(n)) {
        $(this).val(n);
        CalculaMontoEnPesos();
    }
});

$('#monto').change(function () {
    pesos = $(this).val();
    var n = pesos.replace(",", ".");
    if (validar_numero_positivo(n)) {
        $(this).val(n);
        CalculaMontoEnPesos();
    }
});

//Si el valor de la moneda cambia, calculo el monto en pesos.
$('#valor_moneda').change(function () {
    moneda = $(this).val();
    var n = moneda.replace(",", ".");
    $(this).val(n);
    CalculaMontoEnPesos();
});


/*
 * @autor Luciano zapata
 * @varsion 1.0  23/08/2016
 * @param {type} tipo
 * @param {type} id
 * @returns {undefined}
 * esta funcion se ejecuta cada vez que un select cambia determimnando el id del mismo
 * y ejecutando funciones que estan relacionadas con ese id.
 */
$('select').change(function () {
    var evento = $(this).attr('id');
    var id = $(this).val();
    switch (evento) {
        case 'tipo_movimiento_id':
            ocultar('movimientos', id);
            concepto(id);
            break;
        case 'tipo_moneda_id':
            ocultar('tipo_moneda', id);
            if (id === '1')
            {
                $('#valor_moneda').val('1');
            }
            CalculaMontoEnPesos();
            break
        case 'producto_id':

            if ($('#producto_id option:selected').text() !== 'GENERICO') {
                get_costo_producto(id);
            }

            break;
        case 'forma_de_pago_id':
            tipo_transaccion(id);
            ocultar('forma_de_pago', id);
            $('.tabla_tarjeta_de_credito_id').hide();
            if ($('#forma_de_pago_id option:selected').text() === 'TARJETA DE CREDITO')
            {
                $('.tabla_tarjeta_de_credito_id').show();
            }
            break;
        case 'concepto_movimiento_id':
            if (id === '11')
            {
                ocultar('saldo_inicial', id)
            } else {
                ocultar('movimientos', $('#tipo_movimiento_id').val());
                if ($('#tipo_movimiento_id').val() === '1') {
                    $('#nro_recibo_fundacion').val(nro_recibo_fundacion);
                }

            }

    }
});




//Función que calcular el monto en pesos según el valor de la moneda.
function CalculaMontoEnPesos() {
    var monto = $("#monto").val();
    var valor_moneda = $("#valor_moneda").val();
    var monto_en_pesos = parseFloat(monto) * parseFloat(valor_moneda);
    $("#monto_en_pesos").val(monto_en_pesos);
}



function creardescripcion() {

    monto = document.getElementById('monto_en_pesos').value;
    movimiento=$('#tipo_movimiento_id option:selected').text();
    fecha = document.getElementById('fecha').value;

    descripcion = fecha + ' / ' + monto + ' / '+movimiento;

    document.getElementById('descripcion').value = descripcion;
    document.forms.crear.submit();
}



/*
 *@autor Luciano zapata 20/08/2016 
 * @param {type} tipo (select que dispara el evento de ocultar)
 * @param {type} id (id de la seleccion elegida)
 * @returns {undefined} 
 * 
 * Esta funcion sirve para ocultar campos. 
 * En el array campos_afec_seg_tipo tienen que estar todos los campos que en algun momento se van a ocultar identificado por el elvento 
 * que lo oculta ejemplo: campos_afec_seg_tipo={'nombre_evemtp':['campo1,campo2,campo3,...],'evento_2':[campo1,campo2,...]}
 * En el objeto oculta_seg_tipo se van a encontrar los eventos que disparan la ocultacion y los campos a ocultar.
 * el formato de este objeto es {'nombre_evento1':{'id1':[campo1,campo2,...],'id2':[campo1,campo2,...],...},'nombre_evento2:{...},'nombre_evento3:{...}..}
 * 
 */





function ocultar(tipo, id) {

    var campos_afec_seg_tipo = {'movimientos': ['producto_id', 'nro_comprobante_o_transaccion', 'proveedor_id', 'colaborador_id', 'nro_recibo_fundacion', 'nro_factura', 'nro_recibo_manual'],
        'tipo_moneda': ['valor_moneda'],
        'forma_de_pago': ['tipo_de_transaccion_id', 'banco_id','fecha_vencimiento','fecha_cierre'],
        'saldo_inicial': ['evento_id', 'producto_id', 'nro_comprobante_o_transaccion', 'proveedor_id', 'colaborador_id', 'nro_recibo_fundacion', 'nro_factura', 'nro_recibo_manual']

    };
    var oculta_seg_tipo = {'movimientos': {'1': ['proveedor_id', 'nro_comprobante_o_transaccion', 'nro_factura'], '2': ['colaborador_id', 'nro_recibo_manual', 'producto_id', 'nro_recibo_fundacion'], '3': ['nro_recibo_fundacion', 'nro_recibo_manual', 'nro_comprobante_o_transaccion', 'proveedor_id', 'nro_factura']},
        'tipo_moneda': {'1': ['valor_moneda']},
        'forma_de_pago': {'1': ['tipo_de_transaccion_id', 'banco_id','fecha_vencimiento','fecha_cierre'], '2': ['banco_id','fecha_vencimiento','fecha_cierre'], '3': ['tipo_de_transaccion_id', 'banco_id','fecha_vencimiento','fecha_cierre'],'4':['fecha_vencimiento','fecha_cierre'] ,'5': ['tipo_de_transaccion_id', 'banco_id']},
        'saldo_inicial': {'11': ['evento_id', 'producto_id', 'nro_comprobante_o_transaccion', 'proveedor_id', 'colaborador_id', 'nro_recibo_fundacion', 'nro_factura', 'nro_recibo_manual']}
    };

    var campos_afectados = campos_afec_seg_tipo[tipo];
    var cant_campos_afectados = campos_afectados.length;

    //Se desocultan todos los campos(por si habia alguno oculto)
    for (i = 0; i < cant_campos_afectados; i++) {
        $('.tabla_' + campos_afectados[i]).show();
        if (campos_afectados[i].substr(-2) !== 'id')
        {

            if ($('#' + campos_afectados[i]).val() === '-') {
                $('#' + campos_afectados[i]).val('');
            }

        } else {
            if (campos_afectados[i] !== 'producto_id' && campos_afectados[i] !== 'evento_id') {
                $('#' + campos_afectados[i]).addClass("validar-select");
            }
        }
        if (campos_afectados[i] === 'nro_recibo_manual') {
            $('#' + campos_afectados[i]).val('-');
        }

    }
    if (typeof oculta_seg_tipo[tipo][id] !== 'undefined') {
        var ocultos = oculta_seg_tipo[tipo][id];
        var cant_campos_ocultar = ocultos.length;
        console.log(ocultos);

        //oculto los campos segun el evento e id que disparo la funcion
        for (i = 0; i < cant_campos_ocultar; i++) {
            $('.tabla_' + ocultos[i]).hide();
            if (ocultos[i].substr(-2) !== 'id')
            {
                $('#' + ocultos[i]).val('-');
            } else {

                $('#' + ocultos[i]).val(1).change();

                $('#' + ocultos[i]).removeClass("validar-select");

            }
        }
    }
}

/*
 * @autor Luciano Zapata
 * @varsion 1.0 23/08/2016
 * @param {type} movimiento
 * @returns {undefined}
 * funcion que obtiene los diferentes conceptos segun el movimiento por ajax y 
 * se los asigna a la lista desplegable de  concepto movimiento.
 */
function concepto(movimiento)
{
    var id = movimiento;
    $.ajax({
        type: "POST",
        url: "movimientos_get_conceptos.php",
        dataType: "html",
        data: {
            id: id
        },
        success: function (r) {
            var conce = $('#concepto_movimiento_id').val();
            $("#concepto_movimiento_id").html(r).change();
            if (accion === 'edit') {
                $("#concepto_movimiento_id").val(conce).change();
            }
        }

    });
}


function get_costo_producto(id) {
    $.post('get_costo_producto.php', {id: id}, function (data) {
        $('#monto').val(data).change();
    }, "html");
}


function modificar_recibo(id) {
    $('#id_modificar').val(id);
    $('#formulario_modificar').submit();
}

function validar_numero_positivo(num)
{
    $('.tabla_monto font').remove();
    if (isNaN(num))
    {
        $('.tabla_monto').eq(1).append("<font style='color: red'> Solo numeros</font>");
        return false;
    } else {

        if (num < 0) {
            $('.tabla_monto').eq(1).append("<font style='color: red'> Solo numeros reales positivos</font>");
            return false;
        }
        return true;
    }
}



function tipo_transaccion(id) {
    $.ajax({
        type: "POST",
        url: "movimientos_get_tramsaccion.php",
        dataType: "html",
        data: {
            id: id
        },
        success: function (r) {
            var transaccion = $('#tipo_de_transaccion_id').val();
            $('#tipo_de_transaccion_id').html(r).change();
            if (accion === 'edit') {
                if($('#tipo_de_transaccion_id option[value='+transaccion+']').length===1){
                     $("#tipo_de_transaccion_id").val(transaccion).change();
                }
               
            }
        }
    });
}

$('form').submit(function () {
    $('#tipo_movimiento_id').prop('disabled', false);
    return (validar_select() && validar_numero_positivo($('#monto').val()));

})

function validar_select() {
    var bandera = 0
    $(".validar-select").each(function ()
    {

        var valor = $('option:selected', this).text();
        var tabla = $(this).attr('id');
        if (valor.search('GENERICO') !== -1)
        {
            bandera = 1;

            $('.tabla_' + tabla).eq(1).append("<font style='color: red'>DEBE SER DIFERENTE DE GENERICO</font>");
            return false;

        } else
        {
            $('.tabla_' + tabla + ' font').remove();
        }
    })
    if (bandera === 1)
        return false
    else
        return true;
}