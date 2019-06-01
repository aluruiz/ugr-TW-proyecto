<?php
require_once './controlador/herramientas/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(".");
$twig = new \Twig\Environment($loader);

$ruta = "vista\base.twig";


$template = $twig -> load($ruta);
$argumentos = [];
$argumentos["NombreUsuario"] = "Paula";
$argumentos["Usuario"] = "pato";

echo $template -> render($argumentos);
?>
