<?php
  $ROOT_PATH = dirname(__DIR__);
  require_once "../BaseDeDatos.php";
  require_once $ROOT_PATH . '/core/modelo/Usuario.php';
  require_once $ROOT_PATH . '/core/modelo/Incidencia.php';
  require_once $ROOT_PATH .'/controlador/herramientas/vendor/autoload.php';

  $loader = new \Twig\Loader\FilesystemLoader($ROOT_PATH);
  $twig = new \Twig\Environment($loader);
  $ruta = "/vista/busqueda.html";
  $template = $twig -> load($ruta);

  $database = new Database();
  $ordenarBusqueda = $_POST['ordenarBusqueda'] ?? "";
  $textoBusqueda = $_POST['textoBusqueda'] ?? "";
  $buscarEn = $_POST['lugarBusqueda'] ?? "";
  $estadoBusqueda = $_POST['estadoBusqueda'] ?? array();

  $incidencias = array();
  $usuarios = array();
 // AQUÍ VA UN BUCLE FOR PARA CADA IF CONCATENANDO LAS $BUSQUEDA POR CADA ESTADO DE BUSQUEDA
  if(strcmp($buscarEn,"lugarTitulo")){
    foreach ($estadoBusqueda as $key => $value) {
      $result=$database->getIncidenciasTituloDesc($ordenarBusqueda,$textoBusqueda,$value);
      while ($row = $result->fetch_assoc()) {
        $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],$row["usuario"]);
        $usuario = new Usuario($row["usuario"],$row["nombre"],$row["familia"],NULL,NULL,NULL,NULL,NULL,NULL);
        $incidencias[$row["identificador"]] = $incidencia;
        $usuarios[$row["usuario"]]=$usuario;
      }
    }
  }elseif (strcmp($buscarEn,"lugarDescripcion")) {
    foreach ($estadoBusqueda as $key => $value) {
      echo "descripcion";
      $result=$database->getIncidenciasDescripcionDesc($ordenarBusqueda,$textoBusqueda,$value);
      while ($row = $result->fetch_assoc()) {
        $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],$row["usuario"]);
        $usuario = new Usuario($row["usuario"],$row["nombre"],$row["familia"],NULL,NULL,NULL,NULL,NULL,NULL);
        $incidencias[$row["identificador"]] = $incidencia;
        $usuarios[$row["usuario"]]=$usuario;
      }
    }
  }elseif (strcmp($buscarEn,"lugarClave")) {
    foreach ($estadoBusqueda as $key => $value) {
      echo "clave";
      $result=$database->getIncidenciasClaveDesc($ordenarBusqueda,$textoBusqueda,$value);
      while ($row = $result->fetch_assoc()) {
        $incidencia = new Incidencia($row["identificador"],$row["titulo"],$row["lugar"],$row["descripcion"],$row["fecha"],$row["positivas"],$row["negativas"],$row["estado"],$row["usuario"]);
        $usuario = new Usuario($row["usuario"],$row["nombre"],$row["familia"],NULL,NULL,NULL,NULL,NULL,NULL);
        $incidencias[$row["identificador"]] = $incidencia;
        $usuarios[$row["usuario"]]=$usuario;
      }
    }
  }

  $argumentos = array();
  $argumentos["incidencias"]=$incidencias;
  $argumentos["usuarios"]=$usuarios;
  //header('Location: ../../busqueda.php');
  //$twig-> render('../../busqueda.php', $argumentos);
  echo $template -> render($argumentos);
?>
