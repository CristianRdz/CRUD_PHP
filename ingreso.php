<?php
session_start();
if (!empty($_SESSION['ingreso'])) {
  header('location: usuarios.php');
} else {
}

if (!empty($_POST['usuario'])) {
  $usuario = $_POST['usuario'];
  unset($_POST['usuario']);
} else {
  $usuario = null;
}
if (!empty($_POST['pass'])) {
  $pass = $_POST['pass'];
  unset($_POST['pass']);
} else {
  $pass = null;
}
if (!empty($_POST['siguientePaso'])) {
  $siguientePaso = $_POST['siguientePaso'];
  unset($_POST['siguientePaso']);
} else {
  $siguientePaso = null;
}

if ($siguientePaso == 2) { // Este paso es cuando se enviaron el formulario

  $conexion = new mysqli('localhost', 'root', '', 'tienda');
  if ($conexion->connect_error) {
    die($errores[] = "No se pudo conectar la bd" . $conexion->connect_error);
  }

  $sql = "SELECT  usuario, pass FROM usuarios where usuario='$usuario'";
  $result = $conexion->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      if ($usuario == $row["usuario"] and password_verify($pass, $row["pass"])) {
        session_start();
        $_SESSION['ingreso'] = "si";
        header("Location: usuarios.php");
      } else {
        $errores[] = "El usuario no esta registrado o la contraseña es incorrecta";
      }
    }
  } else {
    $errores[] = "El usuario no esta registrado o la contraseña es incorrecta";
  }
  $conexion->close();
}



?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Daniela">
  <meta name="generator" content="Jekyll v4.1.1">
  <title>Ingreso</title>


  <!-- Bootstrap core CSS -->
  <link href="ingreso/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="ingreso/signin.css" rel="stylesheet">
</head>

<body class="text-center">


  <form class="form-signin" action="ingreso.php" method="POST" target="_self">
    <input class="form-control" type="hidden" name="siguientePaso" value="2">
    <?php
    if (!empty($errores)) {
      foreach ($errores as $error) { // recorremos el arreglo
        echo "<br><div class='alert alert-danger' role='alert'>
      $error
      </div>";
      }
    }
    ?>

    <img class="mb-4" src="ingreso/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Ingresar usuario y contraseña</h1>
    <label for="usuario" class="sr-only">Usuario</label>
    <input name="usuario" type="text" id="usuario" class="form-control" placeholder="Usuario" required value="<?php echo $usuario; ?>">
    <label for="password" class="sr-only">Contraseña</label>
    <input name="pass" type="password" id="password" class="form-control" placeholder="Contraseña" required value="<?php echo $pass; ?>">
    <button class="btn btn-lg  btn-block" style="background-color: darkred; color:white;" type="submit">Iniciar sesión</button>

  </form>
</body>

</html>