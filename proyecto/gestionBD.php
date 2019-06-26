<?php
require_once './controlador/herramientas/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/gestionBD.html";
$template = $twig -> load($ruta);

echo $template -> render();
?>
