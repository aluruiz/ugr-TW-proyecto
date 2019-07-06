<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/BaseDeDatos.php';
require_once './login.php';
require_once './core/modelo/Aside.php';

$aside=new Aside(3);
$database = new Database();
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);
$usuarios = $database->getUsuarios();

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/gestionUsuarios.html";
$template = $twig -> load($ruta);

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
$argumentos["aside"]=$aside;
$argumentos["usuarios"]=$usuarios;

echo $template -> render($argumentos);
?>
