<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH . '/core/modelo/Usuario.php';
require_once $ROOT_PATH . '/core/modelo/Incidencia.php';

class Database {

  //private static $INSTANCE;
  private $mysqli;

  public function __construct() {
    /*$hostname = "localhost";
    $username1 = "tw";
    $password1 = "KpxlwisaphBmGOVD";
    $databaseName1 = "tw_proyecto";
    /*FZkuCumUMWErcqfb
    //KpxlwisaphBmGOVD*/
    $hostname = "localhost";
    $username1 = "paularg981819";
    $password1 = "fuExW4c7";
    $username2 = "lauragogar1819";
    $password2 = "KdnkJuSY";
    $databaseName1 = "paularg981819";
    $databaseName2 = "lauragogar1819";
    $this->mysqli = new mysqli($hostname, $username2, $password2, $databaseName2);
/*    if(!$this->mysql){
      $this->mysqli = new mysqli($hostname, $username1, $password1, $databaseName1);
    }*/

    if (mysqli_connect_errno()) {
      $this->mysqli = new mysqli($hostname, $username1, $password1, $databaseName1);
      if(mysqli_connect_errno()){
        printf("Conexión errónea: %s\n", mysqli_connect_error());
        exit();
      }
    }
        $this->mysqli->set_charset("utf8");
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
  }

  public function consulta($consulta){
    return $this->mysqli->query($consulta);
  }

  //orden(fecha,positivas,neto),estado='Pendiente','Comprobada','Tramitada','Irresoluble','Resuelta' o NULL
  public function getIncidenciasTituloDesc($orden,$clave,$estado,$lugar){
    $texto="SELECT Incidencias.identificador FROM Incidencias WHERE ";
    if(!is_null($estado)){
      $texto.="Incidencias.estado = ? AND ";
    }
    $texto.="Incidencias.lugar = ? AND Incidencias.titulo LIKE CONCAT('%',?,'%') ORDER BY ";
    if(strcmp($orden,"neto")==0){
      $texto.="Incidencias.positivas - Incidencias.negativas";
    }else {
      $texto.="Incidencias.".$orden;
    }
    $texto.=" DESC";

    $stmt=$this->mysqli->prepare($texto);

    if(!is_null($estado)){
      $stmt->bind_param("sss",$estado,$lugar,$clave);
    }else{
      $stmt->bind_param("ss",$lugar,$clave);
    }
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getIncidenciasDescripcionDesc($orden,$clave,$estado,$lugar){
    $texto="SELECT Incidencias.identificador FROM Incidencias WHERE ";
    if(!is_null($estado)){
      $texto.="Incidencias.estado = ? AND ";
    }
    $texto.="Incidencias.lugar = ? AND Incidencias.descripcion LIKE CONCAT('%',?,'%') ORDER BY ";
    if(strcmp($orden,"neto")==0){
      $texto.="Incidencias.positivas - Incidencias.negativas";
    }else {
      $texto.="Incidencias.".$orden;
    }
    $texto.=" DESC";
    $stmt=$this->mysqli->prepare($texto);
    if(!is_null($estado)){
      $stmt->bind_param("sss",$estado,$lugar,$clave);
    }else{
      $stmt->bind_param("ss",$lugar,$clave);
    }
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getIncidenciasClaveDesc($orden,$clave,$estado,$lugar){
    $texto="SELECT Incidencias.identificador FROM Incidencias WHERE ";
    if(!is_null($estado)){
      $texto.="Incidencias.estado = ? AND ";
    }
    $texto.="Incidencias.lugar = ? AND Incidencias IN (SELECT RelClaveIncidencia.incidencia WHERE RelClaveIncidencia LIKE CONCAT('%',?,'%')) ORDER BY ";
    if(strcmp($orden,"neto")==0){
      $texto.="Incidencias.positivas - Incidencias.negativas";
    }else {
      $texto.="Incidencias.".$orden;
    }
    $texto.=" DESC";
    $stmt=$this->mysqli->prepare($texto);
    if(!is_null($estado)){
      $stmt->bind_param("sss",$estado,$lugar,$clave);
    }else{
      $stmt->bind_param("ss",$lugar,$clave);
    }
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getUsuariosIncDesc(){
    $texto="SELECT Usuarios.identificador FROM Usuarios JOIN Incidencias ON (Incidencias.usuario = Usuarios.identificador) GROUP BY Incidencias.usuario ORDER BY COUNT(Incidencias.identificador) ";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getUsuariosComDesc(){
    $texto="SELECT Usuarios.identificador FROM Usuarios JOIN Comentarios ON (Comentarios.usuario = Usuarios.identificador) GROUP BY Comentarios.usuario ORDER BY COUNT(Comentarios.identificador) ";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getUsuarios(){
    $texto="SELECT Usuarios.identificador FROM Usuarios";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->execute();
    $result=$stmt->get_result();
    $usuarios=array();
    while ($row=$result->fetch_assoc()) {
      $usuarios[$row['identificador']]=$this->getUsuarioById($row['identificador']);
    }
    $stmt->close();
    return $usuarios;
  }

  public function getNumIncidenciasResueltas(){
    $texto="SELECT COUNT(Incidencias.identificador) FROM Incidencias WHERE Incidencias.estado = ? ";
    $stmt=$this->mysqli->prepare($texto);
    $a="Resuelta";
    $stmt->bind_param("s",$a);
    $stmt->execute();
    $result=$stmt->get_result();
    $result=$result->fetch_row()[0];
    $stmt->close();
    return $result;
  }

  public function getNumIncidenciasPendientes(){
    $texto="SELECT COUNT(Incidencias.identificador) FROM Incidencias WHERE Incidencias.estado = ? ";
    $stmt=$this->mysqli->prepare($texto);
    $a="Pendiente";
    $stmt->bind_param("s",$a);
    $stmt->execute();
    $result=$stmt->get_result();
    $result=$result->fetch_row()[0];
    $stmt->close();
    return $result;
  }

  public function getIncidenciasUsuario($identificadorUsu){
    $texto="SELECT Incidencias.identificador FROM Incidencias WHERE Incidencias.usuario=? ORDER BY Incidencias.fecha DESC";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("s",$identificadorUsu);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getIncidencia($identificador){
    $texto="SELECT Incidencias.identificador, Incidencias.titulo, Incidencias.lugar, Incidencias.descripcion, Incidencias.fecha, Incidencias.positivas, Incidencias.negativas, Incidencias.estado, Incidencias.usuario FROM Incidencias WHERE Incidencias.identificador=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("s",$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }


  public function getComentariosIncidencia($identificador){
    $texto="SELECT Comentarios.identificador, Comentarios.usuario, Comentarios.incidencia, Comentarios.comentario FROM Comentarios WHERE Comentarios.incidencia=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getPalabrasClave($identificador){
    $texto="SELECT RelClaveIncidencia.clave FROM RelClaveIncidencia WHERE RelClaveIncidencia.incidencia=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $string = "";
    while ($row=$result->fetch_assoc()) {
      $string.=$row['clave'].", ";
    }
    $string=trim($string,', ');
    $stmt->close();
    return $string;
  }

  public function nuevaIncidencia($titulo,$lugar,$descripcion,$estado,$usuario){
    $texto="INSERT INTO Incidencias(titulo,lugar,descripcion,estado,usuario) VALUES (?,?,?,?,?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("ssssi",$titulo,$lugar,$descripcion,$estado,$usuario);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();

    $texto="SELECT Incidencias.identificador FROM Incidencias WHERE(Incidencias.titulo=? AND Incidencias.lugar=? AND Incidencias.descripcion=? AND Incidencias.estado=? AND Incidencias.usuario=?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("ssssi",$titulo,$lugar,$descripcion,$estado,$usuario);
    $stmt->execute();
    $result=($stmt->get_result()->fetch_assoc())['identificador'];
    $stmt->close();
    return $result;
  }

  public function nuevoUsuario($nombre,$familia,$email,$direccion,$telefono,$password,$rango,$estado){
    $texto="INSERT INTO Usuarios (nombre,familia,email,direccion,telefono,password,rango,estado) VALUES (?,?,?,?,?,?,?,?) ORDER BY Incidencia.identificador DESC";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("ssssssss",$nombre,$familia,$email,$direccion,$telefono,$password,$rango,$estado);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();

    $texto="SELECT Usuarios.identificador FROM Usuarios WHERE(Usuarios.nombre=? AND Usuarios.familia=? AND Usuarios.email=? AND Usuarios.direccion=? AND Usuarios.telefono=? AND Usuarios.password=? AND Usuarios.rango=? AND Usuarios.estado=?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("ssssssss",$nombre,$familia,$email,$direccion,$telefono,$password,$rango,$estado);
    $stmt->execute();
    $result=($stmt->get_result()->fetch_assoc())['identificador'];
    $stmt->close();
    return $result;
  }


  public function nuevaValoracionUsuario($identificadorUsu,$identificadorInci,$tipoValoracion){
    $texto="INSERT INTO Valoracion (usuario,incidencia,valoracion) VALUES (?,?,?)";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("iis",$identificadorUsu,$identificadorInci,$tipoValoracion);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close(); //¿Hay que ponerlo aquí?
    return $result + $this->nuevaValoracionAnonima($identificadorInci,$tipoValoracion);
  }

  public function nuevaValoracionAnonima($identificadorInci,$tipoValoracion){
    $texto="UPDATE Incidencias SET ";
    if(strcmp($tipoValoracion,"Positiva")){
      $texto.=" positivas = positivas + 1 ";
    }else{
      $texto.=" negativas = negativas + 1 ";
    }
    $texto.="WHERE identificador=".$identificadorInci;
    $stmt = $this->mysqli->prepare($texto);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function nuevoComentario($identificadorUsu,$identificadorInci,$comentario){
    $texto="INSERT INTO Comentarios (usuario,incidencia,comentario) VALUES (?,?,?)";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("iis",$identificadorUsu,$identificadorInci,$comentario);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function nuevoLog($descripcion){
    $texto="INSERT INTO Log (descripcion) VALUES (?)";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("s",$descripcion);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getLog(){
    $texto="SELECT Log.identificador, Log.fecha, Log.descripcion FROM Log ORDER BY Log.fecha DESC";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function modificarDatosRangoColaborador($identificador,$nombre,$familia,$email,$direccion,$telefono){
    $texto="UPDATE Usuarios SET nombre=?, familia=?, email=?, direccion=?, telefono=? WHERE identificador=?";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("sssssi",$nombre,$familia,$email,$direccion,$telefono,$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function modificarDatosRangoAdministrador($identificador,$nombre,$familia,$email,$direccion,$telefono,$rango,$estado){
    $texto="UPDATE Usuarios SET nombre=?, familia=?, email=?, direccion=?, telefono=?, rango=?, estado=? WHERE identificador=?";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("sssssssi",$nombre,$familia,$email,$direccion,$telefono,$rango,$estado,$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function modificarContraseña($identificador,$contraseña){
    $texto="UPDATE Usuarios SET password=? WHERE identificador=?";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("si",$contraseña,$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function modificarExtImagen($identificador,$extImagen){
    $texto="UPDATE Usuarios SET extImagen=? WHERE identificador=?";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("si",$extImagen,$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function modificarIncidencia($identificador,$titulo,$lugar,$descripcion){
    $texto="UPDATE Incidencias SET titulo=?,lugar=?,descripcion=? WHERE identificador=?";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("sssi",$titulo,$lugar,$descripcion,$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $this->getIncidencia($identificador);
  }

  public function modificarEstadoIncidencia($identificador,$estado){
    $texto="UPDATE Incidencias SET estado=? WHERE identificador=?";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("si",$estado,$identificador);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $this->getIncidencia($identificador);
  }

  public function nuevaImagen($identificadorInci,$ext){
    $texto="INSERT INTO Imagenes (incidencia,extension) VALUES (?,?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("is",$identificadorInci,$ext);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $this->getImagen($identificadorInci);
  }

  public function getImagen($identificadorInci){
    $texto="SELECT Imagenes.identificador, Imagenes.extension FROM Imagenes WHERE Imagenes.incidencia=? ORDER BY Imagenes.identificador DESC";
    $stmt = $this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificadorInci);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function borrarIncidencia($identificador){
    $texto="DELETE FROM Valoracion WHERE Valoracion.incidencia=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificadorInci);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    $texto="DELETE FROM Comentarios WHERE Comentarios.incidencia=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificadorInci);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    $texto="DELETE FROM Imagenes WHERE Imagenes.incidencia=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificadorInci);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    $texto="DELETE FROM RelClaveIncidencia WHERE RelClaveIncidencia.incidencia=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificadorInci);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    $texto="DELETE FROM Incidencias WHERE Incidencias.identificador=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("i",$identificadorInci);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function borrarRelClaveIncidencia($clave,$incidencia){
    $texto="DELETE FROM RelClaveIncidencia WHERE (RelClaveIncidencia.incidencia=? AND RelClaveIncidencia.clave=?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("is",$incidencia,$clave);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
  }

  public function borrarUsuario($identificadorUsu){
    $texto="SELECT Incidencias.identificador FROM Incidencias WHERE Incidencias.usuario=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("s",$identificadorUsu);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    while ($row=$result->fetch_assoc()) {
      $this->borrarIncidencia($row['identificador']);
    }
    /*
    foreach ($result as $key => $value) {
      $this->borrarIncidencia($value);
    }*///DUDA: ¿Elimino también las valoraciones y los comentarios realizados por dicho usuario?
    $texto="DELETE FROM Comentarios WHERE Comentarios.usuario=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("s",$identificadorUsu);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    $texto="DELETE FROM Usuarios WHERE Usuarios.identificador=?";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("s",$identificadorUsu);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
  }

  public function getAllLugares(){
    $texto="SELECT DISTINCT Incidencias.lugar FROM Incidencias";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }


  public function existePalabraClave($clave){
    $texto="SELECT PalabrasClave.clave FROM PalabrasClave WHERE(PalabrasClave.clave=?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("s",$clave);
    $stmt->execute();
    $result=$stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result;
  }

  public function nuevaPalabraClave($clave){
    $texto="INSERT INTO PalabrasClave(clave) VALUES (?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("s",$clave);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function nuevaRelClaveIncidencia($incidencia,$clave){
    $texto="INSERT INTO RelClaveIncidencia(clave,incidencia) VALUES (?,?)";
    $stmt=$this->mysqli->prepare($texto);
    $stmt->bind_param("si",$clave,$incidencia);
    $stmt->execute();
    $result=$stmt->get_result();
    $stmt->close();
    return $result;
  }

  public function getUsuarioByEmail($email) {
   $queryUsuarios = "SELECT * FROM Usuarios WHERE email=?";
   $stmt = $this->mysqli->prepare($queryUsuarios);
   $stmt->bind_param("s", $email);
   $stmt->execute();
   $resultUsuario = $stmt->get_result();
   $usuario = null;
   if ($row = $resultUsuario->fetch_assoc()) {
       $usuario = new Usuario($row["identificador"], $row["nombre"], $row["familia"], $row["email"], $row["direccion"], $row["telefono"], $row["password"], $row["rango"], $row["estado"],$row['extImagen']);
   }
   $stmt->close();
   return $usuario;
 }


  public function getUsuarioById($id) {
  $queryUsuarios = "SELECT * FROM Usuarios WHERE identificador=?";
  $stmt = $this->mysqli->prepare($queryUsuarios);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $resultUsuario = $stmt->get_result();
  $usuario = NULL;
  if ($row = $resultUsuario->fetch_assoc()) {
    $usuario = new Usuario($row["identificador"], $row["nombre"], $row["familia"], $row["email"], $row["direccion"], $row["telefono"], $row["password"], $row["rango"], $row["estado"],$row['extImagen']);
  }
  $stmt->close();
  return $usuario;
  }
}
?>
