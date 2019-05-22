<?php

require "../BaseDeDatos.php";
$database = new Database();

session_start();

$titulo = $_POST['titulo'] ?? "";
$descripcion = $_POST['descripcion'] ?? "";
$lugar = $_POST['lugar'] ?? "";
$palabras = $_POST['palabras'] ?? "";

?>
