<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './login.php';
require_once './core/BaseDeDatos.php';
require_once './core/modelo/Usuario.php';
require_once './core/modelo/Incidencia.php';
require_once './core/modelo/Comentario.php';
require_once './core/modelo/Aside.php';

  $aside=new Aside(3);
$database = new Database();
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/misIncidencias.html";
$template = $twig -> load($ruta);

$incidencias=array();

if($loggedUser!=NULL){
  $result=$database->getIncidenciasUsuario($loggedUser->id);
  while ($row = $result->fetch_assoc()) {
    $resultComentarios=$database->getComentariosIncidencia($row["identificador"]);
    $arrayCom=array();
    while($rowCom = $resultComentarios->fetch_assoc()){
      $usuarioCom = new Usuario($rowCom["usuario"],$rowCom["nombre"],$rowCom["familia"],NULL,NULL,NULL,NULL,NULL,NULL,NULL);
      $comentario = new Comentario($rowCom["identificador"],$rowCom["comentario"],$usuarioCom);
      $arrayCom[$rowCom["identificador"]]=$comentario;
    }
    $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],$loggedUser,$arrayCom,$database->getPalabrasClave($row["identificador"]));
    $imagenes=array();
    $resultI=$database->getImagen($row["identificador"]);
    while ($resultI != NULL && $rowI=$resultI->fetch_assoc()) {
      $imagenes[$rowI['identificador']]="Incidencia-".$row["identificador"]."-".$rowI['identificador'].".".$rowI['extension'];
    }
    $incidencia->imagenes=$imagenes;
    $incidencias[$row["identificador"]] = $incidencia;
  }
}

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
$argumentos["incidencias"] = $incidencias;
  $argumentos["aside"]=$aside;

echo $template -> render($argumentos);
?>
