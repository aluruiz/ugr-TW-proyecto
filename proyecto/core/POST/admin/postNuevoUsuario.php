<?php
  require "../BaseDeDatos.php";
  $database = new Database();

  $nombreRegister = $_POST['nombre'] ?? "";
  $familiaRegister = $_POST['familia'] ?? "";
  $emailRegister = $_POST['email'] ?? "";
  $postalRegister = $_POST['postal'] ?? "";
  $tlfRegister = $_POST['tlf'] ?? "";
  $passwordRegister = $_POST['password'] ?? "";
  $fotoRegister = $_POST['foto'] ?? "";

  if (empty($emailRegister) || empty($nicknameRegister) || empty($passwordRegister)) {
    echo "error";
  } else {
    $userBuscado = $database->getUsuarioByEmail($emailRegister);
    if (!is_null($userBuscado)) {
      echo "email"; //ya existe un usuario con ese email
  } else {($nombreRegister,$familiaRegister,$emailRegister, password_hash($passwordRegister, PASSWORD_BCRYPT),'Colaborador',$estado)
      $database->nuevoUsuario($emailRegister, $nicknameRegister, password_hash($passwordRegister, PASSWORD_BCRYPT));
      echo "ok";
  }
  }
?>
