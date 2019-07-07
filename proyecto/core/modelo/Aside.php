<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH.'/BaseDeDatos.php';
require_once $ROOT_PATH.'/modelo/Usuario.php';


class Aside{
  public $topUsuariosIncidencias;
  public $topUsuariosComentarios;
  public $nIncidenciasResueltas;
  public $nIncidenciasPendientes;

  public function __construct($n){
    $database=new DataBase();

    $this->topUsuariosIncidencias=array();
    $result=$database->getUsuariosIncDesc();
    for ($i=0; $i <$n ; $i++) {
      if($row=$result->fetch_assoc()){
        $usuario = $database->getUsuarioById($row['identificador']);
        $this->topUsuariosIncidencias[$i]=$usuario;
      }else{
        $usuario = new Usuario("-1","Vacante","","","","","","","","","");
        $this->topUsuariosIncidencias[$i]=$usuario;
      }
    }

    $this->topUsuariosComentarios=array();
    $result=$database->getUsuariosComDesc();
    for ($i=0; $i <$n ; $i++) {
      if($row=$result->fetch_assoc()){
        $usuario = $database->getUsuarioById($row['identificador']);
        $this->topUsuariosComentarios[$i]=$usuario;
      }else{
        $usuario = new Usuario("-1","Vacante","","","","","","","","","");
        $this->topUsuariosComentarios[$i]=$usuario;
      }
    }

    $this->nIncidenciasResueltas=$database->getNumIncidenciasResueltas();
    $this->nIncidenciasPendientes=$database->getNumIncidenciasPendientes();

  }
}
?>
