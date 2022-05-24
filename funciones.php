<?php
function conexionBD()
{
  if ($conexion = @mysqli_connect('localhost', 'root', '')) {
    if (!mysqli_select_db($conexion, 'tienda')) {
      mysqli_close($conexion);
      $error['noDB'] = "Error 1002: No se pudo conectar con la base de datos.";
    }
  } else {
    $errores['noCxn'] = "Error: 1001. No fue posible realizar la conexi&oacute;n";
  }

  if (empty($errores)) {
    return $conexion;
  } else {
    return false;
  }
}
function barramenu()
{
?>
  <nav class="navbar navbar-expand-lg navbar-dark " style="background-color: darkred;">

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        
          
          <li class="nav-item active">
          <a class="nav-link" href="usuarios.php">Registro Usuarios</a>
          </li>
          <li class="nav-item active">
          <a class="nav-link" href="subir.php">Subir</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="consulta.php">Consulta usuarios</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="cerrar.php">Cerrar</a>
          </li>
      </ul>
    </div>
  </nav>
<?php
}
?>