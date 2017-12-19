$(function () {
    $('.tabla_descripcion').hide();
})



function creardescripcion() {

    fecha = $('#fecha').val();
    destino = $('#destino_id option:selected').text();

    descripcion = fecha + ' / ' + destino;

    document.getElementById('descripcion').value = descripcion;
    document.forms.crear.submit();
}