<?php

    $Code = $_POST['codeVer'];
    $Usuario = $_POST['usuario'];
    $Password = $_POST['contraseña'];

    include '../Funciones.php';

    $conexion = conexionBD();

    $estaDocumento = estaDocumento($Usuario);

    $sql = "";
    $Doc = FALSE;
    if ($estaDocumento == TRUE) {
        $datos = conexionBDUsuario();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($Usuario) == number_format($fila['usuario_Documento'])) {
                $Doc = TRUE;
                $Password = md5($Password, FALSE);
                if (number_format($Code) == number_format($fila['usuario_RC'])) {
                    $sql = "UPDATE usuario Set usuario_Contrasena='$Password', usuario_RC=NULL, usuario_Sesion=FALSE, usuario_IP=NULL WHERE usuario_Documento='$Usuario'";
                } else {
                    header("Location: RecuperarContrasena? msj=ECR");
                    exit();
                }
            }
        }
        if ($Doc==FALSE) {
            header("Location: RecuperarContrasena? msj=EDR");
            exit();
        } else {
            if (mysqli_query($conexion, $sql)) {
                mysqli_close($conexion);
                header("Location: ../Login.php? msj=CA");
                exit();
            } else {
                mysqli_close($conn);
                header("Location: ../Login.php? cc=$Documento&msj=ECA");
                exit();
            }
        }
    } else {
        header("Location: ../Login.php? msj=UNR");
        exit();
    }

?>