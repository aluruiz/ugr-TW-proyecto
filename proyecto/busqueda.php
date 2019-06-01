<?php
require_once './controlador/herramientas/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/busqueda.twig";
$template = $twig -> load($ruta);

echo $template -> render();
?>
