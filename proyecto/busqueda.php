<?php

require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/BaseDeDatos.php';
require_once './core/modelo/Usuario.php';
require_once './core/modelo/Incidencia.php';
require_once './core/modelo/Comentario.php';
require_once './core/modelo/Aside.php';
require_once './login.php';
$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/busqueda.html";
$template = $twig -> load($ruta);

$database = new Database();
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);
$lugares=$database->getAllLugares();
$aside=new Aside(3);

if (isset($_POST['valoracion'])) {
  $tipoValoracion="";
  if(strcmp($_POST['valoracion'],"+")){
    $tipoValoracion="Positiva";
  }else {
    $tipoValoracion="Negativa";
  }

  if($idLogeado!=NULL){
    try {
        $database->nuevaValoracionUsuario($idLogeado,$_POST['identificadorInci'],$tipoValoracion);
    } catch (\Exception $e) {

    }
  }else {
    $database->nuevaValoracionAnonima($_POST['identificadorInci'],$tipoValoracion);
  }

}
if (isset($_POST['comentario'])) {
  $database->nuevoComentario($idLogeado,$_POST['identificadorInci'],$_POST['comentario']);
}

  $ordenarBusqueda = $_POST['ordenarBusqueda'] ?? "";
  $textoBusqueda = $_POST['textoBusqueda'] ?? "";
  $buscarEn = $_POST['lugarBusqueda'] ?? "";
  $estadoBusqueda = $_POST['estadoBusqueda'] ?? array();
  $lugarIncidencia= $_POST['lugar'] ?? "";


  $incidencias = array();
  if(strcmp($buscarEn,"lugarTitulo")){
    foreach ($estadoBusqueda as $key => $value) {
      $result=$database->getIncidenciasTituloDesc($ordenarBusqueda,$textoBusqueda,$value,$lugarIncidencia);
      while ($row = $result->fetch_assoc()) {
        $incidencias[$row['identificador']]=new Incidencia($row['identificador']);
      }
    }
  }elseif (strcmp($buscarEn,"lugarDescripcion")) {
    foreach ($estadoBusqueda as $key => $value) {
      $result=$database->getIncidenciasDescripcionDesc($ordenarBusqueda,$textoBusqueda,$value,$lugarIncidencia);
      while ($row = $result->fetch_assoc()) {
        $incidencias[$row['identificador']]=new Incidencia($row['identificador']);
      }
    }
  }elseif (strcmp($buscarEn,"lugarClave")) {
    foreach ($estadoBusqueda as $key => $value) {
      $result=$database->getIncidenciasClaveDesc($ordenarBusqueda,$textoBusqueda,$value,$lugarIncidencia);
      while ($row = $result->fetch_assoc()) {
        $incidencias[$row['identificador']]=new Incidencia($row['identificador']);
      }
    }
  }

  $argumentos = array();
  $argumentos["incidencias"]=$incidencias;
  $argumentos["loggedUser"] = $loggedUser;
  $argumentos["lugares"]=$lugares;
  $argumentos["aside"]=$aside;
  $argumentos['ordenarBusqueda']=$ordenarBusqueda;
  $argumentos['textoBusqueda']=$textoBusqueda;
  $argumentos['buscarEn']=$buscarEn;
  $argumentos['estadoBusqueda']=$estadoBusqueda;
  $argumentos['lugarIncidencia']=$lugarIncidencia;
  //$argumentos["usuarios"]=$usuarios;

echo $template -> render($argumentos);
?>
