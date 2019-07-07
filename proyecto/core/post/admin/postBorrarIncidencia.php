<?php
require "../../BaseDeDatos.php";
require_once "../../modelo/Incidencia.php";
$database = new Database();

if (isset($_POST['identificadorInci'])) {
  $incidencia=$database->getIncidencia($_POST['identificadorInci']);
  $result=$database->getImagen($_POST['identificadorInci']);;
  while($row=$result->fetch_assoc()){
    unlink("../../../imagenes/Incidencia-".$_POST['identificadorInci']."-".$row['identificador'].".".$row['extension']);
  }
  $database->borrarIncidencia($_POST['identificadorInci']);

  $database->nuevoLog("Borrada Incidencia: ".$_POST['identificadorInci']);
  //header("Location: ../../../accionIncidencia.php");
}
 ?>
