<?php

require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/BaseDeDatos.php';
require_once './core/modelo/Usuario.php';
require_once './core/modelo/Incidencia.php';
require_once './core/modelo/Comentario.php';
require_once './login.php';
$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/busqueda.html";
$template = $twig -> load($ruta);

  $database = new Database();
  $idLogeado = getUsuarioLogged();
  $loggedUser = $database->getUsuarioById($idLogeado);


  $ordenarBusqueda = $_POST['ordenarBusqueda'] ?? "";
  $textoBusqueda = $_POST['textoBusqueda'] ?? "";
  $buscarEn = $_POST['lugarBusqueda'] ?? "";
  $estadoBusqueda = $_POST['estadoBusqueda'] ?? array();


  $incidencias = array();
 // AQUÍ VA UN BUCLE FOR PARA CADA IF CONCATENANDO LAS $BUSQUEDA POR CADA ESTADO DE BUSQUEDA
  if(strcmp($buscarEn,"lugarTitulo")){
    foreach ($estadoBusqueda as $key => $value) {
      $result=$database->getIncidenciasTituloDesc($ordenarBusqueda,$textoBusqueda,$value);
      while ($row = $result->fetch_assoc()) {
        $usuario = new Usuario($row["usuario"],$row["nombre"],$row["familia"],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
        $resultComentarios=$database->getComentariosIncidencia($row["identificador"]);
        $arrayCom=array();
        while($rowCom = $resultComentarios->fetch_assoc()){
          $usuarioCom = new Usuario($rowCom["usuario"],$rowCom["nombre"],$rowCom["familia"],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
          $comentario = new Comentario($rowCom["identificador"],$rowCom["comentario"],$usuarioCom);
          $arrayCom[$rowCom["identificador"]]=$comentario;
        }
        $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],$usuario,$arrayCom);
        $incidencias[$row["identificador"]] = $incidencia;
      }
    }
  }elseif (strcmp($buscarEn,"lugarDescripcion")) {
    foreach ($estadoBusqueda as $key => $value) {
      $result=$database->getIncidenciasTituloDesc($ordenarBusqueda,$textoBusqueda,$value);
      while ($row = $result->fetch_assoc()) {
        $usuario = new Usuario($row["usuario"],$row["nombre"],$row["familia"],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
        $resultComentarios=$database->getComentariosIncidencia($row["identificador"]);
        $arrayCom=array();
        while($rowCom = $resultComentarios->fetch_assoc()){
          $usuarioCom = new Usuario($rowCom["usuario"],$rowCom["nombre"],$rowCom["familia"],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
          $comentario = new Comentario($rowCom["identificador"],$rowCom["comentario"],$usuarioCom);
          $arrayCom[$rowCom["identificador"]]=$comentario;
        }
        $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],$usuario,$arrayCom);
        $incidencias[$row["identificador"]] = $incidencia;
      }
    }
  }elseif (strcmp($buscarEn,"lugarClave")) {
    foreach ($estadoBusqueda as $key => $value) {
      $result=$database->getIncidenciasTituloDesc($ordenarBusqueda,$textoBusqueda,$value);
      while ($row = $result->fetch_assoc()) {
        $usuario = new Usuario($row["usuario"],$row["nombre"],$row["familia"],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
        $resultComentarios=$database->getComentariosIncidencia($row["identificador"]);
        $arrayCom=array();
        while($rowCom = $resultComentarios->fetch_assoc()){
          $usuarioCom = new Usuario($rowCom["usuario"],$rowCom["nombre"],$rowCom["familia"],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
          $comentario = new Comentario($rowCom["identificador"],$rowCom["comentario"],$usuarioCom);
          $arrayCom[$rowCom["identificador"]]=$comentario;
        }
        $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],$usuario,$arrayCom);
        $incidencias[$row["identificador"]] = $incidencia;
      }
    }
  }

  $argumentos = array();
  $argumentos["incidencias"]=$incidencias;
  $argumentos["loggedUser"] = $loggedUser;
  //$argumentos["usuarios"]=$usuarios;

echo $template -> render($argumentos);
?>
