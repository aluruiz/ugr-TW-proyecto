<?php
  require "../../BaseDeDatos.php";
  $database = new Database();

  $nombreRegister = $_POST['nombre'] ?? "";
  $familiaRegister = $_POST['familia'] ?? "";
  $emailRegister = $_POST['email'] ?? "";
  $postalRegister = $_POST['postal'] ?? "";
  $tlfRegister = $_POST['tlf'] ?? "";
  $passwordRegister = $_POST['password'] ?? "";

  if (isset($nombreRegister) && !empty($nombreRegister) ||  isset($familiaRegister) && !empty($familiaRegister) || isset($emailRegister) && !empty($emailRegister) || isset($postalRegister) && !empty($postalRegister) || isset($tlfRegister) && !empty($tlfRegister) || isset($passwordRegister) && !empty($passwordRegister)) {
    $userBuscado = $database->getUsuarioByEmail($emailRegister);
    if (!is_null($userBuscado)) {
      echo "email"; //ya existe un usuario con ese email
      $database->nuevoLog("Intento de registro de usuario ya existente: ".$userBuscado->id);
    } else {
      $usuario=$database->nuevoUsuario($nombreRegister, $familiaRegister, $emailRegister, $postalRegister, $tlfRegister, password_hash($passwordRegister, PASSWORD_BCRYPT),'Colaborador','Inactivo');
      echo "ok";
      $database->nuevoLog("Registrado el usuario: ".$usuario);
    }
  }
  header("Location: ../../../index.php");
?>
/*
*/
