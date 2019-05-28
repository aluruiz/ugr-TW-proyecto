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

  public function getIncidenciasFechaDesc(){
    return $this->consulta("SELECT Incidencias.identificador, Incidencias.titulo, Incidencias.descripcion, Incidencias.fecha,Incidencias.estado,Usuarios.nombre,Usuarios.familia FROM Incidencias JOIN Usuarios ON (Incidencias.usuario=Usuarios.identificador) ORDER BY Incidencias.fecha DESC");
  }

  public function getValoracionesPositivasIncidencia($indentificador){
    $contadorAnonimos = $this->consulta("SELECT Incidencias.positivas FROM Incidencias");
    //FIXME
  }
}

  ?>
