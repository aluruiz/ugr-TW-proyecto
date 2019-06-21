<?php
  require_once "../BaseDeDatos.php";
  $database = new Database();
  $ordenarBusqueda = $_POST['ordenarBusqueda'] ?? "";
  $textoBusqueda = $_POST['textoBusqueda'] ?? "";
  $buscarEn = $_POST['lugarBusqueda'] ?? "";
  $estadoBusqueda = $_POST['estadoBusqueda'] ?? "";

  $busqueda = NULL;
 // AQUÍ VA UN BUCLE FOR PARA CADA IF CONCATENANDO LAS $BUSQUEDA POR CADA ESTADO DE BUSQUEDA
  if(strcmp($buscarEn,"lugarTitulo")){
    $busqueda=$database.getIncidenciasTituloDesc($ordenarBusqueda,$textoBusqueda,$estadoBusqueda);
  }elseif (strcmp($buscarEn,"lugarDescripcion") {
    $busqueda=$database.getIncidenciasDescripcionDesc($ordenarBusqueda,$textoBusqueda,$estadoBusqueda);
  }elseif (strcmp($buscarEn,"lugarClave") {
    $busqueda=$database.getIncidenciasClaveDesc($ordenarBusqueda,$textoBusqueda,$estadoBusqueda);
  }
?>
