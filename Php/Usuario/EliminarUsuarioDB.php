<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $Usuario= $_POST['usuario'];
    if (!estaDocumento($Usuario)) {
        header("Location: EliminarUsuario.php? cc=$Documento&cs=$CS&msj=ESU");
        exit();
    }
    else {
        $conn = conexionBD();
        $NumAlt = rand(1000,20000);
        $Password = md5($NumAlt, FALSE);
        $sql = "UPDATE usuario Set usuario_Acceso='0', usuario_Permiso_1='0', usuario_Permiso_2='0', usuario_Permiso_3='0', usuario_Permiso_4='0', usuario_Contrasena='$Password', usuario_RC=NULL, usuario_Sesion=FALSE, usuario_IP=NULL WHERE usuario_Documento='$Usuario'";
        
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OBU");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EBU");
            exit();
        }
    }

?>