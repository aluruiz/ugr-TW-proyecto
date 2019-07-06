<?php

class Usuario{
  public $id;
  public $nombre;
  public $familia;
  public $email;
  public $direccion;
  public $telefono;
  public $password;
  public $rango;
  public $estado;
  public $extImagen;

  public function __construct($id, $nombre, $familia, $email, $direccion, $telefono, $password, $rango, $estado,$extImagen){
    $this->id=$id;
    $this->nombre=$nombre;
    $this->familia=$familia;
    $this->email=$email;
    $this->direccion=$direccion;
    $this->telefono=$telefono;
    $this->password=$password;
    $this->rango=$rango;
    $this->estado=$estado;
    $this->extImagen=$extImagen;
  }
}
?>
