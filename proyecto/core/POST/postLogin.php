<?php

require "../BaseDeDatos.php";
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
  } else {
  if ($passwordLogin == $userBuscado->password/*password_verify($passwordLogin, $userBuscado->password)*/) {
      $_SESSION["loggedUserId"] = $userBuscado->id;
    } else {
      echo "error2";
    }
   }
}
header("Location: ../../index.php");
?>
