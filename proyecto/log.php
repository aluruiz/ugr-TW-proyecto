<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/BaseDeDatos.php';
require_once './core/modelo/Log.php';
require_once './login.php';
require_once './core/modelo/Aside.php';

  $aside=new Aside(3);
$database = new Database();
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/log.html";
$template = $twig -> load($ruta);

$logs=array();

$result=$database->getLog();
while($row = $result->fetch_assoc()){
  $log=new Log($row['identificador'],$row['fecha'],$row['descripcion']);
  $logs[$row['identificador']]=$log;
}

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
$argumentos["logs"]=$logs;
  $argumentos["aside"]=$aside;

echo $template -> render($argumentos);
?>
