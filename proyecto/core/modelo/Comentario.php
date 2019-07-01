<?php

class Comentario{
  public $id;
  public $comentario;
  public $usuario;

  public function __construct($id, $comentario, $usuario){
    $this->id=$id;
    $this->comentario=$comentario;
    $this->usuario = $usuario;
  }
}
?>
