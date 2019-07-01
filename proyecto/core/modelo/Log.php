<?php

class Log{
  public $id;
  public $fecha;
  public $descripcion;

  public function __construct($id, $fecha, $descripcion){
    $this->id=$id;
    $this->fecha=$fecha;
    $this->descripcion = $descripcion;
  }
}
?>
