<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/modelo/Incidencia.php';
require_once './core/BaseDeDatos.php';

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/nuevaIncidencia.html";
$template = $twig -> load($ruta);

if(isset($_POST['titulo'])) {
  $database = new DataBase();
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'] ?? "";
  $lugar = $_POST['lugar'] ?? "";
  $palabrasClave = explode(',',$_POST['palabras'] ?? "");
  echo $titulo;
  //$_SESSION['loggedUserId']
  $incidencia=$database->nuevaIncidencia($titulo,$lugar,$descripcion,'Pendiente',1);

  foreach ($palabrasClave as $key => $value) {
    $value = trim($value);
    if(is_bool($database->existePalabraClave($value))){
      $database->nuevaPalabraClave($value);
    }
    $database->nuevaRelClaveIncidencia($incidencia,$value);
  }
}


echo $template -> render();
?>
