<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(22,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $Cotizacion= $_GET['cot'];
    $Cotizacion_MotivoAnulacion = $_POST['MotivoAnulacion'].". ANULADO POR: ".datosUsuario($Documento)['usuario_Nombre']." ".datosUsuario($Documento)['usuario_Apellido'];
    $conn = conexionBD();
    $sql = "UPDATE cotizacion Set cotizacion_Anulada='SI', cotizacion_MotivoAnulacion='$Cotizacion_MotivoAnulacion' WHERE cotizacion_Id='$Cotizacion'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OACOT&cot=$Cotizacion");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EACOT");
        exit();
    }

?>