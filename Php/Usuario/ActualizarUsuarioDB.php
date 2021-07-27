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
    
    /* Aqui empieza el código */

    $Usuario= $_GET['uc'];
    $NombrePost= $_POST['Nombre'];
    $Nombre= strtoupper($NombrePost);
    $ApellidoPost= $_POST['Apellido'];
    $Apellido= strtoupper($ApellidoPost);
    $Celular= $_POST['Celular'];
    $Correo= $_POST['email'];
    $Permiso1 = $_POST['Permiso1'];
    $Permiso2 = $_POST['Permiso2'];
    $Permiso3 = $_POST['Permiso3'];
    $Permiso4 = $_POST['Permiso4'];
    
    $conn = conexionBD();
    $sql = "UPDATE usuario Set usuario_Nombre='$Nombre', usuario_Apellido='$Apellido', usuario_Celular='$Celular', usuario_Correo='$Correo', usuario_Permiso_1='$Permiso1', usuario_Permiso_2='$Permiso2', usuario_Permiso_3='$Permiso3', usuario_Permiso_4='$Permiso4', usuario_Acceso='1' WHERE usuario_Documento='$Usuario'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OAU");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EAU");
        exit();
    }

?>