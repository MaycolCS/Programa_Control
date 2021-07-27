<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(15,16,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $Tercero= $_GET['NT'];
    $codeProvisionalLG= $_GET['IPLEG'];
    $CodeItem= $_GET['COIT'];

    $conn = conexionBD();
    $sql = "DELETE FROM legalizacion_cm_itemsprovisional WHERE legalizacion_itemsprovisional_Id='$CodeItem'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&msj=IELEG");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&msj=EEILEG");
        exit();
    }

?>