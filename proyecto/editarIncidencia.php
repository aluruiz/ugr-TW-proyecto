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

if($loggedUser!=NULL && isset($_POST['identificadorInci'])){
  $identificadorInci=$_POST['identificadorInci'];
}

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
$argumentos["incidencia"] = $incidencia;
$argumentos["aside"]=$aside;

echo $template -> render($argumentos);
?>