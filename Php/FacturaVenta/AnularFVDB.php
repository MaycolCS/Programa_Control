<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(24,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $FacturaVenta= $_GET['FV'];
    $FacturaVenta_MotivoAnulacion= $_POST['MotivoAnulacion'].". ANULADO POR: ".datosUsuario($Documento)['usuario_Nombre']." ".datosUsuario($Documento)['usuario_Apellido'];
    $conn = conexionBD();
    $sql = "UPDATE facturaventa Set facturaventa_Anulada='SI', facturaventa_MotivoAnulacion='$FacturaVenta_MotivoAnulacion' WHERE facturaventa_Id='$FacturaVenta'";

    if (mysqli_query($conn, $sql)) {
        $ListaRemisionesFV = listadoRemisiones_FacturaVenta($FacturaVenta);
        $cont_ListaRemisionesFV = count($ListaRemisionesFV);
        $aux_cont_ListaRemisionesFV = 0;
        while ($aux_cont_ListaRemisionesFV < $cont_ListaRemisionesFV) {
            $Remision = $ListaRemisionesFV[$aux_cont_ListaRemisionesFV];
            echo $Remision." ";
            $sql = "UPDATE remision Set remision_FacturaVenta=NULL WHERE remision_Id='$Remision'";
            mysqli_query($conn, $sql);
            $aux_cont_ListaRemisionesFV = $aux_cont_ListaRemisionesFV + 1;
        }
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OAFV&FV=$FacturaVenta");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EAFV");
        exit();
    }

?>