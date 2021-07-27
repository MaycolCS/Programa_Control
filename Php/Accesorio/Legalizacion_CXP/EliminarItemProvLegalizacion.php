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
    $Cotizacion = $_GET['COT'];
    $CentroCosto = $_GET['CCosto'];
    $Cliente = $_GET['NC'];
    $FacturaCompra = $_GET['FC'];
    $CodeItem= $_GET['COIT'];

    $conn = conexionBD();
    $sql = "DELETE FROM legalizacion_cxp_itemsprovisional WHERE legalizacion_itemsprovisional_Id='$CodeItem'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&COT=$Cotizacion&CCosto=$CentroCosto&NC=$Cliente&FC=$FacturaCompra&msj=IELEG");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&COT=$Cotizacion&CCosto=$CentroCosto&NC=$Cliente&FC=$FacturaCompra&msj=EEILEG");
        exit();
    }

?>