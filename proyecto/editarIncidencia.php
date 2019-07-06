<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './login.php';
require_once './core/BaseDeDatos.php';
require_once './core/modelo/Usuario.php';
require_once './core/modelo/Incidencia.php';
require_once './core/modelo/Comentario.php';
require_once './core/modelo/Aside.php';

$aside=new Aside(3);
$database = new Database();
$idLogeado = getUsuarioLogged();
$loggedUser = $database->getUsuarioById($idLogeado);

$loader = new \Twig\Loader\FilesystemLoader('.');
$twig = new \Twig\Environment($loader);

$ruta = "vista/editarIncidencia.html";
$template = $twig -> load($ruta);

$incidencia=NULL;
$claves=$database->getPalabrasClave($_POST['identificadorInci']);

if($loggedUser!=NULL && isset($_POST['identificadorInci'])){
  $result=NULL;
  if (isset($_POST['modificado'])) {
    $result=$database->modificarIncidencia($_POST['identificadorInci'],$_POST['titulo'],$_POST['lugar'],$_POST['descripcion']);
    if ($loggedUser->rango=="Administrador"){ //Aquí falla con strcmp y me gustaría saber por qué.
      $result=$database->modificarEstadoIncidencia($_POST['identificadorInci'],$_POST['estado']);
    }
    $arrayClaves=explode(',',$claves);
    $clavesMod=$_POST['palabras'];
    $arrayClavesMod=explode(',',$clavesMod);
    foreach ($arrayClaves as $key => $value) {
      $value=trim($value);
      if(strpos($clavesMod,$value)===false){
        $database->borrarRelClaveIncidencia($value,$_POST['identificadorInci']);
      }
    }

    foreach ($arrayClavesMod as $key => $value) {
      $value=trim($value);
      if(strpos($claves,$value)===false){
        if($database->existePalabraClave($value)==NULL){
          $database->nuevaPalabraClave($value);
        }
        $database->nuevaRelClaveIncidencia($_POST['identificadorInci'],$value);
      }
    }

    //$claves=$database->getPalabrasClave($_POST['identificadorInci']);

  }/* else {
    $result=$database->getIncidencia($_POST['identificadorInci']);
  }
  $row = $result->fetch_assoc();
*/

  //$incidencia->palabrasClave=$claves;

  if(isset($_POST['nuevaImagen']) && is_uploaded_file($_FILES['imagen']['tmp_name'])){
    $dirSubida='./imagenes/';
    $result=$database->nuevaImagen($_POST['identificadorInci'],pathinfo($_FILES['imagen']['name'],PATHINFO_EXTENSION));
    $row=$result->fetch_assoc();
    $nombre="Incidencia-".$_POST['identificadorInci']."-".$row['identificador'].".".$row['extension'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], $dirSubida.$nombre);

  }
  $incidencia = new Incidencia($_POST['identificadorInci']);
}

$argumentos = [];
$argumentos["loggedUser"] = $loggedUser;
$argumentos["incidencia"] = $incidencia;
$argumentos["aside"]=$aside;

echo $template -> render($argumentos);
?>
