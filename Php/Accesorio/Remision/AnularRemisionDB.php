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

    $Remision= $_GET['REM'];
    $Remision_MotivoAnulacion = $_POST['MotivoAnulacion'].". ANULADO POR: ".datosUsuario($Documento)['usuario_Nombre']." ".datosUsuario($Documento)['usuario_Apellido'];
    $conn = conexionBD();
    $sql = "UPDATE remision Set remision_Anulada='SI', remision_MotivoAnulacion='$Remision_MotivoAnulacion' WHERE remision_Id='$Remision'";

    if (mysqli_query($conn, $sql)) {
        $PlanillaProduccion = IdPlanillaProduccion_Remision($Remision);
        $NumRemision = substr($Remision, 8);
        $RemisionesPP = RemisionesPlanillaProduccion($PlanillaProduccion);
        $RemisionPP = explode(" - ", $RemisionesPP);
        $NewRemision = "GTE-REM";
        for ($i = 1; $i < count($RemisionPP); $i += 1) {
            if ($RemisionPP[$i] != $NumRemision){
                $NewRemision = $NewRemision." - ".$RemisionPP[$i];
            }
        }
        $sql = "";
        if ($NewRemision == "GTE-REM") {
            $sql = "UPDATE planilla_produccion Set planilla_produccion_Remision=NULL WHERE planilla_produccion_Id='$PlanillaProduccion'";
        } else {
            $sql = "UPDATE planilla_produccion Set planilla_produccion_Remision='$NewRemision', planilla_produccion_Completa=FALSE WHERE planilla_produccion_Id='$PlanillaProduccion'";
        }
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OAREM&REM=$Remision");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EAREM");
        exit();
    }

?>