<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(14,16,24,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $Remision= $_GET['REM'];
    $ValorRemision= $_GET['VLREM'];
    $nitTercero = $_GET['TR'];
    $codeProvFV= $_GET['IPFV'];
    if ($codeProvFV == 0) {
        $NumAlt = rand(1000,20000);
        while (estacodeProvFV($IdProvisional)) {
            $NumAlt = rand(1000,20000);
        }
        $codeProvFV = $NumAlt;
    }

    if (estaRemision__ProvFV($codeProvFV,$Remision)) {
        header("Location: IngresarFV? cc=$Documento&cs=$CS&IPFV=$codeProvFV&TR=$nitTercero&msj=REMEX");
        exit();
    }

    $conn = conexionBD();
    $sql = "INSERT INTO facturaventa_provisional 
            (facturaventa_provisional_CodeProv,
            facturaventa_provisional_Remision,
            facturaventa_provisional_Valor,
            facturaventa_provisional_Usuario) 
            VALUES ('$codeProvFV',
            '$Remision',
            '$ValorRemision',
            '$Documento')";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: IngresarFV? cc=$Documento&cs=$CS&IPFV=$codeProvFV&TR=$nitTercero&msj=REMADD");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: IngresarFV? cc=$Documento&cs=$CS&IPFV=$codeProvFV&TR=$nitTercero&msj=EREMADD");
        exit();
    }

?>