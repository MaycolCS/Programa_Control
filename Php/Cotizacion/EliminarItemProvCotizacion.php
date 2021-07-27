<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(12,22,16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }

    /* Aqui empieza el código */

    $TiempoEntrega= $_GET['TE'];
    $Descuento= $_GET['DCTO'];
    $nitTercero= $_GET['NT'];
    $plantaTercero= $_GET['PT'];
    $codeProvCotizacion= $_GET['IPC'];
    $CodeItem= $_GET['COIT'];

    $conn = conexionBD();
    $sql = "DELETE FROM cotizacion_itemsprovisional WHERE cotizacion_itemsprovisional_Id='$CodeItem'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&IPC=$codeProvCotizacion&NT=$nitTercero&TE=$TiempoEntrega&DCTO=$Descuento&msj=IEC");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&IPC=$codeProvCotizacion&NT=$nitTercero&TE=$TiempoEntrega&DCTO=$Descuento&msj=EEIC");
        exit();
    }

?>