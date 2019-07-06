<?php
require_once './controlador/herramientas/vendor/autoload.php';
require_once './core/BaseDeDatos.php';
require_once './login.php';
require_once './core/modelo/Aside.php';

if (isset($_GET['download'])) {
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="db_backup.sql"');
      echo DB_backup();
} else {
  $copia = $_SERVER['SCRIPT_NAME']."?download";
}

  $aside=new Aside(3);
  $database = new Database();
  $idLogeado = getUsuarioLogged();
  $loggedUser = $database->getUsuarioById($idLogeado);

  $loader = new \Twig\Loader\FilesystemLoader('.');
  $twig = new \Twig\Environment($loader);

  $ruta = "vista/copiaBD.html";
  $template = $twig -> load($ruta);
  $argumentos = [];
  $argumentos["loggedUser"] = $loggedUser;
  $argumentos["aside"]=$aside;
  $argumentos["copiaBD"]=$copia;

  echo $template -> render($argumentos);

  function DB_backup(){
    $db = new Database();
  //Obtener listado de tablas
    $tablas = array();
    $result = $db->consulta('SHOW TABLES');
    while($row = mysqli_fetch_row($result)){
      $tablas[] = $row[0];
    }
  //Salvar cada tabla
    $salida= '';
    foreach ($tablas as $tab) {
      $result = $db->consulta('SELECT * FROM '.$tab);
      $num = mysqli_num_fields($result);
      $salida .= 'DROP TABLE '.$tab.';';
      $row2 = mysqli_fetch_row($db->consulta('SHOW CREATE TABLE '.$tab));
      $salida .= "\n\n".$row2[1].";\n\n"; // row2[0]=nombre de tabla
      while ($row = mysqli_fetch_row($result)) {
        $salida .= 'INSERT INTO '.$tab.' VALUES(';
        for ($j=0; $j<$num; $j++) {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
          if (isset($row[$j]))
            $salida .= '"'.$row[$j].'"';
          else
            $salida .= '""';
          if ($j < ($num-1)) $salida .= ',';
        }
        $salida .= ");\n";
      }
      $salida .= "\n\n\n";
    }
    return $salida;
  }

?>
