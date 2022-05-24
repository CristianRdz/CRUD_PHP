
<?php
session_start();
include 'funciones.php';
$ingreso=($_SESSION["ingreso"]);
if (!empty($ingreso)) {
    unset($_SESSION['ingreso­']);
} else {
    $ingreso = null;
}
     if (empty($ingreso)) {
         header('location: ingreso.php');
     }

if (!empty($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    unset($_POST['nombre']);
} else {
    $nombre = null;
}


if (!empty($_POST['segundoNombre'])) {
    $segundoNombre = $_POST['segundoNombre'];
    unset($_POST['segundoNombre']);
} else {
    $segundoNombre = null;
}


if (!empty($_POST['apellidoPaterno'])) {
    $apellidoPaterno = $_POST['apellidoPaterno'];
    unset($_POST['apellidoPaterno']);
} else {
    $apellidoPaterno = null;
}


if (!empty($_POST['apellidoMaterno'])) {
    $apellidoMaterno = $_POST['apellidoMaterno'];
    unset($_POST['apellidoMaterno']);
} else {
    $apellidoMaterno = null;
}


if (!empty($_POST['correoElectronico'])) {
    $correoElectronico = $_POST['correoElectronico'];
    unset($_POST['correoElectronico']);
} else {
    $correoElectronico = null;
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


if (!empty($_POST['passConfirmado'])) {
    $passConfirmado = $_POST['passConfirmado'];
    unset($_POST['passConfirmado']);
} else {
    $passConfirmado = null;
}
if (!empty($_POST['nivel'])) {
    $nivel = $_POST['nivel'];
    unset($_POST['nivel']);
} else {
    $nivel = null;
}


if (!empty($_POST['siguientePaso'])) {
    $siguientePaso = $_POST['siguientePaso'];
    unset($_POST['siguientePaso']);
} else {
    $siguientePaso = null;
}



if ($siguientePaso == 2) { // Este paso es cuando se enviaron el formulario

    if ($conexion = @mysqli_connect('localhost', 'root', '')) {
        if (!mysqli_select_db($conexion, 'tienda')) {
				mysqli_close($conexion); $error['noDB'] = "Error 1002: No se pudo conectar con la base de datos.";
			}
    } else {
        $errores['noCxn'] = "Error: 1001. No fue posible realizar la conexi&oacute;n";
    }

    if (empty($nombre)) {
        $errores[] = "Debe de escribir el nombre del usuario.";
    }

    if (empty($apellidoPaterno)) {
        $errores[] = "Debe de escribir el apellido paterno.";
    }

    if (!empty($correoElectronico)) {
        $sentenciaSql = "SELECT correoElectronico FROM usuarios WHERE correoElectronico = '$correoElectronico' AND activo='1' LIMIT 1";
        $resultadoConsulta = mysqli_query($conexion, $sentenciaSql);
        $dato = mysqli_fetch_assoc($resultadoConsulta);
        if (!empty($dato)) {
            $errores[] = 'Ya existe un usuario con ese correo. Favor de escribir uno diferente.';
        }
    } else {
        $errores[] = "Debe proporcionar un correo electr&oacute;nico.";
    }





    if (!empty($usuario)) {
        $sentenciaSql = "SELECT usuario FROM usuarios WHERE usuario = '$usuario' AND activo='1' LIMIT 1";
        $resultadoConsulta = mysqli_query($conexion, $sentenciaSql);
        $dato = mysqli_fetch_assoc($resultadoConsulta);
        if (!empty($dato)) {
            $errores[] = 'Ya existe un usuario con ese nickname. Favor de escribir uno diferente.';
        }
    } else {
        $errores[] = "No ha escrito el usuario.";
    }




    if (empty($pass)) {
        $errores[] = "Debe escribir una contrase&ntilde;a.";
    }

    if (empty($passConfirmado)) {
        $errores[] = "Debe confirmar la contrase&ntilde;a.";
    }

    if ($pass != $passConfirmado) {
        $errores[] = "La contrase&ntilde;a no coinciden";
    }
    if (empty($nivel)) {
        $errores[] = "Debe poner un nivel.";
    }
    if (empty($errores)) {
        // Para guardar los datos
       
        $pass = password_hash($pass, PASSWORD_DEFAULT);



        $sentenciaSql = "INSERT INTO usuarios(nombre, segundoNombre, apellidoPaterno, apellidoMaterno, correoElectronico, usuario, pass, nivel)
				VALUES('$nombre', '$segundoNombre', '$apellidoPaterno', '$apellidoMaterno', '$correoElectronico', '$usuario', '$pass', '$nivel')";

        if (mysqli_query($conexion, $sentenciaSql)) {
            $siguientePaso = 3;
        } else {
            echo "ERROR AL GUARDAR LA INFORMACIÓN";
        }
    } else {
        $siguientePaso = null;
    }
} // Finalizo del paso 2

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta content="width=device-width,minimum-scale=1.0" name="viewport" />
	<meta property="El pueblo" content="Ejercicios de yautli" />
	<meta http-equiv="Content-Type" content="text/html" />
	<title>Registro de usuarios</title>
</head>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<?php barramenu();?>
<body>
	<h1 align="center">Registro de usuarios</h1>

	<?php
    if (!empty($errores)) {
        foreach ($errores as $error) { // recorremos el arreglo
            echo "<div class='alert alert-danger' role='alert'>
			$error
		  </div>";
        }
    }
    ?>


	<?php if ($siguientePaso == 3) { ?>
		<div class="alert alert-success" role="alert">
		La informaci&oacute;n se ha guardado correctamente </div>
		<a href="usuarios.php" target="_self">Regresar</a>
	<?php }	?>

	<?php if (empty($siguientePaso)) { ?>

		<form action="usuarios.php" method="POST" target="_self">
			<input class="form-control" type="hidden" name="siguientePaso" value="2">
			<div class="container">
				<div class="row">
					<div class="col-md-2" >
						Nombre:</div>
					<div class="col-md-4" >
						<input class="form-control" type="text" name="nombre" required value="<?php echo $nombre; ?>" placeholder="Nombre de usuario"></div>
					<div class="col-md-2" >
						Segundo nombre:</div>
					<div class="col-md-4" >
                        <input class="form-control" type="text" name="segundoNombre" value="<?php echo $segundoNombre; ?>" placeholder="Segundo nombre"></div>
                        </div>
	</div>
			<div class="container">
				<div class="row">
					<div class="col-md-2" >
					Apellido Paterno:</div>
					<div class="col-md-4" >
					<input class="form-control" type="text" name="apellidoPaterno" required value="<?php echo $apellidoPaterno; ?>" placeholder="Apellido paterno"></div>
					<div class="col-md-2" >
					Apellido Materno:</div>
					<div class="col-md-4" >
					<input class="form-control" type="text" name="apellidoMaterno" value="<?php echo $apellidoMaterno; ?>" placeholder="Apellido materno"></div>
                        </div>
	</div>
	<div class="container">
				<div class="row">
					<div class="col-md-2" >
					Correo electr&oacute;nico:</div>
					<div class="col-md-4" >
					<input class="form-control" type="email" name="correoElectronico" required value="<?php echo $correoElectronico; ?>" placeholder="Correo electr&oacute;nico"></div>
					<div class="col-md-2" >
					Usuario:</div>
					<div class="col-md-4" >
					<input class="form-control" type="text" name="usuario" required value="<?php echo $usuario; ?>" placeholder="Usuario"></div>
                        </div>
	</div>
	<div class="container">
				<div class="row">
					<div class="col-md-2" >
					Contrase&ntilde;a:</div>
					<div class="col-md-4" >
					<input class="form-control" type="password" name="pass" required value="<?php echo $pass; ?>"></div>
					<div class="col-md-2" >
					Confirmar contrase&ntilde;a:</div>
					<div class="col-md-4" >
					<input class="form-control" type="password" name="passConfirmado" required value="<?php echo $passConfirmado; ?>"></div>
                        </div>
	</div>
	<div class="container">
				<div class="row">
					<div class="col-md-2" >
					Nivel</div>
					<div class="col-md-4" >
					<input class="form-control" type="text" name="nivel" required value="<?php echo $nivel; ?>" placeholder="1-100"></div>
    </div>
	<br>
	<div class="row">
					<input class="btn btn-block btn-lg" style="background-color: darkred; color:white;" type="submit" value="Registrar">
				</div>
				<br>	
		</form>

	<?php }	?>





</body>

</html>