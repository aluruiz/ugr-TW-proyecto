<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/BaseDeDatos.php';
require_once './login.php';
require_once './core/modelo/Aside.php';

$aside=new Aside(3);
$database = new Database();
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/editarUsuario.html";
$template = $twig -> load($ruta);

$usuario=NULL;

    if(isset($_POST['modificado'])){
      if($loggedUser->rango=="Administrador"){
        $database->modificarDatosRangoAdministrador($_POST['usuario'],$_POST['nombre'],$_POST['familia'],$_POST['email'],$_POST['postal'],$_POST['tlf'],$_POST['rango'],$_POST['estado']);
        $database->nuevoLog("Editado usuario Administrador: ".$usuario);
      }else{
        $database->modificarDatosRangoColaborador($_POST['usuario'],$_POST['nombre'],$_POST['familia'],$_POST['email'],$_POST['postal'],$_POST['tlf']);
        $database->nuevoLog("Editado usuario Colaborador: ".$usuario);
      }
      if(isset($_POST['contraseña']) && $_POST['contraseña']!=""){
        $database->modificarContraseña($_POST['usuario'],$_POST['contraseña']);
        $database->nuevoLog("Modificada contraseña de Usuario: ".$usuario);
      }
    }

    if (isset($_POST['usuario'])) {
      $usuario=$database->getUsuarioById($_POST['usuario']);
    }else{
      $usuario=$loggedUser;
    }

    if (isset($_POST['nuevaImagen']) && is_uploaded_file($_FILES['imagen']['tmp_name'])) {
      unlink("./imagenes/Usuario-".$_POST['usuario'].".".$usuario->extImagen);
      $dirSubida='./imagenes/';
      $nombre="Usuario-".$_POST['usuario'].".".pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);
      move_uploaded_file($_FILES['imagen']['tmp_name'], $dirSubida.$nombre);
      $database->modificarExtImagen($_POST['usuario'],pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION));
      $usuario->extImagen=pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION);
    }

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
  $argumentos["aside"]=$aside;
$argumentos["usuario"]=$usuario;

echo $template -> render($argumentos);
?>
