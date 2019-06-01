<?php

require "../Database.php";
$database = new Database();

$emailLogin = $_POST['email'] ?? "";
$passwordLogin = $_POST['password'] ?? "";

if (empty($emailLogin) || empty($passwordLogin)) {
  echo "error";
} else {
  session_start();
  $userBuscado = $database->getUsuarioByEmail($emailLogin);
  if (is_null($userBuscado)) {
    echo "error";
  } else {
    if (password_verify($passwordLogin, $userBuscado->password)) {
      $_SESSION["loggedUserId"] = $userBuscado->id;
    } else {
      echo "error";
    }
   }
}
?>
