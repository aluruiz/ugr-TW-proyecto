<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/modelo/Incidencia.php';
require_once './core/BaseDeDatos.php';
require_once './login.php';
require_once './core/modelo/Usuario.php';
require_once './core/modelo/Comentario.php';
require_once './core/modelo/Aside.php';

  $aside=new Aside(3);
$database = new Database();
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/nuevaIncidencia.html";
$template = $twig -> load($ruta);

if(isset($_POST['titulo'])) {
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'] ?? "";
  $lugar = $_POST['lugar'] ?? "";
  $palabrasClave = explode(',',$_POST['palabras'] ?? "");
  //$_SESSION['loggedUserId']
  $incidencia=$database->nuevaIncidencia($titulo,$lugar,$descripcion,'Pendiente',$loggedUser->id);

  foreach ($palabrasClave as $key => $value) {
    $value = trim($value);
    if($database->existePalabraClave($value)==NULL){
      $database->nuevaPalabraClave($value);
    }
    $database->nuevaRelClaveIncidencia($incidencia,$value);
  }

  $database->nuevoLog("El usuario ".$loggedUser->id." ha realizado una nueva incidencia: ".$incidencia);

}

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
  $argumentos["aside"]=$aside;

echo $template -> render($argumentos);
?>
