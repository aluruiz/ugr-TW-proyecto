<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH . '/core/modelo/Evento.php';
require_once $ROOT_PATH . '/core/modelo/Comentario.php';
require_once $ROOT_PATH . '/core/modelo/Tag.php';
require_once $ROOT_PATH . '/core/modelo/Contacto.php';
require_once $ROOT_PATH . '/core/modelo/Usuario.php';

class Database {

  private static $INSTANCE;
  private $mysqli;

  private function __construct() {
    $hostname = "localhost";
    $username1 = "paularg981819";
    $password1 = "fuWxW4c7";
    $username2 = "lauragogar1819";
    $password2 = "KdnkJuSY";
    $databaseName = "proyectofinal_tw";
    $this->mysqli = new mysqli($hostname, $username1, $password1, $databaseName);
    if(!$this->mysql){
      $this->mysqli = new mysqli($hostname, $username2, $password2, $databaseName);
    }
    $this->mysqli->set_charset("utf8");

    if (mysqli_connect_errno()) {
        printf("Conexión errónea: %s\n", mysqli_connect_error());
        exit();
    }
  }

  public static function getInstance(){
    if(!self::$INSTANCE){
      self::$INSTANCE=new DataBase();
    }
    return self::$INSTANCE;
  }

  public function consulta($consulta){
    return $this->mysqli.query($consulta);
  }
/*
  public function getIncidenciasFechaDesc(){
    return $this->consulta("SELECT Incidencias.identificador, Incidencias.titulo, Incidencias.descripcion, Incidencias.fecha, Incidencias.positivas, Incidencias.negativas, Incidencias.estado,Usuarios.nombre,Usuarios.familia FROM Incidencias JOIN Usuarios ON (Incidencias.usuario=Usuarios.identificador) ORDER BY Incidencias.fecha DESC");
  }

  public function getIncidenciasValPosDesc(){
    return $this->consulta("SELECT Incidencias.identificador, Incidencias.titulo, Incidencias.descripcion, Incidencias.fecha, Incidencias.positivas, Incidencias.negativas, Incidencias.estado,Usuarios.nombre,Usuarios.familia FROM Incidencias JOIN Usuarios ON (Incidencias.usuario=Usuarios.identificador) ORDER BY Incidencias.positivas DESC");
  }

  public function getIncidenciasValNetasDesc(){
    return $this->consulta("SELECT Incidencias.identificador, Incidencias.titulo, Incidencias.descripcion, Incidencias.fecha, Incidencias.positivas, Incidencias.negativas, Incidencias.estado,Usuarios.nombre,Usuarios.familia FROM Incidencias JOIN Usuarios ON (Incidencias.usuario=Usuarios.identificador) ORDER BY Incidencias.positivas - Incidencias.negativas DESC");
  }
*/
  private function estado($estado){
    $texto="";
    if(strcmp($estado,"")!=0){
      $aux=explode(" ",$estado);
      $texto.=" AND (";
      foreach ($aux as $key => $value) {
        if($key!=0){
          $texto.=" OR ";
        }
        $texto.="Incidencias.estado=\'${value}\'";
      }
      $texto.=")";
    }
    return $texto;
  }
  //$especificaciones[0]=orden(fecha,positivas,neto), $especificaciones[1]=palabras clave, $especificaciones[2]=lugar palabras clave, $especificaciones[3]=estado
  public function getIncidenciasDesc($especificaciones){
    $texto="SELECT Incidencias.identificador, Incidencias.titulo, Incidencias.descripcion, Incidencias.fecha, Incidencias.positivas, Incidencias.negativas, Incidencias.estado,Usuarios.nombre,Usuarios.familia FROM Incidencias JOIN Usuarios ON (Incidencias.usuario=Usuarios.identificador";
    $texto.=estado($especificaciones[3]).")";
    $texto.=" ORDER BY ";
    if(strcmp($especificaciones[0],"neto")==0){
      $texto.="Incidencias.positivas - Incidencias.negativas"
    }else {
      $texto.="Incidencias.".$especificaciones[0];
    }
    $texto.=" DESC";
    return $this->consulta($texto);
  }

  public function nuevaIndicencia($especificaciones){
    $texto="INSERT INTO Indicencias (titulo,descripcion,estado,usuario) VALUES (";
    foreach ($especificaciones as $key => $value) {
      $texto.="\'${value}\',";
    }
    $texto.=")";
    return $this->consulta($texto);
  }

  public function nuevoUsuario($especificaciones){
    $texto="INSERT INTO Usuarios (nombre,familia,email,password,rango,estado) VALUES (";
    foreach ($especificaciones as $key => $value) {
      $texto.="\'${value}\',";
    }
    $texto.=")";
    return $this->consulta($texto);
  }

  public function nuevaValoracionUsuario($especificaciones){
    $texto="INSERT INTO Valoracion (incidencia,valoracion,usuario) VALUES (";
    foreach ($especificaciones as $key => $value) {
      $texto.="\'${value}\',";
    }
    $texto.=")";
    $consulta1=$this->consulta($texto);
    return $consulta1 && $this->nuevaValoracionAnonima($especificaciones);
  }

  public function nuevaValoracionAnonima($especificaciones){
    $texto="UPDATE Incidencias SET ";
    if(strcmp($especificaciones[1],"Positiva")){
      $texto.=" positivas = positivas + 1 ";
    }else{
      $texto.=" negativas = negativas + 1 ";
    }
    $texto.="WHERE identificador=".$especificaciones[0];
    return $this->consulta($texto);
  }
}

  ?>
