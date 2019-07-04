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

$ruta = "vista/editarIncidencia.html";
$template = $twig -> load($ruta);

$incidencia=NULL;

if($loggedUser!=NULL && isset($_POST['identificadorInci'])){
  $identificadorInci=$_POST['identificadorInci'];
  $result=NULL;
  if (isset($_POST['modificado'])) {
    $result=$database->modificarIncidencia($_POST['identificadorInci'],$_POST['titulo'],$_POST['lugar'],$_POST['descripcion']);
    if ($loggedUser->rango=="Administrador"){ //Aquí falla con strcmp y me gustaría saber por qué.
      $result=$database->modificarEstadoIncidencia($_POST['identificadorInci'],$_POST['estado']);

    }

  } else {
    $result=$database->getIncidencia($_POST['identificadorInci']);

  }
  $row = $result->fetch_assoc();
  $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],NULL,NULL,$database->getPalabrasClave($row["identificador"]));
/*      echo $_POST['estado'];
  echo $incidencia->estado;
  echo $_POST['titulo'];*/
}

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
$argumentos["incidencia"] = $incidencia;
$argumentos["aside"]=$aside;

echo $template -> render($argumentos);
?>
