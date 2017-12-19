<?php
include_once('lib/connect_mysql.php');
include_once('lib/funciones.php');
include_once('html_sup.php');
$texto = $_POST['texto'];
$f_inicio=  date_transform_lat($_POST['fecha_inicio']);
$f_fin=date_transform_lat($_POST['fecha_fin']);
$html.= $_POST['html'];

$sql='SELECT razon_social, cuit, localidads.descripcion,email FROM colaboradors INNER JOIN localidads on localidads.id=colaboradors.localidad_id';
$datos=  mysql_query($sql);
?>
<form action="imprime_pdf.php" method="post">
<table width="100%" class="table table-striped" cellpadding="2" cellspacing="0" border="0" id="colaboradores">
    <h2><u>Seleccione colaborador a enviar pdf</u></h2>
    <thead>
            <tr>
                <th><input type="checkbox" name="select_all" value="1" id="example-select-all"> (todos)</th>
                <td align="center"><b>Razon social</b></td>

                <td align="center"><b>Cuit</b></td>

                <td align="center"><b>Localidad</b></td>
                <td align="center"><b>Email</b></td>
            </tr>
    </thead>
    <tbody>
            <?php  while ($row = mysql_fetch_array($datos)) :?>
             <tr>
                 <th><input type="checkbox" name="id[]" value="<?= $row[3]?>"</th>
                <td align="center"><?= $row[0]?></td>

                <td align="center"><?= $row[1]?></td>

                <td align="center"><?= $row[2]?></td>
                <td align="center"><?= $row[3]?></td>
                
            </tr>
            <?php endwhile; ?>
    </tbody>
</table>
    <input type="hidden" name="texto" value="<?php echo $texto; ?>">
    <input type="hidden" name="fecha_inicio" value="<?= $f_inicio ?>">
    <input type="hidden" name="fecha_fin" value="<?= $f_fin ?>">
    <input type="hidden" name="html" value="<?= $html ?>">
    <input type="hidden" name="apertura" value="enviar">
    <input type="submit" value="Enviar">
    </form>
<?php include_once('html_inf.php');?>
<script>
    
    $(document).ready(function (){
   var table = $('#colaboradores').DataTable({
      'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center'
      }],
      'order': [[1, 'asc']]
   });

   // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#example tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control 
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });

   // Handle form submission event
   $('#frm-example').on('submit', function(e){
      var form = this;

      // Iterate over all checkboxes in the table
      table.$('input[type="checkbox"]').each(function(){
         // If checkbox doesn't exist in DOM
         if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
               // Create a hidden element 
               $(form).append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', this.name)
                     .val(this.value)
               );
            }
         } 
      });
   });
});
    
    </script>
    