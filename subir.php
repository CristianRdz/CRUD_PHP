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

function tipoDearchivo($nombreDelArchivo)
{
    $cadena = explode('.', $nombreDelArchivo);
    return $cadena[1];
}


if (!empty($_FILES['miarchivo']['name'])) {
    if ($_FILES['miarchivo']['size'] < 5000000) {
        $nuevonombre = date('Y-m-d-H-i-s') . rand(100, 999) . '.' . tipoDearchivo($_FILES['miarchivo']['name']);
        if (move_uploaded_file($_FILES['miarchivo']['tmp_name'], 'uploads/' . $nuevonombre)) {
            if ($conexion = @mysqli_connect('localhost', 'root', '', 'tienda')) {
                $error[] = "No fue posible conectar con la BD";
            }


            $sql = "INSERT INTO archivos (nombreReferencia, nombreArchivo) VALUES ('tarea','$nuevonombre')";
            if (mysqli_query($conexion, $sql)) {
                echo "<h1 align='center'>El archivo se guardo correctamente</h1>";
                echo "<div align='center'><a href='uploads/$nuevonombre' target='_self'> Ver archivo </a><br>";
                echo "<a align='center' href='subir.php' target='_self'>Regresar</a><br>";
                echo "<a align='center' href='usuarios.php' target='_self'>Index</a><br></div>";
                exit();
            } else {
                $error[] = "El archivo se subio al servidor pero no se guardo en la BD";
            }
        } else {
            $error[] = "No se pudo guardar el archivo";
        }
    } else {
        $error[] = "El archivo no puede ser mayor a 5mb.";
    }
}

?>
<html lang="es">
<meta charset="utf-8">
<meta content="width=device-width,minimum-scale=1.0" name="viewport">
<title>Subir</title>

<head>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


    
</head>
<?php barramenu();?>
<body>
    <h1 align="center">Subida de archivos</h1>
    <?php
    if (!empty($error)) {
        foreach ($error as $dato) { // recorremos el arreglo
            echo "<div class='alert alert-danger' role='alert'>
			$dato
		  </div>";
        }
    }
    ?>


    <form align="center" action="subir.php" target="_self" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4" >
                    <label for="archivo">Selecciona un archivo para enviar:</label>
                    <input name="miarchivo" type="file" class="form-control-file" id="archivo">
                    <br>
                </div>
                <input class="btn btn-block btn-lg " style="background-color: darkred; color:white;" type="submit" value="Enviar archivo">
            </div>
        </div>
        </div>
    </form>

</body>

</html>