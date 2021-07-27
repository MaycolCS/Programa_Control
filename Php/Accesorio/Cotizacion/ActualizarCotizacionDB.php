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
    $cotizacion_Id = $_GET['cot'];
    $DatosCotizacion = datosCotizacion($cotizacion_Id);
    $cotizacion_Año = date("Y");
    $cotizacion_Mes = date("m");
    $cotizacion_Dia = date("d");

    $cotizacion_TiempoEntrega = $_POST['tiempoEntrega'];

    $cotizacion_Observaciones = $_POST['Observaciones'];

    $cotizacion_Cantidad_Item1 = 0;
    $cotizacion_ValorUnidad_Item1 = 0;
    $cotizacion_ValorTotal_Item1 = 0;

    $cotizacion_Cantidad_Item2 = 0;
    $cotizacion_ValorUnidad_Item2 = 0;
    $cotizacion_ValorTotal_Item2 = 0;

    $cotizacion_Cantidad_Item3 = 0;
    $cotizacion_ValorUnidad_Item3 = 0;
    $cotizacion_ValorTotal_Item3 = 0;

    $cotizacion_Cantidad_Item4 = 0;
    $cotizacion_ValorUnidad_Item4 = 0;
    $cotizacion_ValorTotal_Item4 = 0;

    $cotizacion_Cantidad_Item5 = 0;
    $cotizacion_ValorUnidad_Item5 = 0;
    $cotizacion_ValorTotal_Item5 = 0;

    $cotizacion_Cantidad_Item6 = 0;
    $cotizacion_ValorUnidad_Item6 = 0;
    $cotizacion_ValorTotal_Item6 = 0;

    $cotizacion_Cantidad_Item7 = 0;
    $cotizacion_ValorUnidad_Item7 = 0;
    $cotizacion_ValorTotal_Item7 = 0;

    $cotizacion_Cantidad_Item8 = 0;
    $cotizacion_ValorUnidad_Item8 = 0;
    $cotizacion_ValorTotal_Item8 = 0;

    $cotizacion_Cantidad_Item9 = 0;
    $cotizacion_ValorUnidad_Item9 = 0;
    $cotizacion_ValorTotal_Item9 = 0;

    $cotizacion_Cantidad_Item10 = 0;
    $cotizacion_ValorUnidad_Item10 = 0;
    $cotizacion_ValorTotal_Item10 = 0;

    $cotizacion_Cantidad_Item11 = 0;
    $cotizacion_ValorUnidad_Item11 = 0;
    $cotizacion_ValorTotal_Item11 = 0;

    $cotizacion_Cantidad_Item12 = 0;
    $cotizacion_ValorUnidad_Item12 = 0;
    $cotizacion_ValorTotal_Item12 = 0;

    $cotizacion_Subtotal = 0;

    if (isset($_POST['CantItem1'])) {
        $cotizacion_Cantidad_Item1 = intval(str_replace(",","",($_POST['CantItem1'])));
        $cotizacion_ValorUnidad_Item1 = intval(str_replace(",","",($_POST['PreItem1'])));
        $cotizacion_ValorTotal_Item1 = $cotizacion_Cantidad_Item1*$cotizacion_ValorUnidad_Item1;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item1;
    }
    if (isset($_POST['CantItem2'])) {
        $cotizacion_Cantidad_Item2 = intval(str_replace(",","",($_POST['CantItem2'])));
        $cotizacion_ValorUnidad_Item2 = intval(str_replace(",","",($_POST['PreItem2'])));
        $cotizacion_ValorTotal_Item2 = $cotizacion_Cantidad_Item2*$cotizacion_ValorUnidad_Item2;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item2;
    }
    if (isset($_POST['CantItem3'])) {
        $cotizacion_Cantidad_Item3 = intval(str_replace(",","",($_POST['CantItem3'])));
        $cotizacion_ValorUnidad_Item3 = intval(str_replace(",","",($_POST['PreItem3'])));
        $cotizacion_ValorTotal_Item3 = $cotizacion_Cantidad_Item3*$cotizacion_ValorUnidad_Item3;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item3;
    }
    if (isset($_POST['CantItem4'])) {
        $cotizacion_Cantidad_Item4 = intval(str_replace(",","",($_POST['CantItem4'])));
        $cotizacion_ValorUnidad_Item4 = intval(str_replace(",","",($_POST['PreItem4'])));
        $cotizacion_ValorTotal_Item4 = $cotizacion_Cantidad_Item4*$cotizacion_ValorUnidad_Item4;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item4;
    }
    if (isset($_POST['CantItem5'])) {
        $cotizacion_Cantidad_Item5 = intval(str_replace(",","",($_POST['CantItem5'])));
        $cotizacion_ValorUnidad_Item5 = intval(str_replace(",","",($_POST['PreItem5'])));
        $cotizacion_ValorTotal_Item5 = $cotizacion_Cantidad_Item5*$cotizacion_ValorUnidad_Item5;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item5;
    }
    if (isset($_POST['CantItem6'])) {
        $cotizacion_Cantidad_Item6 = intval(str_replace(",","",($_POST['CantItem6'])));
        $cotizacion_ValorUnidad_Item6 = intval(str_replace(",","",($_POST['PreItem6'])));
        $cotizacion_ValorTotal_Item6 = $cotizacion_Cantidad_Item6*$cotizacion_ValorUnidad_Item6;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item6;
    }
    if (isset($_POST['CantItem7'])) {
        $cotizacion_Cantidad_Item7 = intval(str_replace(",","",($_POST['CantItem7'])));
        $cotizacion_ValorUnidad_Item7 = intval(str_replace(",","",($_POST['PreItem7'])));
        $cotizacion_ValorTotal_Item7 = $cotizacion_Cantidad_Item7*$cotizacion_ValorUnidad_Item7;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item7;
    }
    if (isset($_POST['CantItem8'])) {
        $cotizacion_Cantidad_Item8 = intval(str_replace(",","",($_POST['CantItem8'])));
        $cotizacion_ValorUnidad_Item8 = intval(str_replace(",","",($_POST['PreItem8'])));
        $cotizacion_ValorTotal_Item8 = $cotizacion_Cantidad_Item8*$cotizacion_ValorUnidad_Item8;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item8;
    }
    if (isset($_POST['CantItem9'])) {
        $cotizacion_Cantidad_Item9 = intval(str_replace(",","",($_POST['CantItem9'])));
        $cotizacion_ValorUnidad_Item9 = intval(str_replace(",","",($_POST['PreItem9'])));
        $cotizacion_ValorTotal_Item9 = $cotizacion_Cantidad_Item9*$cotizacion_ValorUnidad_Item9;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item9;
    }
    if (isset($_POST['CantItem10'])) {
        $cotizacion_Cantidad_Item10 = intval(str_replace(",","",($_POST['CantItem10'])));
        $cotizacion_ValorUnidad_Item10 = intval(str_replace(",","",($_POST['PreItem10'])));
        $cotizacion_ValorTotal_Item10 = $cotizacion_Cantidad_Item10*$cotizacion_ValorUnidad_Item10;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item10;
    }
    if (isset($_POST['CantItem11'])) {
        $cotizacion_Cantidad_Item11 = intval(str_replace(",","",($_POST['CantItem11'])));
        $cotizacion_ValorUnidad_Item11 = intval(str_replace(",","",($_POST['PreItem11'])));
        $cotizacion_ValorTotal_Item11 = $cotizacion_Cantidad_Item11*$cotizacion_ValorUnidad_Item11;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item11;
    }
    if (isset($_POST['CantItem12'])) {
        $cotizacion_Cantidad_Item12 = intval(str_replace(",","",($_POST['CantItem12'])));
        $cotizacion_ValorUnidad_Item12 = intval(str_replace(",","",($_POST['PreItem12'])));
        $cotizacion_ValorTotal_Item12 = $cotizacion_Cantidad_Item12*$cotizacion_ValorUnidad_Item12;
        $cotizacion_Subtotal += $cotizacion_ValorTotal_Item12;
    }

    $cotizacion_PorcentajeDescuento = number_format($DatosCotizacion['cotizacion_PorcentajeDescuento']);
    $cotizacion_ValorDescuento = round($cotizacion_Subtotal*($cotizacion_PorcentajeDescuento/100));
    $cotizacion_ValorIVA = round(($cotizacion_Subtotal-($cotizacion_Subtotal*($cotizacion_PorcentajeDescuento/100)))*0.19);
    $cotizacion_ValorTotal = round($cotizacion_Subtotal-$cotizacion_ValorDescuento+$cotizacion_ValorIVA);
    $cotizacion_Vendedor = $Documento;
    $cotizacion_Fecha = date("Y-m-d");

    $conn = conexionBD();
    $sql = "UPDATE cotizacion Set 
            cotizacion_Año='$cotizacion_Año',
            cotizacion_Mes='$cotizacion_Mes',
            cotizacion_Dia='$cotizacion_Dia',
            cotizacion_TiempoEntrega='$cotizacion_TiempoEntrega',
            cotizacion_Cantidad_Item1='$cotizacion_Cantidad_Item1',
            cotizacion_ValorUnidad_Item1='$cotizacion_ValorUnidad_Item1',
            cotizacion_ValorTotal_Item1='$cotizacion_ValorTotal_Item1',
            cotizacion_Cantidad_Item2='$cotizacion_Cantidad_Item2',
            cotizacion_ValorUnidad_Item2='$cotizacion_ValorUnidad_Item2',
            cotizacion_ValorTotal_Item2='$cotizacion_ValorTotal_Item2',
            cotizacion_Cantidad_Item3='$cotizacion_Cantidad_Item3',
            cotizacion_ValorUnidad_Item3='$cotizacion_ValorUnidad_Item3',
            cotizacion_ValorTotal_Item3='$cotizacion_ValorTotal_Item3',
            cotizacion_Cantidad_Item4='$cotizacion_Cantidad_Item4',
            cotizacion_ValorUnidad_Item4='$cotizacion_ValorUnidad_Item4',
            cotizacion_ValorTotal_Item4='$cotizacion_ValorTotal_Item4',
            cotizacion_Cantidad_Item5='$cotizacion_Cantidad_Item5',
            cotizacion_ValorUnidad_Item5='$cotizacion_ValorUnidad_Item5',
            cotizacion_ValorTotal_Item5='$cotizacion_ValorTotal_Item5',
            cotizacion_Cantidad_Item6='$cotizacion_Cantidad_Item6',
            cotizacion_ValorUnidad_Item6='$cotizacion_ValorUnidad_Item6',
            cotizacion_ValorTotal_Item6='$cotizacion_ValorTotal_Item6',
            cotizacion_Cantidad_Item7='$cotizacion_Cantidad_Item7',
            cotizacion_ValorUnidad_Item7='$cotizacion_ValorUnidad_Item7',
            cotizacion_ValorTotal_Item7='$cotizacion_ValorTotal_Item7',
            cotizacion_Cantidad_Item8='$cotizacion_Cantidad_Item8',
            cotizacion_ValorUnidad_Item8='$cotizacion_ValorUnidad_Item8',
            cotizacion_ValorTotal_Item8='$cotizacion_ValorTotal_Item8',
            cotizacion_Cantidad_Item9='$cotizacion_Cantidad_Item9',
            cotizacion_ValorUnidad_Item9='$cotizacion_ValorUnidad_Item9',
            cotizacion_ValorTotal_Item9='$cotizacion_ValorTotal_Item9',
            cotizacion_Cantidad_Item10='$cotizacion_Cantidad_Item10',
            cotizacion_ValorUnidad_Item10='$cotizacion_ValorUnidad_Item10',
            cotizacion_ValorTotal_Item10='$cotizacion_ValorTotal_Item10',
            cotizacion_Cantidad_Item11='$cotizacion_Cantidad_Item11',
            cotizacion_ValorUnidad_Item11='$cotizacion_ValorUnidad_Item11',
            cotizacion_ValorTotal_Item11='$cotizacion_ValorTotal_Item11',
            cotizacion_Cantidad_Item12='$cotizacion_Cantidad_Item12',
            cotizacion_ValorUnidad_Item12='$cotizacion_ValorUnidad_Item12',
            cotizacion_ValorTotal_Item12='$cotizacion_ValorTotal_Item12',
            cotizacion_Subtotal='$cotizacion_Subtotal',
            cotizacion_ValorDescuento='$cotizacion_ValorDescuento',
            cotizacion_ValorIVA='$cotizacion_ValorIVA',
            cotizacion_ValorTotal='$cotizacion_ValorTotal',
            cotizacion_Vendedor='$cotizacion_Vendedor',
            cotizacion_Fecha='$cotizacion_Fecha',
            cotizacion_Observaciones='$cotizacion_Observaciones'
            WHERE cotizacion_Id='$cotizacion_Id'";
    if (mysqli_query($conn, $sql)) {
        $Datos_ItemsCotizacion = itemsCotizacion($cotizacion_Id);
        for ($i = 0; $i < count($Datos_ItemsCotizacion); $i += 4) {
            actualizarDatosPlanillaPlanta($cotizacion_Id, $Datos_ItemsCotizacion[$i], $Datos_ItemsCotizacion[$i+1]);
        }
        mysqli_close($conn);
        header("Location: ConsultarCotizacion? cc=$Documento&cs=$CS&msj=OACOT&cot=$cotizacion_Id");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ERCOT");
        exit();
    }

?>