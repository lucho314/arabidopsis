
$(function(){
    $('#localidad_id').change();
    $('.tabla_descripcion').hide();
})


$('#localidad_id').change(function () {
        var id = $(this).val();
        $.ajax({
            type: "POST",
            url: "eventos_get_salons.php",
            dataType: "html",
            data: {
                id: id
            },
            success: function (r) {
                $("#salon_id").html(r).change();
            }

        });

        $.ajax({
            type: "POST",
            url: "evento_get_alojamiento.php",
            dataType: "html",
            data: {
                id: id
            },
            success: function (r) {
                $("#alojamiento_id").html(r).change();
            }

        });

    })


function creardescripcion() {

    nombre = document.getElementById('nombre_del_evento').value;
    localidad = $('#localidad_id option:selected').text();
    salon=$('#salon_id option:selected').text();

    descripcion = nombre + ' / ' + salon+' / '+ localidad;

    document.getElementById('descripcion').value = descripcion;
    document.forms.crear.submit();
}