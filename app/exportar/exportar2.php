<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=Exportacion.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo chr(239) . chr(187) . chr(191) . $_POST['tabla_municipios'];
?>