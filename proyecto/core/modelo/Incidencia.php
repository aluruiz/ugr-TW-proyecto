<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH.'/BaseDeDatos.php';
require_once 'Comentario.php';

class Incidencia{
  public $id;
  public $titulo;
  public $lugar;
  public $descripcion;
  public $fecha;
  public $positivas;
  public $negativas;
  public $estado;
  public $usuario;
  public $comentarios;
  public $palabrasClave;
  public $imagenes;

  public function __construct($id){
    $this->id=$id;
    $database=new DataBase();

    $result=$database->getIncidencia($this->id)->fetch_assoc();

    $this->titulo=$result['titulo'];
    $this->lugar=$result['lugar'];
    $this->descripcion=$result['descripcion'];
    $this->fecha=$result['fecha'];
    $this->positivas=$result['positivas'];
    $this->negativas=$result['negativas'];
    $this->estado=$result['estado'];
    $this->usuario=$database->getUsuarioById($result['usuario']);
    $this->palabrasClave=$database->getPalabrasClave($this->id);

    $this->comentarios=array();
    $result=$database->getComentariosIncidencia($this->id);
    while($result != NULL && $row=$result->fetch_assoc()){
      $usuarioCom=$database->getUsuarioById($row['usuario']);
      $comentario=new Comentario($row["identificador"],$row["comentario"],$usuarioCom);
      $this->comentarios[$row['identificador']]=$comentario;
    }

    $this->imagenes=array();
    $result=$database->getImagen($this->id);
    while($result != NULL && $row=$result->fetch_assoc()){
      $this->imagenes[$row['identificador']]="Incidencia-".$this->id."-".$row['identificador'].".".$row['extension'];
    }

  }
}


 ?>
