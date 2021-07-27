<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(22,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $PlanillaProduccion= $_GET['pp'];
    $PlanillaProduccion_MotivoAnulacion= $_POST['MotivoAnulacion'].". ANULADO POR: ".datosUsuario($Documento)['usuario_Nombre']." ".datosUsuario($Documento)['usuario_Apellido'];
    $conn = conexionBD();
    $sql = "UPDATE planilla_produccion Set planilla_produccion_Anulada='SI', planilla_produccion_MotivoAnulacion='$PlanillaProduccion_MotivoAnulacion' WHERE planilla_produccion_Id='$PlanillaProduccion'";
    if (mysqli_query($conn, $sql)) {
        $cotizacion = PlanillaProduccion_IdCotizacion($PlanillaProduccion);
        $NumPlanilla = substr($PlanillaProduccion, 7);
        $Cotizacion_Planillas = RemisionesPlanillaProduccion($cotizacion);
        $Cotizacion_Planilla = explode(" - ", $Cotizacion_Planillas);
        $NewPlanilla = "GTE-PP";
        for ($i = 1; $i < count($Cotizacion_Planilla); $i += 1) {
            if ($Cotizacion_Planilla[$i] != $NumPlanilla){
                $NewPlanilla = $NewPlanilla." - ".$Cotizacion_Planilla[$i];
            }
        }
        $sql = "";
        if ($NewPlanilla == "GTE-PP") {
            $sql = "UPDATE cotizacion Set cotizacion_PlanillaProduccion=NULL WHERE cotizacion_Id='$cotizacion'";
        } else {
            $sql = "UPDATE cotizacion Set cotizacion_PlanillaProduccion='$NewPlanilla' WHERE cotizacion_Id='$cotizacion'";
        }
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OAPP&pp=$PlanillaProduccion");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EAPP");
        exit();
    }

?>