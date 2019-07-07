<?php
require "../../BaseDeDatos.php";
$database = new Database();

if (isset($_POST['usuario'])) {
  $usuario=$database->getUsuarioById($_POST['usuario']);
  unlink("../../../imagenes/Usuario-".$usuario->id.".".$usuario->extImagen);
  $database->borrarUsuario($usuario->id);
}
 ?>
