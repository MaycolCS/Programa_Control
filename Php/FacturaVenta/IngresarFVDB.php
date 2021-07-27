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

    $codeProvFV= $_GET['IPFV'];

    $facturaventa_Id =  datosConsecutivo("FV");
    $facturaventa_Año = date("Y");
    $facturaventa_Mes = date("m");
    $facturaventa_Dia = date("d");

    $facturaventa_NitTercero = $_GET['TR'];

    $facturaventa_Observaciones = $_POST['Observaciones'];

    $facturaventa_Remision1 = null;
    $facturaventa_ValorRemision1 = null;
    $facturaventa_Remision2 = null;
    $facturaventa_ValorRemision2 = null;
    $facturaventa_Remision3 = null;
    $facturaventa_ValorRemision3 = null;
    $facturaventa_Remision4 = null;
    $facturaventa_ValorRemision4 = null;
    $facturaventa_Remision5 = null;
    $facturaventa_ValorRemision5 = null;
    $facturaventa_Remision6 = null;
    $facturaventa_ValorRemision6 = null;
    $facturaventa_Remision7 = null;
    $facturaventa_ValorRemision7 = null;
    $facturaventa_Remision8 = null;
    $facturaventa_ValorRemision8 = null;
    $facturaventa_Remision9 = null;
    $facturaventa_ValorRemision9 = null;
    $facturaventa_Remision10 = null;
    $facturaventa_ValorRemision10 = null;
    $facturaventa_Remision11 = null;
    $facturaventa_ValorRemision11 = null;
    $facturaventa_Remision12 = null;
    $facturaventa_ValorRemision12 = null;
    $facturaventa_Remision13 = null;
    $facturaventa_ValorRemision13 = null;
    $facturaventa_Remision14 = null;
    $facturaventa_ValorRemision14 = null;
    $facturaventa_Remision15 = null;
    $facturaventa_ValorRemision15 = null;
    $facturaventa_Remision16 = null;
    $facturaventa_ValorRemision16 = null;
    $facturaventa_Remision17 = null;
    $facturaventa_ValorRemision17 = null;
    $facturaventa_Remision18 = null;
    $facturaventa_ValorRemision18 = null;
    $facturaventa_Remision19 = null;
    $facturaventa_ValorRemision19 = null;
    $facturaventa_Remision20 = null;
    $facturaventa_ValorRemision20 = null;
    $facturaventa_Remision21 = null;
    $facturaventa_ValorRemision21 = null;
    $facturaventa_Remision22 = null;
    $facturaventa_ValorRemision22 = null;
    $facturaventa_Remision23 = null;
    $facturaventa_ValorRemision23 = null;
    $facturaventa_Remision24 = null;
    $facturaventa_ValorRemision24 = null;

    $RemisionesProv = listaRemisiones_ProvFV($codeProvFV);
    $Cont_RemisonesProv = count($RemisionesProv);
    $Aux_Cont_RemisonesProv = 0;
    $NumRemision = "GTE-REM";
    $SumSubtotalRemisiones = 0;
    $SumTotalRemisiones = 0;
    $SumDescuentoRemisiones = 0;
    $SumIvaRemisiones = 0;
    while ($Aux_Cont_RemisonesProv < $Cont_RemisonesProv) {
        if ($Aux_Cont_RemisonesProv == 0) {
            $facturaventa_Remision1 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision1 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision1, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision1;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision1)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision1)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision1)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 3) {
            $facturaventa_Remision2 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision2 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision2, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision2;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision2)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision2)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision2)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 6) {
            $facturaventa_Remision3 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision3 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision3, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision3;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision3)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision3)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision3)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 9) {
            $facturaventa_Remision4 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision4 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision4, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision4;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision4)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision4)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision4)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 12) {
            $facturaventa_Remision5 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision5 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision5, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision5;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision5)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision5)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision5)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 15) {
            $facturaventa_Remision6 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision6 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision6, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision6;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision6)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision6)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision6)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 18) {
            $facturaventa_Remision7 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision7 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision7, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision7;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision7)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision7)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision7)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 21) {
            $facturaventa_Remision8 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision8 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision8, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision8;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision8)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision8)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision8)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 24) {
            $facturaventa_Remision9 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision9 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision9, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision9;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision9)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision9)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision9)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 27) {
            $facturaventa_Remision10 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision10 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision10, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision10;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision10)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision10)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision10)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 30) {
            $facturaventa_Remision11 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision11 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision11, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision11;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision11)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision11)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision11)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 33) {
            $facturaventa_Remision12 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision12 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision12, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision12;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision12)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision12)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision12)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 36) {
            $facturaventa_Remision13 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision13 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision13, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision13;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision13)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision13)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision13)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 39) {
            $facturaventa_Remision14 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision14 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision14, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision14;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision14)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision14)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision14)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 42) {
            $facturaventa_Remision15 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision15 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision15, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision15;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision15)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision15)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision15)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 45) {
            $facturaventa_Remision16 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision16 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision16, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision16;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision16)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision16)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision16)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 48) {
            $facturaventa_Remision17 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision17 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision17, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision17;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision17)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision17)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision17)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 51) {
            $facturaventa_Remision18 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision18 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision18, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision18;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision18)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision18)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision18)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 54) {
            $facturaventa_Remision19 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision19 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision19, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision19;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision19)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision19)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision19)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 57) {
            $facturaventa_Remision20 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision20 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision20, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision20;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision20)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision20)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision20)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 60) {
            $facturaventa_Remision21 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision21 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision21, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision21;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision21)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision21)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision21)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 63) {
            $facturaventa_Remision22 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision22 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision22, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision22;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision22)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision22)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision22)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 66) {
            $facturaventa_Remision23 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision23 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision23, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision23;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision23)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision23)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision23)['remision_Subtotal'];
        } else if ($Aux_Cont_RemisonesProv == 69) {
            $facturaventa_Remision24 = $RemisionesProv[$Aux_Cont_RemisonesProv];
            $facturaventa_ValorRemision24 = $RemisionesProv[$Aux_Cont_RemisonesProv+1];
            $NumRemision = $NumRemision." - ".substr($facturaventa_Remision24, 8);
            $SumTotalRemisiones = $SumTotalRemisiones + $facturaventa_ValorRemision24;
            $SumDescuentoRemisiones = $SumDescuentoRemisiones + datosRemision($facturaventa_Remision24)['remision_ValorDescuento'];
            $SumIvaRemisiones = $SumIvaRemisiones + datosRemision($facturaventa_Remision24)['remision_ValorIVA'];
            $SumSubtotalRemisiones = $SumSubtotalRemisiones + datosRemision($facturaventa_Remision24)['remision_Subtotal'];
        }
        $Aux_Cont_RemisonesProv = $Aux_Cont_RemisonesProv + 3;
    }
    
    $facturaventa_ValorSubtotal = $SumSubtotalRemisiones;
    $facturaventa_PorcentajeDescuento = datosRemision($facturaventa_Remision1)['remision_PorcentajeDescuento'];
    $facturaventa_ValorDescuento = $SumDescuentoRemisiones;
    $facturaventa_ValorIva = $SumIvaRemisiones;
    $facturaventa_ValorRetefuente = (($facturaventa_ValorSubtotal-$facturaventa_ValorDescuento)*(datosTercero($facturaventa_NitTercero)['tercero_PorcentajeRetefuente']/100));
    $facturaventa_ValorTotal = ($facturaventa_ValorSubtotal-$facturaventa_ValorDescuento+$facturaventa_ValorIva-$facturaventa_ValorRetefuente);
    $facturaventa_Vendedor = $Documento;
    $facturaventa_Remision = $NumRemision;
    $facturaventa_Fecha = date("Y-m-d");
    
    //suma total de las remisiones menos el descuento, todo por el 2.5%
    $facturaventa_ValorCompras_13551501 = round((($facturaventa_ValorSubtotal-$facturaventa_ValorDescuento)*0.025));
    
    //ReteIva por el 15%
    $facturaventa_ValorReteIVA_13551701 = round(($facturaventa_ValorIva*0.15));

    //suma total de las remisiones menos el descuento, todo por el 11.04/1000
    $facturaventa_ValorDemasActividadIndustriales_13551804 = round((($facturaventa_ValorSubtotal-$facturaventa_ValorDescuento)*11.04/1000));
    
    //suma total de las remisiones menos el descuento, todo por el 0.8%
    $facturaventa_ValorAutoRentaEspecial_23657501 = round((($facturaventa_ValorSubtotal-$facturaventa_ValorDescuento)*0.08));
    
    //suma total de las remisiones menos el descuento, todo por el 0.8%
    $facturaventa_ValorAutoRentaEspecial_13551541 = round((($facturaventa_ValorSubtotal-$facturaventa_ValorDescuento)*0.08));
    
    //suma total de las remisiones  -descuento+iva-compras-reteiva-demasactividad
    $facturaventa_ValorClientesNacionales_13050501 = round(($facturaventa_ValorSubtotal-$facturaventa_ValorDescuento+$facturaventa_ValorIva-$facturaventa_ValorCompras_13551501-$facturaventa_ValorReteIVA_13551701-$facturaventa_ValorDemasActividadIndustriales_13551804));
    
    //
    $facturaventa_DB = $facturaventa_ValorCompras_13551501+$facturaventa_ValorReteIVA_13551701+$facturaventa_ValorDemasActividadIndustriales_13551804+$facturaventa_ValorAutoRentaEspecial_13551541+$facturaventa_ValorClientesNacionales_13050501;
    
    //
    $facturaventa_HB = $facturaventa_ValorSubtotal+$facturaventa_ValorIva+$facturaventa_ValorAutoRentaEspecial_23657501;
    
    //
    $facturaventa_Saldo = /*$facturaventa_DB-$facturaventa_HB*/0;

    $conn = conexionBD();
    $sql = "INSERT INTO facturaventa 
            (facturaventa_Id,
            facturaventa_Año,
            facturaventa_Mes,
            facturaventa_Dia,
            facturaventa_NitTercero,
            facturaventa_Remision1,
            facturaventa_ValorRemision1,
            facturaventa_Remision2,
            facturaventa_ValorRemision2,
            facturaventa_Remision3,
            facturaventa_ValorRemision3,
            facturaventa_Remision4,
            facturaventa_ValorRemision4,
            facturaventa_Remision5,
            facturaventa_ValorRemision5,
            facturaventa_Remision6,
            facturaventa_ValorRemision6,
            facturaventa_Remision7,
            facturaventa_ValorRemision7,
            facturaventa_Remision8,
            facturaventa_ValorRemision8,
            facturaventa_Remision9,
            facturaventa_ValorRemision9,
            facturaventa_Remision10,
            facturaventa_ValorRemision10,
            facturaventa_Remision11,
            facturaventa_ValorRemision11,
            facturaventa_Remision12,
            facturaventa_ValorRemision12,
            facturaventa_Remision13,
            facturaventa_ValorRemision13,
            facturaventa_Remision14,
            facturaventa_ValorRemision14,
            facturaventa_Remision15,
            facturaventa_ValorRemision15,
            facturaventa_Remision16,
            facturaventa_ValorRemision16,
            facturaventa_Remision17,
            facturaventa_ValorRemision17,
            facturaventa_Remision18,
            facturaventa_ValorRemision18,
            facturaventa_Remision19,
            facturaventa_ValorRemision19,
            facturaventa_Remision20,
            facturaventa_ValorRemision20,
            facturaventa_Remision21,
            facturaventa_ValorRemision21,
            facturaventa_Remision22,
            facturaventa_ValorRemision22,
            facturaventa_Remision23,
            facturaventa_ValorRemision23,
            facturaventa_Remision24,
            facturaventa_ValorRemision24,
            facturaventa_Subtotal,
            facturaventa_PorcentajeDescuento,
            facturaventa_ValorDescuento,
            facturaventa_ValorIVA_24081001,
            facturaventa_ValorRetefuente,
            facturaventa_ValorTotal,
            facturaventa_ValorCompras_13551501,
            facturaventa_ValorReteIVA_13551701,
            facturaventa_ValorDemasActividadIndustriales_13551804,
            facturaventa_ValorAutoRentaEspecial_23657501,
            facturaventa_ValorAutoRentaEspecial_13551541,
            facturaventa_ValorClientesNacionales_13050501,
            facturaventa_DB,
            facturaventa_HB,
            facturaventa_Saldo,
            facturaventa_Vendedor,
            facturaventa_Remision,
            facturaventa_Fecha,
            facturaventa_Observaciones) 
            VALUES 
            ('$facturaventa_Id',
            '$facturaventa_Año',
            '$facturaventa_Mes',
            '$facturaventa_Dia',
            '$facturaventa_NitTercero',
            '$facturaventa_Remision1',
            '$facturaventa_ValorRemision1',
            '$facturaventa_Remision2',
            '$facturaventa_ValorRemision2',
            '$facturaventa_Remision3',
            '$facturaventa_ValorRemision3',
            '$facturaventa_Remision4',
            '$facturaventa_ValorRemision4',
            '$facturaventa_Remision5',
            '$facturaventa_ValorRemision5',
            '$facturaventa_Remision6',
            '$facturaventa_ValorRemision6',
            '$facturaventa_Remision7',
            '$facturaventa_ValorRemision7',
            '$facturaventa_Remision8',
            '$facturaventa_ValorRemision8',
            '$facturaventa_Remision9',
            '$facturaventa_ValorRemision9',
            '$facturaventa_Remision10',
            '$facturaventa_ValorRemision10',
            '$facturaventa_Remision11',
            '$facturaventa_ValorRemision11',
            '$facturaventa_Remision12',
            '$facturaventa_ValorRemision12',
            '$facturaventa_Remision13',
            '$facturaventa_ValorRemision13',
            '$facturaventa_Remision14',
            '$facturaventa_ValorRemision14',
            '$facturaventa_Remision15',
            '$facturaventa_ValorRemision15',
            '$facturaventa_Remision16',
            '$facturaventa_ValorRemision16',
            '$facturaventa_Remision17',
            '$facturaventa_ValorRemision17',
            '$facturaventa_Remision18',
            '$facturaventa_ValorRemision18',
            '$facturaventa_Remision19',
            '$facturaventa_ValorRemision19',
            '$facturaventa_Remision20',
            '$facturaventa_ValorRemision20',
            '$facturaventa_Remision21',
            '$facturaventa_ValorRemision21',
            '$facturaventa_Remision22',
            '$facturaventa_ValorRemision22',
            '$facturaventa_Remision23',
            '$facturaventa_ValorRemision23',
            '$facturaventa_Remision24',
            '$facturaventa_ValorRemision24',
            '$facturaventa_ValorSubtotal',
            '$facturaventa_PorcentajeDescuento',
            '$facturaventa_ValorDescuento',
            '$facturaventa_ValorIva',
            '$facturaventa_ValorRetefuente',
            '$facturaventa_ValorTotal',
            '$facturaventa_ValorCompras_13551501',
            '$facturaventa_ValorReteIVA_13551701',
            '$facturaventa_ValorDemasActividadIndustriales_13551804',
            '$facturaventa_ValorAutoRentaEspecial_23657501',
            '$facturaventa_ValorAutoRentaEspecial_13551541',
            '$facturaventa_ValorClientesNacionales_13050501',
            '$facturaventa_DB',
            '$facturaventa_HB',
            '$facturaventa_Saldo',
            '$facturaventa_Vendedor',
            '$facturaventa_Remision',
            '$facturaventa_Fecha',
            '$facturaventa_Observaciones')";

    if (mysqli_query($conn, $sql)) {
        $NewConsecutivo = numeroConsecutivo("FV")+1;
        $sql = "UPDATE consecutivo Set consecutivo_Numero='$NewConsecutivo' WHERE consecutivo_Id='4'";
        mysqli_query($conn, $sql);
        factura_CerrarCotizacion($facturaventa_Id);
        /*if ($facturaventa_Remision1 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision1'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision2 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision2'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision3 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision3'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision4 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision4'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision5 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision5'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision6 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision6'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision7 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision7'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision8 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision8'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision9 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision9'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision10 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision10'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision11 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision11'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision12 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision12'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision13 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision13'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision14 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision14'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision15 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision15'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision16 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision16'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision17 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision17'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision18 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision18'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision19 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision19'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision20 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision20'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision21 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision21'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision22 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision22'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision23 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision23'";
            mysqli_query($conn, $sql);
        }
        if ($facturaventa_Remision24 != null) {
            $sql = "UPDATE remision Set remision_FacturaVenta='$facturaventa_Id' WHERE remision_Id='$facturaventa_Remision24'";
            mysqli_query($conn, $sql);
        }*/
        mysqli_close($conn);
        header("Location: ConsultarFV? cc=$Documento&cs=$CS&msj=ORFV&FV=$facturaventa_Id");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: IngresarFV? cc=$Documento&cs=$CS&TR=$Tercero&IPFV=$codeProvFV&msj=ERFV");
        exit();
    }
?>