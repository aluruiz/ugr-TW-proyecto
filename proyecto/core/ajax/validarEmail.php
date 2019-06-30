<?php
$queryUsuarios = "SELECT * FROM usuarios WHERE email=?";
$stmt = $this->mysqli->prepare($queryUsuarios);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultUsuario = $stmt->get_result();
$usuario = null;
if ($row = $resultUsuario->fetch_assoc()) {
    $usuario = new Usuario($row["identificador"], $row["nombre"], $row["familia"], $row["email"], $row["direccion"], $row["telefono"], $row["password"], $row["rango"], $row["estado"]);
}
$stmt->close();
return $usuario;

 ?>
