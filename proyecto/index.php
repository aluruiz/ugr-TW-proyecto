<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './login.php';
require_once './core/BaseDeDatos.php';

$database = new Database();

$loader = new \Twig\Loader\FilesystemLoader(".");
$twig = new \Twig\Environment($loader);
$ruta = "vista\base.html";
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);

$template = $twig -> load($ruta);
$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;

echo $template -> render($argumentos);
?>
