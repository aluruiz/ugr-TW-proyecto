<?php

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

  public function __construct($id,$titulo,$lugar,$descripcion,$fecha,$positivas,$negativas,$estado,$usuario,$comentarios){
    $this->id=$id;
    $this->titulo=$titulo;
    $this->lugar=$lugar;
    $this->descripcion=$descripcion;
    $this->fecha=$fecha;
    $this->positivas=$positivas;
    $this->negativas=$negativas;
    $this->estado=$estado;
    $this->usuario=$usuario;
    $this->comentarios=$comentarios;
  }
}


 ?>
