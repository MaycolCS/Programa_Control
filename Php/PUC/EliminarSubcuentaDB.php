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
        $subcuentaPUC = $_GET['SCPUC'];
        $detalleSubcuentaPUC = nombrePucSubcuenta($subcuentaPUC);
        $conn = conexionBD();
        $sql = "DELETE FROM puc_subcuenta WHERE puc_subcuenta_Id='$subcuentaPUC'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OBSC");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: EliminarSubcuenta? cc=$Documento&cs=$CS&msj=EBSC");
            exit();
        }
    }

?>