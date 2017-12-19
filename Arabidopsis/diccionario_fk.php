<?php

if ($field == 'rubro_id') $value = DevuelveValor($value,'name','rubros','id');
if ($field == 'localidad_id') $value = DevuelveValor($value,'name','localidads','id');
if ($field == 'profesional' AND $value == 0) $value = 'No';
if ($field == 'profesional' AND $value == 1) $value = 'Si';

?>