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
    $cotizacion_Id = datosConsecutivo("COTIZACION");
    $cotizacion_Año = date("Y");
    $cotizacion_Mes = date("m");
    $cotizacion_Dia = date("d");

    $cotizacion_NitTercero = $_GET['NT'];
    $cotizacion_TiempoEntrega = $_GET['TE'];
    $cotizacion_PlantaEntrega = $_GET['PTercero'];

    $cotizacion_Observaciones = $_POST['Observaciones'];

    $cotizacion_Detalle_Item1 = null;
    $cotizacion_Cantidad_Item1 = null;
    $cotizacion_ValorUnidad_Item1 = null;
    $cotizacion_ValorTotal_Item1 = null;

    $cotizacion_Detalle_Item2 = null;
    $cotizacion_Cantidad_Item2 = null;
    $cotizacion_ValorUnidad_Item2 = null;
    $cotizacion_ValorTotal_Item2 = null;

    $cotizacion_Detalle_Item3 = null;
    $cotizacion_Cantidad_Item3 = null;
    $cotizacion_ValorUnidad_Item3 = null;
    $cotizacion_ValorTotal_Item3 = null;

    $cotizacion_Detalle_Item4 = null;
    $cotizacion_Cantidad_Item4 = null;
    $cotizacion_ValorUnidad_Item4 = null;
    $cotizacion_ValorTotal_Item4 = null;

    $cotizacion_Detalle_Item5 = null;
    $cotizacion_Cantidad_Item5 = null;
    $cotizacion_ValorUnidad_Item5 = null;
    $cotizacion_ValorTotal_Item5 = null;

    $cotizacion_Detalle_Item6 = null;
    $cotizacion_Cantidad_Item6 = null;
    $cotizacion_ValorUnidad_Item6 = null;
    $cotizacion_ValorTotal_Item6 = null;

    $cotizacion_Detalle_Item7 = null;
    $cotizacion_Cantidad_Item7 = null;
    $cotizacion_ValorUnidad_Item7 = null;
    $cotizacion_ValorTotal_Item7 = null;

    $cotizacion_Detalle_Item8 = null;
    $cotizacion_Cantidad_Item8 = null;
    $cotizacion_ValorUnidad_Item8 = null;
    $cotizacion_ValorTotal_Item8 = null;

    $cotizacion_Detalle_Item9 = null;
    $cotizacion_Cantidad_Item9 = null;
    $cotizacion_ValorUnidad_Item9 = null;
    $cotizacion_ValorTotal_Item9 = null;

    $cotizacion_Detalle_Item10 = null;
    $cotizacion_Cantidad_Item10 = null;
    $cotizacion_ValorUnidad_Item10 = null;
    $cotizacion_ValorTotal_Item10 = null;

    $cotizacion_Detalle_Item11 = null;
    $cotizacion_Cantidad_Item11 = null;
    $cotizacion_ValorUnidad_Item11 = null;
    $cotizacion_ValorTotal_Item11 = null;

    $cotizacion_Detalle_Item12 = null;
    $cotizacion_Cantidad_Item12 = null;
    $cotizacion_ValorUnidad_Item12 = null;
    $cotizacion_ValorTotal_Item12 = null;

    $IdProvCotizacion = $_GET['IPC'];
    $ItemsProvCotizacion = listaItemsProvCotizacion($IdProvCotizacion);
    $cant_ItemsProvCotizacion = count($ItemsProvCotizacion);
    $aux_cant_ItemsProvCotizacion = 0;
    $contItem = ($cant_ItemsProvCotizacion/4);
    $auxContItem = 1;
    $celdasRelleno = 0;
    $cotizacion_Subtotal = 0;
    while ($aux_cant_ItemsProvCotizacion < $cant_ItemsProvCotizacion) {
        if ($auxContItem == 1) {
            $cotizacion_Detalle_Item1 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item1 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item1 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item1 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 2) {
            $cotizacion_Detalle_Item2 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item2 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item2 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item2 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 3) {
            $cotizacion_Detalle_Item3 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item3 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item3 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item3 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 4) {
            $cotizacion_Detalle_Item4 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item4 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item4 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item4 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 5) {
            $cotizacion_Detalle_Item5 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item5 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item5 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item5 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 6) {
            $cotizacion_Detalle_Item6 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item6 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item6 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item6 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 7) {
            $cotizacion_Detalle_Item7 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item7 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item7 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item7 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 8) {
            $cotizacion_Detalle_Item8 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item8 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item8 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item8 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 9) {
            $cotizacion_Detalle_Item9 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item9 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item9 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item9 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 10) {
            $cotizacion_Detalle_Item10 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item10 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item10 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item10 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 11) {
            $cotizacion_Detalle_Item11 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item11 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item11 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item11 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        } elseif ($auxContItem == 12) {
            $cotizacion_Detalle_Item12 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];
            $cotizacion_Cantidad_Item12 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];
            $cotizacion_ValorUnidad_Item12 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2];
            $cotizacion_ValorTotal_Item12 = $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        }
        $cotizacion_Subtotal = $cotizacion_Subtotal + $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];
        $auxContItem = $auxContItem + 1;
        $aux_cant_ItemsProvCotizacion = $aux_cant_ItemsProvCotizacion+5;
    }

    $cotizacion_PorcentajeDescuento = $_GET['DCTO'];
    $cotizacion_ValorDescuento = round($cotizacion_Subtotal*($cotizacion_PorcentajeDescuento/100));
    $cotizacion_ValorIVA = round(($cotizacion_Subtotal-($cotizacion_Subtotal*($cotizacion_PorcentajeDescuento/100)))*0.19);
    $cotizacion_ValorTotal = round($cotizacion_Subtotal-$cotizacion_ValorDescuento+$cotizacion_ValorIVA);
    $cotizacion_Vendedor = $Documento;
    $cotizacion_Fecha = date("Y-m-d");

    $conn = conexionBD();
    $sql = "INSERT INTO cotizacion 
            (cotizacion_Id,
            cotizacion_Año,
            cotizacion_Mes,
            cotizacion_Dia,
            cotizacion_NitTercero,
            cotizacion_TiempoEntrega,
            cotizacion_PlantaEntrega,
            cotizacion_Detalle_Item1,
            cotizacion_Cantidad_Item1,
            cotizacion_ValorUnidad_Item1,
            cotizacion_ValorTotal_Item1,
            cotizacion_Detalle_Item2,
            cotizacion_Cantidad_Item2,
            cotizacion_ValorUnidad_Item2,
            cotizacion_ValorTotal_Item2,
            cotizacion_Detalle_Item3,
            cotizacion_Cantidad_Item3,
            cotizacion_ValorUnidad_Item3,
            cotizacion_ValorTotal_Item3,
            cotizacion_Detalle_Item4,
            cotizacion_Cantidad_Item4,
            cotizacion_ValorUnidad_Item4,
            cotizacion_ValorTotal_Item4,
            cotizacion_Detalle_Item5,
            cotizacion_Cantidad_Item5,
            cotizacion_ValorUnidad_Item5,
            cotizacion_ValorTotal_Item5,
            cotizacion_Detalle_Item6,
            cotizacion_Cantidad_Item6,
            cotizacion_ValorUnidad_Item6,
            cotizacion_ValorTotal_Item6,
            cotizacion_Detalle_Item7,
            cotizacion_Cantidad_Item7,
            cotizacion_ValorUnidad_Item7,
            cotizacion_ValorTotal_Item7,
            cotizacion_Detalle_Item8,
            cotizacion_Cantidad_Item8,
            cotizacion_ValorUnidad_Item8,
            cotizacion_ValorTotal_Item8,
            cotizacion_Detalle_Item9,
            cotizacion_Cantidad_Item9,
            cotizacion_ValorUnidad_Item9,
            cotizacion_ValorTotal_Item9,
            cotizacion_Detalle_Item10,
            cotizacion_Cantidad_Item10,
            cotizacion_ValorUnidad_Item10,
            cotizacion_ValorTotal_Item10,
            cotizacion_Detalle_Item11,
            cotizacion_Cantidad_Item11,
            cotizacion_ValorUnidad_Item11,
            cotizacion_ValorTotal_Item11,
            cotizacion_Detalle_Item12,
            cotizacion_Cantidad_Item12,
            cotizacion_ValorUnidad_Item12,
            cotizacion_ValorTotal_Item12,
            cotizacion_Subtotal,
            cotizacion_PorcentajeDescuento,
            cotizacion_ValorDescuento,
            cotizacion_ValorIVA,
            cotizacion_ValorTotal,
            cotizacion_Vendedor,
            cotizacion_Fecha,
            cotizacion_Observaciones)
            VALUES ('$cotizacion_Id',
            '$cotizacion_Año',
            '$cotizacion_Mes',
            '$cotizacion_Dia',
            '$cotizacion_NitTercero',
            '$cotizacion_TiempoEntrega',
            '$cotizacion_PlantaEntrega',
            '$cotizacion_Detalle_Item1',
            '$cotizacion_Cantidad_Item1',
            '$cotizacion_ValorUnidad_Item1',
            '$cotizacion_ValorTotal_Item1',
            '$cotizacion_Detalle_Item2',
            '$cotizacion_Cantidad_Item2',
            '$cotizacion_ValorUnidad_Item2',
            '$cotizacion_ValorTotal_Item2',
            '$cotizacion_Detalle_Item3',
            '$cotizacion_Cantidad_Item3',
            '$cotizacion_ValorUnidad_Item3',
            '$cotizacion_ValorTotal_Item3',
            '$cotizacion_Detalle_Item4',
            '$cotizacion_Cantidad_Item4',
            '$cotizacion_ValorUnidad_Item4',
            '$cotizacion_ValorTotal_Item4',
            '$cotizacion_Detalle_Item5',
            '$cotizacion_Cantidad_Item5',
            '$cotizacion_ValorUnidad_Item5',
            '$cotizacion_ValorTotal_Item5',
            '$cotizacion_Detalle_Item6',
            '$cotizacion_Cantidad_Item6',
            '$cotizacion_ValorUnidad_Item6',
            '$cotizacion_ValorTotal_Item6',
            '$cotizacion_Detalle_Item7',
            '$cotizacion_Cantidad_Item7',
            '$cotizacion_ValorUnidad_Item7',
            '$cotizacion_ValorTotal_Item7',
            '$cotizacion_Detalle_Item8',
            '$cotizacion_Cantidad_Item8',
            '$cotizacion_ValorUnidad_Item8',
            '$cotizacion_ValorTotal_Item8',
            '$cotizacion_Detalle_Item9',
            '$cotizacion_Cantidad_Item9',
            '$cotizacion_ValorUnidad_Item9',
            '$cotizacion_ValorTotal_Item9',
            '$cotizacion_Detalle_Item10',
            '$cotizacion_Cantidad_Item10',
            '$cotizacion_ValorUnidad_Item10',
            '$cotizacion_ValorTotal_Item10',
            '$cotizacion_Detalle_Item11',
            '$cotizacion_Cantidad_Item11',
            '$cotizacion_ValorUnidad_Item11',
            '$cotizacion_ValorTotal_Item11',
            '$cotizacion_Detalle_Item12',
            '$cotizacion_Cantidad_Item12',
            '$cotizacion_ValorUnidad_Item12',
            '$cotizacion_ValorTotal_Item12',
            '$cotizacion_Subtotal',
            '$cotizacion_PorcentajeDescuento',
            '$cotizacion_ValorDescuento',
            '$cotizacion_ValorIVA',
            '$cotizacion_ValorTotal',
            '$cotizacion_Vendedor',
            '$cotizacion_Fecha',
            '$cotizacion_Observaciones')";
    if (mysqli_query($conn, $sql)) {
        $NewConsecutivo = numeroConsecutivo("COTIZACION")+1;
        $sql = "UPDATE consecutivo Set consecutivo_Numero='$NewConsecutivo'WHERE consecutivo_Id='1'";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        insertarDatosPlanillaPlanta($IdProvCotizacion,$cotizacion_Id);
        header("Location: ConsultarCotizacion? cc=$Documento&cs=$CS&msj=ORCOT&cot=$cotizacion_Id");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ERCOT");
        exit();
    }

?>