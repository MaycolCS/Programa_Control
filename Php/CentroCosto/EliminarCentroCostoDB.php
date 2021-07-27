<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    else if (!validarPermisosUsuario($Documento,array(25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    else {
        $CentroCosto= $_POST['CentroCosto'];
        $conn = conexionBD();
        $sql = "DELETE FROM centro_costo WHERE centro_costo_Consecutivo='$CentroCosto'";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OBCC");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: EliminarCentroCosto.php? cc=$Documento&cs=$CS&msj=EBCC");
            exit();
        }
    }

?>