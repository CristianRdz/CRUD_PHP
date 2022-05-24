
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
if (!empty(($_GET['id']))) {
    $id = $_GET['id'];
} else {
    $id = null;
    header("Location: consulta.php");
}
if (!empty($id)) {

    /*-------- nos conectamos a la base --------*/
    $conexion = new mysqli('localhost', 'root', '', 'tienda');

    if ($conexion->connect_error) {
        die($errores[] = "No se pudo conectar la bd" . $conexion->connect_error);
    }

    /*-------- Verificamos que exista alguien con ese id --------*/
    $sql = "SELECT * FROM `usuarios` WHERE `idUsuario`=$id";
    $result = $conexion->query($sql);

    if (empty($result)) {
        $errores[] = "No existe ningun usuario con ese ID.";
    }

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $usuario = $row["usuario"];
            $nombre = $row["nombre"];
            $correoElectronico = $row["nombre"];
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

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width,minimum-scale=1.0" name="viewport" />
    <meta http-equiv="Content-Type" content="text/html" />
    <title>Detalles de usuarios</title>
</head>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<?php barramenu(); ?>

<body>
    <h1 align="center">Detalles de usuarios</h1>

    <form action="usuarios.php" method="POST" target="_self">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Nombre:</div>
                <div class="col-md-4">
                    <input readonly class="form-control" type="text" name="nombre" required value="<?php echo $nombre; ?>" placeholder="Nombre de usuario"></div>
                <div class="col-md-2">
                    Segundo nombre:</div>
                <div class="col-md-4">
                    <input readonly class="form-control" type="text" name="segundoNombre" value="<?php echo $segundoNombre; ?>"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Apellido Paterno:</div>
                <div class="col-md-4">
                    <input readonly class="form-control" type="text" name="apellidoPaterno" required value="<?php echo $apellidoPaterno; ?>" placeholder="Apellido paterno"></div>
                <div class="col-md-2">
                    Apellido Materno:</div>
                <div class="col-md-4">
                    <input readonly class="form-control" type="text" name="apellidoMaterno" value="<?php echo $apellidoMaterno; ?>" placeholder="Apellido materno"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Correo electr&oacute;nico:</div>
                <div class="col-md-4">
                    <input readonly class="form-control" type="email" name="correoElectronico" required value="<?php echo $correoElectronico; ?>" placeholder="Correo electr&oacute;nico"></div>
                <div class="col-md-2">
                    Usuario:</div>
                <div class="col-md-4">
                    <input readonly class="form-control" type="disabled" name="usuario" required value="<?php echo $usuario; ?>" placeholder="Usuario"></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    Nivel</div>
                <div class="col-md-4">
                    <input readonly class="form-control" type="text" name="nivel" required value="<?php echo $nivel; ?>" placeholder="1-100"></div>
            </div>
            <br>
            <div class="row">
                <a class="btn btn-lg  btn-block" style="background-color: darkred; color:white;" href="consulta.php">Regresar</a>
            </div>
            <br>
    </form>





</body>

</html>