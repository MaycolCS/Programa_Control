<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $PlantaTercero= $_GET['PT'];
    $conn = conexionBD();
    $sql = "DELETE FROM planta_tercero WHERE planta_tercero_Id='$PlantaTercero'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OBPT");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EBPT");
        exit();
    }

?>