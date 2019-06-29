<?php
require_once './controlador/herramientas/vendor/autoload.php';

if(isset($_SESSION["vector_incidencias"]) && isset($_SESSION["vector_usuarios"])){
  $incidencias = $_SESSION["vector_incidencias"];
  $usuarios = $_SESSION["vector_usuarios"];
  echo $incidencias;
}
$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/busqueda.html";
$template = $twig -> load($ruta);

echo $template -> render();
?>
