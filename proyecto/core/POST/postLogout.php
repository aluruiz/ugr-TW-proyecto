<?php
  require_once "../BaseDeDatos.php";
  require_once '../../login.php';
  $database = new Database();
  session_start();
  $idLogeado = getUsuarioLogged();
  $loggedUser = $database->getUsuarioById($idLogeado);
  $database->nuevoLog("Cierre de sesión correcto: ".$loggedUser->name." ".$loggedUser->familia);
  session_unset();
  session_destroy();
  header("Location: ../../index.php");
?>
