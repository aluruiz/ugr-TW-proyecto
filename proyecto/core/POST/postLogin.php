<?php

require_once "../BaseDeDatos.php";
$database = new Database();

$emailLogin = $_POST['email'] ?? "";
$passwordLogin = $_POST['password'] ?? "";

if (empty($emailLogin) || empty($passwordLogin)) {
  echo "error";
} else {
  session_start();
  $userBuscado = $database->getUsuarioByEmail($emailLogin);
  if (is_null($userBuscado)) {
    echo "error1";
    $database->nuevoLog("Inicio de sesión con correo incorrecto: ".$emailLogin);
  } else {
  if ($passwordLogin == $userBuscado->password/*password_verify($passwordLogin, $userBuscado->password)*/) {
      $_SESSION["loggedUserId"] = $userBuscado->id;
      $database->nuevoLog("Inicio de sesión correcto: ".$userBuscado->id);
    } else {
      echo "error2";
     $database->nuevoLog("Contraseña incorrecta para el usuario: ".$userBuscado->id);
    }
   }
}
header("Location: ../../index.php");
?>
