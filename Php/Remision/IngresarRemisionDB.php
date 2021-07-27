<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(13,16,23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */
    $PlanillaProduccion_Id = $_GET['PP'];
    $DatosPlanillaProduccion = DatosPlanillaProduccion($PlanillaProduccion_Id);

    $PlantaTercero = $_GET['PLTR'];

    $Remision_Id =  datosConsecutivo("REMISION");
    $Remision_Año = date("Y");
    $Remision_Mes = date("m");
    $Remision_Dia = date("d");

    $Remision_NitTercero = $DatosPlanillaProduccion['planilla_produccion_NitTercero'];
    $Remision_TiempoEntrega = $DatosPlanillaProduccion['planilla_produccion_TiempoEntrega'];
    $Remision_PlantaEntrega = $PlantaTercero;

    $Remision_Observaciones = $_POST['Observaciones'];

    $Remision_Detalle_Item1 = null;
    $Remision_Cantidad_Item1 = null;
    $Remision_ValorUnidad_Item1 = null;
    $Remision_ValorTotal_Item1 = null;

    $Remision_Detalle_Item2 = null;
    $Remision_Cantidad_Item2 = null;
    $Remision_ValorUnidad_Item2 = null;
    $Remision_ValorTotal_Item2 = null;

    $Remision_Detalle_Item3 = null;
    $Remision_Cantidad_Item3 = null;
    $Remision_ValorUnidad_Item3 = null;
    $Remision_ValorTotal_Item3 = null;

    $Remision_Detalle_Item4 = null;
    $Remision_Cantidad_Item4 = null;
    $Remision_ValorUnidad_Item4 = null;
    $Remision_ValorTotal_Item4 = null;

    $Remision_Detalle_Item5 = null;
    $Remision_Cantidad_Item5 = null;
    $Remision_ValorUnidad_Item5 = null;
    $Remision_ValorTotal_Item5 = null;

    $Remision_Detalle_Item6 = null;
    $Remision_Cantidad_Item6 = null;
    $Remision_ValorUnidad_Item6 = null;
    $Remision_ValorTotal_Item6 = null;

    $Remision_Detalle_Item7 = null;
    $Remision_Cantidad_Item7 = null;
    $Remision_ValorUnidad_Item7 = null;
    $Remision_ValorTotal_Item7 = null;

    $Remision_Detalle_Item8 = null;
    $Remision_Cantidad_Item8 = null;
    $Remision_ValorUnidad_Item8 = null;
    $Remision_ValorTotal_Item8 = null;

    $Remision_Detalle_Item9 = null;
    $Remision_Cantidad_Item9 = null;
    $Remision_ValorUnidad_Item9 = null;
    $Remision_ValorTotal_Item9 = null;

    $Remision_Detalle_Item10 = null;
    $Remision_Cantidad_Item10 = null;
    $Remision_ValorUnidad_Item10 = null;
    $Remision_ValorTotal_Item10 = null;

    $Remision_Detalle_Item11 = null;
    $Remision_Cantidad_Item11 = null;
    $Remision_ValorUnidad_Item11 = null;
    $Remision_ValorTotal_Item11 = null;

    $Remision_Detalle_Item12 = null;
    $Remision_Cantidad_Item12 = null;
    $Remision_ValorUnidad_Item12 = null;
    $Remision_ValorTotal_Item12 = null;

    $PlanillaProduccion_Completa = TRUE;
    $SumaValorTotalItems = 0;
    $datosItems = array();
    if (isset($_POST['item1']) and ($_POST['item1']==1)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item1']);
        array_push($datosItems, $_POST['cantidad1']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item1']);
        array_push($datosItems, ($_POST['cantidad1']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item1']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad1']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item1']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item1'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item1']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item1'] - $CantidadRemisionadaItem - $_POST['cantidad1'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item2']) and ($_POST['item2']==2)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item2']);
        array_push($datosItems, $_POST['cantidad2']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item2']);
        array_push($datosItems, ($_POST['cantidad2']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item2']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad2']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item2']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item2'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item2']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item2'] - $CantidadRemisionadaItem - $_POST['cantidad2'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item3']) and ($_POST['item3']==3)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item3']);
        array_push($datosItems, $_POST['cantidad3']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item3']);
        array_push($datosItems, ($_POST['cantidad3']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item3']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad3']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item3']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item3'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item3']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item3'] - $CantidadRemisionadaItem - $_POST['cantidad3'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item4']) and ($_POST['item4']==4)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item4']);
        array_push($datosItems, $_POST['cantidad4']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item4']);
        array_push($datosItems, ($_POST['cantidad4']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item4']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad4']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item4']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item4'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item4']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item4'] - $CantidadRemisionadaItem - $_POST['cantidad4'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item5']) and ($_POST['item5']==5)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item5']);
        array_push($datosItems, $_POST['cantidad5']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item5']);
        array_push($datosItems, ($_POST['cantidad5']*$$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item5']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad5']*$$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item5']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item5'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item5']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item5'] - $CantidadRemisionadaItem - $_POST['cantidad5'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item6']) and ($_POST['item6']==6)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item6']);
        array_push($datosItems, $_POST['cantidad6']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item6']);
        array_push($datosItems, ($_POST['cantidad6']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item6']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad6']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item6']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item6'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item6']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item6'] - $CantidadRemisionadaItem - $_POST['cantidad6'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item7']) and ($_POST['item7']==7)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item7']);
        array_push($datosItems, $_POST['cantidad7']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item7']);
        array_push($datosItems, ($_POST['cantidad7']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item7']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad7']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item7']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item7'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item7']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item7'] - $CantidadRemisionadaItem - $_POST['cantidad7'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item8']) and ($_POST['item8']==8)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item8']);
        array_push($datosItems, $_POST['cantidad8']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item8']);
        array_push($datosItems, ($_POST['cantidad8']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item8']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad8']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item8']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item8'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item8']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item8'] - $CantidadRemisionadaItem - $_POST['cantidad8'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item9']) and ($_POST['item9']==9)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item9']);
        array_push($datosItems, $_POST['cantidad9']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item9']);
        array_push($datosItems, ($_POST['cantidad9']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item9']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad9']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item9']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item9'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item9']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item9'] - $CantidadRemisionadaItem - $_POST['cantidad9'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item10']) and ($_POST['item10']==10)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item10']);
        array_push($datosItems, $_POST['cantidad10']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item10']);
        array_push($datosItems, ($_POST['cantidad10']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item10']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad10']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item10']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item10'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item10']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item10'] - $CantidadRemisionadaItem - $_POST['cantidad10'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item11']) and ($_POST['item11']==11)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item11']);
        array_push($datosItems, $_POST['cantidad11']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item11']);
        array_push($datosItems, ($_POST['cantidad11']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item11']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad11']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item11']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item11'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item11']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item11'] - $CantidadRemisionadaItem - $_POST['cantidad11'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    if (isset($_POST['item12']) and ($_POST['item12']==12)) {
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_Detalle_Item12']);
        array_push($datosItems, $_POST['cantidad12']);
        array_push($datosItems, $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item12']);
        array_push($datosItems, ($_POST['cantidad12']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item12']));
        $SumaValorTotalItems = $SumaValorTotalItems + ($_POST['cantidad12']*$DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item12']);
        $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_NitTercero'], $DatosPlanillaProduccion['planilla_produccion_Detalle_Item12'], $DatosPlanillaProduccion['planilla_produccion_ValorUnidad_Item12']);
        $CantidadDisponibleItem = $DatosPlanillaProduccion['planilla_produccion_Cantidad_Item12'] - $CantidadRemisionadaItem - $_POST['cantidad12'];
        if ($CantidadDisponibleItem > 0) {
            $PlanillaProduccion_Completa = FALSE;
        }
    }
    
    $contdatosItems = count($datosItems);
    $contAuxdatosItems = 0;
    $totalItems = $contdatosItems/4;
    $auxTotalItems = 1;
    while ($contAuxdatosItems < $contdatosItems) {
        if ($auxTotalItems==1) {
            $Remision_Detalle_Item1 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item1 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item1 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item1 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==2) {
            $Remision_Detalle_Item2 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item2 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item2 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item2 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==3) {
            $Remision_Detalle_Item3 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item3 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item3 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item3 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==4) {
            $Remision_Detalle_Item4 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item4 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item4 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item4 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==5) {
            $Remision_Detalle_Item5 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item5 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item5 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item5 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==6) {
            $Remision_Detalle_Item6 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item6 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item6 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item6 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==7) {
            $Remision_Detalle_Item7 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item7 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item7 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item7 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==8) {
            $Remision_Detalle_Item8 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item8 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item8 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item8 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==9) {
            $Remision_Detalle_Item9 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item9 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item9 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item9 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==10) {
            $Remision_Detalle_Item10 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item10 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item10 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item10 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==11) {
            $Remision_Detalle_Item11 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item11 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item11 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item11 = $datosItems[$contAuxdatosItems+3];
        } elseif ($auxTotalItems==12) {
            $Remision_Detalle_Item12 = $datosItems[$contAuxdatosItems];
            $Remision_Cantidad_Item12 = $datosItems[$contAuxdatosItems+1];
            $Remision_ValorUnidad_Item12 = $datosItems[$contAuxdatosItems+2];
            $Remision_ValorTotal_Item12 = $datosItems[$contAuxdatosItems+3];
        }
        $auxTotalItems = $auxTotalItems + 1;
        $contAuxdatosItems = $contAuxdatosItems + 4;
    }

    $Remision_Subtotal = $SumaValorTotalItems;
    $Remision_PorcentajeDescuento = $DatosPlanillaProduccion['planilla_produccion_PorcentajeDescuento'];
    $Remision_ValorDescuento =  round($Remision_Subtotal*($Remision_PorcentajeDescuento/100));
    $Remision_ValorIVA = round(($Remision_Subtotal-($Remision_Subtotal*($Remision_PorcentajeDescuento/100)))*0.19);
    $Remision_ValorTotal = round($Remision_Subtotal-($Remision_Subtotal*($Remision_PorcentajeDescuento/100))+(($Remision_Subtotal-($Remision_Subtotal*($Remision_PorcentajeDescuento/100)))*0.19));
    $Remision_Vendedor = $Documento;
    $Remision_PlanillaProduccion = $DatosPlanillaProduccion['planilla_produccion_Id'];
    $OrdenCompra = $_GET['OC'];
    $Remision_OrdenCompra= strtoupper($OrdenCompra);
    $Remision_Fecha = date("Y-m-d");

    $conn = conexionBD();
    $sql = "INSERT INTO remision
            (remision_Id,
            remision_Año,
            remision_Mes,
            remision_Dia,
            remision_NitTercero,
            remision_TiempoEntrega,
            remision_PlantaEntrega,
            remision_Detalle_Item1,
            remision_Cantidad_Item1,
            remision_ValorUnidad_Item1,
            remision_ValorTotal_Item1,
            remision_Detalle_Item2,
            remision_Cantidad_Item2,
            remision_ValorUnidad_Item2,
            remision_ValorTotal_Item2,
            remision_Detalle_Item3,
            remision_Cantidad_Item3,
            remision_ValorUnidad_Item3,
            remision_ValorTotal_Item3,
            remision_Detalle_Item4,
            remision_Cantidad_Item4,
            remision_ValorUnidad_Item4,
            remision_ValorTotal_Item4,
            remision_Detalle_Item5,
            remision_Cantidad_Item5,
            remision_ValorUnidad_Item5,
            remision_ValorTotal_Item5,
            remision_Detalle_Item6,
            remision_Cantidad_Item6,
            remision_ValorUnidad_Item6,
            remision_ValorTotal_Item6,
            remision_Detalle_Item7,
            remision_Cantidad_Item7,
            remision_ValorUnidad_Item7,
            remision_ValorTotal_Item7,
            remision_Detalle_Item8,
            remision_Cantidad_Item8,
            remision_ValorUnidad_Item8,
            remision_ValorTotal_Item8,
            remision_Detalle_Item9,
            remision_Cantidad_Item9,
            remision_ValorUnidad_Item9,
            remision_ValorTotal_Item9,
            remision_Detalle_Item10,
            remision_Cantidad_Item10,
            remision_ValorUnidad_Item10,
            remision_ValorTotal_Item10,
            remision_Detalle_Item11,
            remision_Cantidad_Item11,
            remision_ValorUnidad_Item11,
            remision_ValorTotal_Item11,
            remision_Detalle_Item12,
            remision_Cantidad_Item12,
            remision_ValorUnidad_Item12,
            remision_ValorTotal_Item12,
            remision_Subtotal,
            remision_PorcentajeDescuento,
            remision_ValorDescuento,
            remision_ValorIVA,
            remision_ValorTotal,
            remision_Vendedor,
            remision_PlanillaProduccion,
            remision_OrdenCompra,
            remision_Fecha,
            remision_Observaciones) 
            VALUES 
            ('$Remision_Id',
            '$Remision_Año',
            '$Remision_Mes',
            '$Remision_Dia',
            '$Remision_NitTercero',
            '$Remision_TiempoEntrega',
            '$Remision_PlantaEntrega',
            '$Remision_Detalle_Item1',
            '$Remision_Cantidad_Item1',
            '$Remision_ValorUnidad_Item1',
            '$Remision_ValorTotal_Item1',
            '$Remision_Detalle_Item2',
            '$Remision_Cantidad_Item2',
            '$Remision_ValorUnidad_Item2',
            '$Remision_ValorTotal_Item2',
            '$Remision_Detalle_Item3',
            '$Remision_Cantidad_Item3',
            '$Remision_ValorUnidad_Item3',
            '$Remision_ValorTotal_Item3',
            '$Remision_Detalle_Item4',
            '$Remision_Cantidad_Item4',
            '$Remision_ValorUnidad_Item4',
            '$Remision_ValorTotal_Item4',
            '$Remision_Detalle_Item5',
            '$Remision_Cantidad_Item5',
            '$Remision_ValorUnidad_Item5',
            '$Remision_ValorTotal_Item5',
            '$Remision_Detalle_Item6',
            '$Remision_Cantidad_Item6',
            '$Remision_ValorUnidad_Item6',
            '$Remision_ValorTotal_Item6',
            '$Remision_Detalle_Item7',
            '$Remision_Cantidad_Item7',
            '$Remision_ValorUnidad_Item7',
            '$Remision_ValorTotal_Item7',
            '$Remision_Detalle_Item8',
            '$Remision_Cantidad_Item8',
            '$Remision_ValorUnidad_Item8',
            '$Remision_ValorTotal_Item8',
            '$Remision_Detalle_Item9',
            '$Remision_Cantidad_Item9',
            '$Remision_ValorUnidad_Item9',
            '$Remision_ValorTotal_Item9',
            '$Remision_Detalle_Item10',
            '$Remision_Cantidad_Item10',
            '$Remision_ValorUnidad_Item10',
            '$Remision_ValorTotal_Item10',
            '$Remision_Detalle_Item11',
            '$Remision_Cantidad_Item11',
            '$Remision_ValorUnidad_Item11',
            '$Remision_ValorTotal_Item11',
            '$Remision_Detalle_Item12',
            '$Remision_Cantidad_Item12',
            '$Remision_ValorUnidad_Item12',
            '$Remision_ValorTotal_Item12',
            '$Remision_Subtotal',
            '$Remision_PorcentajeDescuento',
            '$Remision_ValorDescuento',
            '$Remision_ValorIVA',
            '$Remision_ValorTotal',
            '$Remision_Vendedor',
            '$Remision_PlanillaProduccion',
            '$Remision_OrdenCompra',
            '$Remision_Fecha',
            '$Remision_Observaciones')";

    if (mysqli_query($conn, $sql)) {
        if ($PlanillaProduccion_Completa == TRUE) {
            $sql = "UPDATE planilla_produccion Set planilla_produccion_Completa=TRUE WHERE planilla_produccion_Id='$Remision_PlanillaProduccion'";
            mysqli_query($conn, $sql);
        }
        $NewConsecutivo = numeroConsecutivo("REMISION")+1;
        $sql = "UPDATE consecutivo Set consecutivo_Numero='$NewConsecutivo'WHERE consecutivo_Id='3'";
        mysqli_query($conn, $sql);

        /*if (!PlanillaProduccionTieneRemision($Remision_PlanillaProduccion)) {
            $NumRemision = "GTE-REM - ".substr($Remision_Id, 8);
            $sql = "UPDATE planilla_produccion Set planilla_produccion_Remision='$NumRemision' WHERE planilla_produccion_Id='$PlanillaProduccion_Id'";
            mysqli_query($conn, $sql);
        } else {
            $RemisionesPP = RemisionesPlanillaProduccion($PlanillaProduccion_Id);
            $RemisionPP = explode(" - ", $RemisionesPP);
            $NumRemision = "GTE-REM";
            for ($i = 1; $i < count($RemisionPP); $i += 1) {
                $NumRemision = $NumRemision." - ".$RemisionPP[$i];
            }
            $NumRemision = $NumRemision." - ".substr($Remision_Id, 8);
            $sql = "UPDATE planilla_produccion Set planilla_produccion_Remision='$NumRemision' WHERE planilla_produccion_Id='$PlanillaProduccion_Id'";
            mysqli_query($conn, $sql);
        }*/
        
        mysqli_close($conn);
        header("Location: ConsultarRemision? cc=$Documento&cs=$CS&msj=ORREM&REM=$Remision_Id");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ERREM");
        exit();
    }

?>