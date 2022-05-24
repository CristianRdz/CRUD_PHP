<?php
session_start();
include 'funciones.php';
$ingreso = ($_SESSION["ingreso"]);
if (!empty($ingreso)) {
    unset($_SESSION['ingreso­']);
} else {
    $ingreso = null;
}
if (empty($ingreso)) {
    header('location: ingreso.php');
}
if (!empty(($_REQUEST['id']))) {
    $id = $_REQUEST['id'];
    
} else {
    $id = null;
    header("Location: consulta.php");
}
if (!empty($id)) {
    $conexion = conexionBD();

    if ($conexion->connect_error) {
        die($errores[] = "No se pudo conectar la bd" . $conexion->connect_error);
    }
    $sql = "SELECT * FROM `usuarios` WHERE `idUsuario`=$id";
    $result = $conexion->query($sql);

    if (empty($result)) {
        $errores[] = "No existe ningun usuario con ese ID.";
    }

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $usuario = $row["usuario"];
            $nombre = $row["nombre"];
            $correoElectronico = $row["correoElectronico"];
            $segundoNombre = $row["segundoNombre"];
            $apellidoPaterno = $row["apellidoPaterno"];
            $apellidoMaterno = $row["apellidoMaterno"];
            $nivel = $row["nivel"];
        }
    } else {
        $errores[] = "El id no existe";
    }

    $conexion->close();
}
if (!empty($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    unset($_POST['nombre']);
} else {

}


if (!empty($_POST['segundoNombre'])) {
    $segundoNombre = $_POST['segundoNombre'];
    unset($_POST['segundoNombre']);
} else {

}


if (!empty($_POST['apellidoPaterno'])) {
    $apellidoPaterno = $_POST['apellidoPaterno'];
    unset($_POST['apellidoPaterno']);
} else {
    
}


if (!empty($_POST['apellidoMaterno'])) {
    $apellidoMaterno = $_POST['apellidoMaterno'];
    unset($_POST['apellidoMaterno']);
} else {
}


if (!empty($_POST['correoElectronico'])) {
    $correoElectronico = $_POST['correoElectronico'];
    unset($_POST['correoElectronico']);
} else {
}


if (!empty($_POST['usuario'])) {
    $usuario = $_POST['usuario'];
    unset($_POST['usuario']);
} else {
 
}

if (!empty($_POST['nivel'])) {
    $nivel = $_POST['nivel'];
    unset($_POST['nivel']);
} else {

}


if (!empty($_POST['siguientePaso'])) {
    $siguientePaso = $_POST['siguientePaso'];
    unset($_POST['siguientePaso']);
} else {
    $siguientePaso = null;
}



if ($siguientePaso == 2) { // Este paso es cuando se enviaron el formulario

    $conexion=conexionBD();

    if (empty($nombre)) {
        $errores[] = "Debe de escribir el nombre del usuario.";
    }

    if (empty($apellidoPaterno)) {
        $errores[] = "Debe de escribir el apellido paterno.";
    }

    if (empty($nivel)) {
        
    }
    if (empty($errores)) {

        $sentenciaSql = "UPDATE `usuarios` SET `nivel` = '$nivel',`nombre` = '$nombre', `segundoNombre` = '$segundoNombre', `apellidoPaterno` = '$apellidoPaterno', `apellidoMaterno` = '$apellidoMaterno', `correoElectronico` = '$correoElectronico', `usuario` = '$usuario'  WHERE `usuarios`.`idUsuario` = $id";

        if (mysqli_query($conexion, $sentenciaSql)) {
            $siguientePaso = 3;
        } else {
            echo "ERROR AL GUARDAR LA INFORMACIÓN";
        }
    } else {
        $siguientePaso = null;
    }
}




?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width,minimum-scale=1.0" name="viewport" />
    <meta http-equiv="Content-Type" content="text/html" />
    <title>Modificar de usuarios</title>
</head>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<?php barramenu(); ?>

<body>
    <h1 align="center">Modificar de usuarios</h1>
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
		<a href="consulta.php" target="_self">Regresar</a>
	<?php }	?>

	<?php if (empty($siguientePaso)) { ?>

    <form action="<?php echo "modificar.php?id=$id"; ?>" method="POST" target="_self">
        <input class="form-control" type="hidden" name="siguientePaso" value="2">
        <input class="form-control" type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Nombre:</div>
                <div class="col-md-4">
                    <input class="form-control" type="text" name="nombre" required value="<?php echo $nombre; ?>" placeholder="Nombre de usuario"></div>
                <div class="col-md-2">
                    Segundo nombre:</div>
                <div class="col-md-4">
                    <input class="form-control" type="text" name="segundoNombre" value="<?php echo $segundoNombre; ?>" placeholder="Segundo nombre"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Apellido Paterno:</div>
                <div class="col-md-4">
                    <input class="form-control" type="text" name="apellidoPaterno" required value="<?php echo $apellidoPaterno; ?>" placeholder="Apellido paterno"></div>
                <div class="col-md-2">
                    Apellido Materno:</div>
                <div class="col-md-4">
                    <input class="form-control" type="text" name="apellidoMaterno" value="<?php echo $apellidoMaterno; ?>" placeholder="Apellido materno"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Correo electr&oacute;nico:</div>
                <div class="col-md-4">
                    <input class="form-control" type="email" name="correoElectronico" required value="<?php echo $correoElectronico; ?>" placeholder="Correo electr&oacute;nico"></div>
                <div class="col-md-2">
                    Usuario:</div>
                <div class="col-md-4">
                    <input class="form-control" type="disabled" name="usuario" required value="<?php echo $usuario; ?>" placeholder="Usuario"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Nivel</div>
                <div class="col-md-4">
                    <input class="form-control" type="text" name="nivel" required value="<?php echo $nivel; ?>" placeholder="1-100"></div>
            </div>
            <br>
            <div class="row">
            <input class="btn btn-block btn-lg btn-dark" style="background-color: darkred; color:white;" type="submit" value="Modificar">
            </div>
            <br>
    </form>
<?php }	?>




</body>

</html>