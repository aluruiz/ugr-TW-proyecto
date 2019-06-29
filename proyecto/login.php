<?php
  function getUsuarioLogged(){
    session_start();
    return $_SESSION['loggedUserId'] ?? null;
  }
?>
