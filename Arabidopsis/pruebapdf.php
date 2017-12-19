<?php

// reference the Dompdf namespace
require_once 'dompdf/dompdf_config.inc.php';
$nombre_archivo='recibo';
// instantiate and use the dompdf class
$dompdf = new DOMPDF();
$dompdf->set_paper('a4','landscape');
$dompdf->load_html('hola mundo');
$dompdf->render();
//$dompdf->output();
$dompdf->stream("$nombre_archivo.pdf",array('Attachment'=>0));
