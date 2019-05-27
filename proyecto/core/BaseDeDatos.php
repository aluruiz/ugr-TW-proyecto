<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH . '/core/modelo/Evento.php';
require_once $ROOT_PATH . '/core/modelo/Comentario.php';
require_once $ROOT_PATH . '/core/modelo/Tag.php';
require_once $ROOT_PATH . '/core/modelo/Contacto.php';
require_once $ROOT_PATH . '/core/modelo/Usuario.php';

class Database {

  private static $INSTANCE;

  private function __construct() {
    $hostname = "localhost";
    $username1 = "paularg981819";
    $password1 = "fuWxW4c7";
    $username2 = "lauragogar1819";
    $password2 = "KdnkJuSY";
    $databaseName = "proyectofinal_tw";
    self::$INSTANCE = new mysqli($hostname, $username1, $password1, $databaseName);
    if(!self::$INSTANCE){
      self::$INSTANCE = new mysqli($hostname, $username2, $password2, $databaseName);
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
}

  ?>
