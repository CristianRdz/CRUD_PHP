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
$conexion = conexionBD();
$sentenciaSQL = "SELECT * FROM usuarios WHERE activo='1'";
if ($resultado = mysqli_query($conexion, $sentenciaSQL)) {
    while ($consulta = mysqli_fetch_array($resultado)) {
        $arregloConsulta[] = $consulta;
    }
}
if (!empty(($_GET['id'])) and !empty(($_GET['eliminar']))) {
    $eliminar = $_GET['eliminar'];
    $id = $_GET['id'];
    $check = 3;
} else {
    $eliminar = null;
    $id = null;
    $check = 2;
}
if ($eliminar == "si") {
    $sentenciaSql = "UPDATE `usuarios` SET `activo` = '0' WHERE `usuarios`.`idUsuario` = $id";
    $resultadoConsulta = mysqli_query($conexion, $sentenciaSql);
    if (!empty($resultadoConsulta)) {
    }
} else {
}
if (!empty(($_GET['eliminado']))) {
    $eliminado = $_GET['eliminado'];
    unset($_GET['eliminado']);
} else {
    $eliminado = null;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Consulta de usuarios</title>
    <link rel="stylesheet" href="cssBoots/bootstrap.css">
</head>
<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<?php barramenu(); ?>

<body>
<h1 align="center">Consulta de usuarios</h1>
    <?php if ($check == 3) { ?>
        <?php header("Location: consulta.php?eliminado=2"); ?>
    <?php }    ?>

    <?php if ($eliminado ==2) { ?>
        <div class="alert alert-success alert-dismissible fade show block w-25 mx-auto" role="alert">
						Se elimino con exito
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
    <?php }    ?>
    <div class="container">
        <table class="table table-bordered table-hover">
            <thead class="thead" style="background-color: darkred; color:white;">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Usuario</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($arregloConsulta)) {
                    $i = 0;

                    foreach ($arregloConsulta as $datoConsulta) {
                        $i++; ?>

                        <tr>
                            <td>
                                <?php echo  $datoConsulta['idUsuario']; ?>
                            </td>
                            <td>
                                <?php echo  $datoConsulta['nombre'] . ' ' . $datoConsulta['segundoNombre'] . ' ' . $datoConsulta['apellidoMaterno'] . ' ' . $datoConsulta['apellidoPaterno']; ?>
                            </td>
                            <td>
                                <?php echo  $datoConsulta['correoElectronico']; ?>
                            </td>
                            <td>
                                <?php echo  $datoConsulta['usuario']; ?>
                            </td>
                            <td>
                                <a class="btn btn-lg btn-success btn-block" href="<?php echo  "detalles.php?id=" . $datoConsulta['idUsuario']; ?>" target="_self">Ver</a>
                            </td>
                            <td>
                                <a class="btn btn-lg btn-danger btn-block" href="<?php echo  "consulta.php?id=" . $datoConsulta['idUsuario'] . "&eliminar=si"; ?>" target="_self">Eliminar</a>
                            </td>
                            <td>
                                <a class="btn btn-lg btn-warning btn-block" href="<?php echo  "modificar.php?id=" . $datoConsulta['idUsuario']; ?>" target="_self">Modificar</a>
                            </td>

                        </tr>

                <?php   }
                } ?>

            </tbody>
        </table>
    </div>


</body>

</html>