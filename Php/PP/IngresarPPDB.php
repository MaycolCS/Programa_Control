<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(12,16,22,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */
    $Cotizacion_Id = $_GET['cot'];
    $DatosCotizacion = datosCotizacion($Cotizacion_Id);

    $PP_Id =  datosConsecutivo("PP");
    $PP_Año = date("Y");
    $PP_Mes = date("m");
    $PP_Dia = date("d");

    $PP_NitTercero = $DatosCotizacion['cotizacion_NitTercero'];
    $PP_TiempoEntrega = $DatosCotizacion['cotizacion_TiempoEntrega'];
    $PP_PlantaEntrega = $DatosCotizacion['cotizacion_PlantaEntrega'];

    $PP_Observaciones = $_POST['Observaciones'];

    $PP_Detalle_Item1 = null;
    $PP_Cantidad_Item1 = null;
    $PP_ValorUnidad_Item1 = null;
    $PP_ValorTotal_Item1 = null;

    $PP_Detalle_Item2 = null;
    $PP_Cantidad_Item2 = null;
    $PP_ValorUnidad_Item2 = null;
    $PP_ValorTotal_Item2 = null;

    $PP_Detalle_Item3 = null;
    $PP_Cantidad_Item3 = null;
    $PP_ValorUnidad_Item3 = null;
    $PP_ValorTotal_Item3 = null;

    $PP_Detalle_Item4 = null;
    $PP_Cantidad_Item4 = null;
    $PP_ValorUnidad_Item4 = null;
    $PP_ValorTotal_Item4 = null;

    $PP_Detalle_Item5 = null;
    $PP_Cantidad_Item5 = null;
    $PP_ValorUnidad_Item5 = null;
    $PP_ValorTotal_Item5 = null;

    $PP_Detalle_Item6 = null;
    $PP_Cantidad_Item6 = null;
    $PP_ValorUnidad_Item6 = null;
    $PP_ValorTotal_Item6 = null;

    $PP_Detalle_Item7 = null;
    $PP_Cantidad_Item7 = null;
    $PP_ValorUnidad_Item7 = null;
    $PP_ValorTotal_Item7 = null;

    $PP_Detalle_Item8 = null;
    $PP_Cantidad_Item8 = null;
    $PP_ValorUnidad_Item8 = null;
    $PP_ValorTotal_Item8 = null;

    $PP_Detalle_Item9 = null;
    $PP_Cantidad_Item9 = null;
    $PP_ValorUnidad_Item9 = null;
    $PP_ValorTotal_Item9 = null;

    $PP_Detalle_Item10 = null;
    $PP_Cantidad_Item10 = null;
    $PP_ValorUnidad_Item10 = null;
    $PP_ValorTotal_Item10 = null;

    $PP_Detalle_Item11 = null;
    $PP_Cantidad_Item11 = null;
    $PP_ValorUnidad_Item11 = null;
    $PP_ValorTotal_Item11 = null;

    $PP_Detalle_Item12 = null;
    $PP_Cantidad_Item12 = null;
    $PP_ValorUnidad_Item12 = null;
    $PP_ValorTotal_Item12 = null;

    $SumaValorTotalItems = 0;
    $datosItems = array();
    if (isset($_POST['item1']) and ($_POST['item1']==1)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item1']);
        array_push($datosItems, $_POST['cantidad1']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item1']);
        array_push($datosItems, ($_POST['cantidad1']*$DatosCotizacion['cotizacion_ValorUnidad_Item1']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad1']*$DatosCotizacion['cotizacion_ValorUnidad_Item1']);
    }
    if (isset($_POST['item2']) and ($_POST['item2']==2)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item2']);
        array_push($datosItems, $_POST['cantidad2']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item2']);
        array_push($datosItems, ($_POST['cantidad2']*$DatosCotizacion['cotizacion_ValorUnidad_Item2']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad2']*$DatosCotizacion['cotizacion_ValorUnidad_Item2']);
    }
    if (isset($_POST['item3']) and ($_POST['item3']==3)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item3']);
        array_push($datosItems, $_POST['cantidad3']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item3']);
        array_push($datosItems, ($_POST['cantidad3']*$DatosCotizacion['cotizacion_ValorUnidad_Item3']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad3']*$DatosCotizacion['cotizacion_ValorUnidad_Item3']);
    }
    if (isset($_POST['item4']) and ($_POST['item4']==4)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item4']);
        array_push($datosItems, $_POST['cantidad4']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item4']);
        array_push($datosItems, ($_POST['cantidad4']*$DatosCotizacion['cotizacion_ValorUnidad_Item4']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad4']*$DatosCotizacion['cotizacion_ValorUnidad_Item4']);
    }
    if (isset($_POST['item5']) and ($_POST['item5']==5)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item5']);
        array_push($datosItems, $_POST['cantidad5']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item5']);
        array_push($datosItems, ($_POST['cantidad5']*$$DatosCotizacion['cotizacion_ValorUnidad_Item5']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad5']*$$DatosCotizacion['cotizacion_ValorUnidad_Item5']);
    }
    if (isset($_POST['item6']) and ($_POST['item6']==6)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item6']);
        array_push($datosItems, $_POST['cantidad6']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item6']);
        array_push($datosItems, ($_POST['cantidad6']*$DatosCotizacion['cotizacion_ValorUnidad_Item6']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad6']*$DatosCotizacion['cotizacion_ValorUnidad_Item6']);
    }
    if (isset($_POST['item7']) and ($_POST['item7']==7)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item7']);
        array_push($datosItems, $_POST['cantidad7']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item7']);
        array_push($datosItems, ($_POST['cantidad7']*$DatosCotizacion['cotizacion_ValorUnidad_Item7']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad7']*$DatosCotizacion['cotizacion_ValorUnidad_Item7']);
    }
    if (isset($_POST['item8']) and ($_POST['item8']==8)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item8']);
        array_push($datosItems, $_POST['cantidad8']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item8']);
        array_push($datosItems, ($_POST['cantidad8']*$DatosCotizacion['cotizacion_ValorUnidad_Item8']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad8']*$DatosCotizacion['cotizacion_ValorUnidad_Item8']);
    }
    if (isset($_POST['item9']) and ($_POST['item9']==9)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item9']);
        array_push($datosItems, $_POST['cantidad9']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item9']);
        array_push($datosItems, ($_POST['cantidad9']*$DatosCotizacion['cotizacion_ValorUnidad_Item9']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad9']*$DatosCotizacion['cotizacion_ValorUnidad_Item9']);
    }
    if (isset($_POST['item10']) and ($_POST['item10']==10)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item10']);
        array_push($datosItems, $_POST['cantidad10']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item10']);
        array_push($datosItems, ($_POST['cantidad10']*$DatosCotizacion['cotizacion_ValorUnidad_Item10']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad10']*$DatosCotizacion['cotizacion_ValorUnidad_Item10']);
    }
    if (isset($_POST['item11']) and ($_POST['item11']==11)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item11']);
        array_push($datosItems, $_POST['cantidad11']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item11']);
        array_push($datosItems, ($_POST['cantidad11']*$DatosCotizacion['cotizacion_ValorUnidad_Item11']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad11']*$DatosCotizacion['cotizacion_ValorUnidad_Item11']);
    }
    if (isset($_POST['item12']) and ($_POST['item12']==12)) {
        array_push($datosItems, $DatosCotizacion['cotizacion_Detalle_Item12']);
        array_push($datosItems, $_POST['cantidad12']);
        array_push($datosItems, $DatosCotizacion['cotizacion_ValorUnidad_Item12']);
        array_push($datosItems, ($_POST['cantidad12']*$DatosCotizacion['cotizacion_ValorUnidad_Item12']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad12']*$DatosCotizacion['cotizacion_ValorUnidad_Item12']);
    }
    if ($SumaValorTotalItems == 0) {
        header("Location: IngresarPP.php? cc=$Documento&cs=$CS&cot=$Cotizacion_Id&msj=ESITEMCOT");
        exit();
    }
    
    $contdatosItems = count($datosItems);
    $contAuxdatosItems = 0;
    $totalItems = $contdatosItems/4;
    $auxTotalItems = 1;
    while ($contAuxdatosItems < $contdatosItems) {
        if ($auxTotalItems==1) {
            $PP_Detalle_Item1 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item1 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item1 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item1 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==2) {
            $PP_Detalle_Item2 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item2 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item2 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item2 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==3) {
            $PP_Detalle_Item3 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item3 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item3 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item3 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==4) {
            $PP_Detalle_Item4 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item4 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item4 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item4 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==5) {
            $PP_Detalle_Item5 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item5 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item5 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item5 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==6) {
            $PP_Detalle_Item6 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item6 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item6 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item6 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==7) {
            $PP_Detalle_Item7 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item7 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item7 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item7 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==8) {
            $PP_Detalle_Item8 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item8 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item8 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item8 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==9) {
            $PP_Detalle_Item9 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item9 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item9 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item9 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==10) {
            $PP_Detalle_Item10 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item10 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item10 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item10 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==11) {
            $PP_Detalle_Item11 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item11 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item11 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item11 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==12) {
            $PP_Detalle_Item12 = $datosItems[$contAuxdatosItems];
            $PP_Cantidad_Item12 = $datosItems[$contAuxdatosItems+1];
            $PP_ValorUnidad_Item12 = $datosItems[$contAuxdatosItems+2];
            $PP_ValorTotal_Item12 = $datosItems[$contAuxdatosItems+3];
        }
        $auxTotalItems = $auxTotalItems + 1;
        $contAuxdatosItems = $contAuxdatosItems + 4;
    }

    $PP_PorcentajeDescuento = $DatosCotizacion['cotizacion_PorcentajeDescuento'];
    $PP_ValorDescuento = round($SumaValorTotalItems*($PP_PorcentajeDescuento/100));
    $PP_ValorIVA = round(($SumaValorTotalItems-($SumaValorTotalItems*($PP_PorcentajeDescuento/100)))*0.19);
    $PP_ValorTotal = round($SumaValorTotalItems-($SumaValorTotalItems*($PP_PorcentajeDescuento/100))+(($SumaValorTotalItems-($SumaValorTotalItems*($PP_PorcentajeDescuento/100)))*0.19));
    $PP_Vendedor = $Documento;
    $PP_Cotizacion = $DatosCotizacion['cotizacion_Id'];
    $PP_Fecha = date("Y-m-d");

    $conn = conexionBD();
    $sql = "INSERT INTO planilla_produccion 
            (planilla_produccion_Id,
            planilla_produccion_Año,
            planilla_produccion_Mes,
            planilla_produccion_Dia,
            planilla_produccion_NitTercero,
            planilla_produccion_TiempoEntrega,
            planilla_produccion_PlantaEntrega,
            planilla_produccion_Detalle_Item1,
            planilla_produccion_Cantidad_Item1,
            planilla_produccion_ValorUnidad_Item1,
            planilla_produccion_ValorTotal_Item1,
            planilla_produccion_Detalle_Item2,
            planilla_produccion_Cantidad_Item2,
            planilla_produccion_ValorUnidad_Item2,
            planilla_produccion_ValorTotal_Item2,
            planilla_produccion_Detalle_Item3,
            planilla_produccion_Cantidad_Item3,
            planilla_produccion_ValorUnidad_Item3,
            planilla_produccion_ValorTotal_Item3,
            planilla_produccion_Detalle_Item4,
            planilla_produccion_Cantidad_Item4,
            planilla_produccion_ValorUnidad_Item4,
            planilla_produccion_ValorTotal_Item4,
            planilla_produccion_Detalle_Item5,
            planilla_produccion_Cantidad_Item5,
            planilla_produccion_ValorUnidad_Item5,
            planilla_produccion_ValorTotal_Item5,
            planilla_produccion_Detalle_Item6,
            planilla_produccion_Cantidad_Item6,
            planilla_produccion_ValorUnidad_Item6,
            planilla_produccion_ValorTotal_Item6,
            planilla_produccion_Detalle_Item7,
            planilla_produccion_Cantidad_Item7,
            planilla_produccion_ValorUnidad_Item7,
            planilla_produccion_ValorTotal_Item7,
            planilla_produccion_Detalle_Item8,
            planilla_produccion_Cantidad_Item8,
            planilla_produccion_ValorUnidad_Item8,
            planilla_produccion_ValorTotal_Item8,
            planilla_produccion_Detalle_Item9,
            planilla_produccion_Cantidad_Item9,
            planilla_produccion_ValorUnidad_Item9,
            planilla_produccion_ValorTotal_Item9,
            planilla_produccion_Detalle_Item10,
            planilla_produccion_Cantidad_Item10,
            planilla_produccion_ValorUnidad_Item10,
            planilla_produccion_ValorTotal_Item10,
            planilla_produccion_Detalle_Item11,
            planilla_produccion_Cantidad_Item11,
            planilla_produccion_ValorUnidad_Item11,
            planilla_produccion_ValorTotal_Item11,
            planilla_produccion_Detalle_Item12,
            planilla_produccion_Cantidad_Item12,
            planilla_produccion_ValorUnidad_Item12,
            planilla_produccion_ValorTotal_Item12,
            planilla_produccion_Subtotal,
            planilla_produccion_PorcentajeDescuento,
            planilla_produccion_ValorDescuento,
            planilla_produccion_ValorIVA,
            planilla_produccion_ValorTotal,
            planilla_produccion_Vendedor,
            planilla_produccion_Cotizacion,
            planilla_produccion_Fecha,
            planilla_produccion_Observaciones)
            VALUES 
            ('$PP_Id',
            '$PP_Año',
            '$PP_Mes',
            '$PP_Dia',
            '$PP_NitTercero',
            '$PP_TiempoEntrega',
            '$PP_PlantaEntrega',
            '$PP_Detalle_Item1',
            '$PP_Cantidad_Item1',
            '$PP_ValorUnidad_Item1',
            '$PP_ValorTotal_Item1',
            '$PP_Detalle_Item2',
            '$PP_Cantidad_Item2',
            '$PP_ValorUnidad_Item2',
            '$PP_ValorTotal_Item2',
            '$PP_Detalle_Item3',
            '$PP_Cantidad_Item3',
            '$PP_ValorUnidad_Item3',
            '$PP_ValorTotal_Item3',
            '$PP_Detalle_Item4',
            '$PP_Cantidad_Item4',
            '$PP_ValorUnidad_Item4',
            '$PP_ValorTotal_Item4',
            '$PP_Detalle_Item5',
            '$PP_Cantidad_Item5',
            '$PP_ValorUnidad_Item5',
            '$PP_ValorTotal_Item5',
            '$PP_Detalle_Item6',
            '$PP_Cantidad_Item6',
            '$PP_ValorUnidad_Item6',
            '$PP_ValorTotal_Item6',
            '$PP_Detalle_Item7',
            '$PP_Cantidad_Item7',
            '$PP_ValorUnidad_Item7',
            '$PP_ValorTotal_Item7',
            '$PP_Detalle_Item8',
            '$PP_Cantidad_Item8',
            '$PP_ValorUnidad_Item8',
            '$PP_ValorTotal_Item8',
            '$PP_Detalle_Item9',
            '$PP_Cantidad_Item9',
            '$PP_ValorUnidad_Item9',
            '$PP_ValorTotal_Item9',
            '$PP_Detalle_Item10',
            '$PP_Cantidad_Item10',
            '$PP_ValorUnidad_Item10',
            '$PP_ValorTotal_Item10',
            '$PP_Detalle_Item11',
            '$PP_Cantidad_Item11',
            '$PP_ValorUnidad_Item11',
            '$PP_ValorTotal_Item11',
            '$PP_Detalle_Item12',
            '$PP_Cantidad_Item12',
            '$PP_ValorUnidad_Item12',
            '$PP_ValorTotal_Item12',
            '$SumaValorTotalItems',
            '$PP_PorcentajeDescuento',
            '$PP_ValorDescuento',
            '$PP_ValorIVA',
            '$PP_ValorTotal',
            '$PP_Vendedor',
            '$PP_Cotizacion',
            '$PP_Fecha',
            '$PP_Observaciones')";
    if (mysqli_query($conn, $sql)) {
        $NewConsecutivo = numeroConsecutivo("PP")+1;
        $sql = "UPDATE consecutivo Set consecutivo_Numero='$NewConsecutivo'WHERE consecutivo_Id='2'";
        mysqli_query($conn, $sql);

        /*if (!CotizacionTienePlanilla($Cotizacion_Id)) {
            $NumPlanilla = "GTE-PP - ".substr($PP_Id, 8);
            $sql = "UPDATE cotizacion Set cotizacion_PlanillaProduccion='$NumPlanilla' WHERE cotizacion_Id='$Cotizacion_Id'";
            mysqli_query($conn, $sql);
        } else {
            $Cotizacion_Planillas = Cotizacion_PlanillasProduccion($Cotizacion_Id);
            $Cotizacion_Planilla = explode(" - ", $Cotizacion_Planillas);
            $NumPlanilla = "GTE-PP";
            for ($i = 1; $i < count($Cotizacion_Planilla); $i += 1) {
                $NumPlanilla = $NumPlanilla." - ".$Cotizacion_Planilla[$i];
            }
            $NumPlanilla = $NumPlanilla." - ".substr($PP_Id, 8);
            $sql = "UPDATE cotizacion Set cotizacion_PlanillaProduccion='$NumPlanilla' WHERE cotizacion_Id='$Cotizacion_Id'";
            mysqli_query($conn, $sql);
        }*/

        header("Location: ConsultarPP? cc=$Documento&cs=$CS&msj=ORPP&pp=$PP_Id");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ERPP");
        exit();
    }

?>