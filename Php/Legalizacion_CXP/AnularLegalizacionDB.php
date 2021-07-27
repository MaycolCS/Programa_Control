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
        $Legalizacion= $_GET['LEG'];
        $conn = conexionBD();
        $sql = "UPDATE legalizacion_cxp Set legalizacion_cxp_Anulada='SI' WHERE legalizacion_cxp_Id='$Legalizacion'";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OALEGCXP&LEG=$Legalizacion");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EALEGCXP");
            exit();
        }
    }
?>