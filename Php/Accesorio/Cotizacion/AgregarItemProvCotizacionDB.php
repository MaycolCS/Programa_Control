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

    $PlantaTercero = $_GET['PTercero'];
    $TiempoEntrega= $_GET['TE'];
    $Descuento= $_GET['DCTO'];
    $nitTercero= $_GET['NT'];
    $codeProvCotizacion= $_GET['IPC'];
    if ($codeProvCotizacion == 0) {
        $NumAlt = rand(1000,20000);
        while (estaCodeProvCotizacion($IdProvisional)) {
            $NumAlt = rand(1000,20000);
        }
        $codeProvCotizacion = $NumAlt;
    }

    $TipoProducto = $_GET['TP'];
    $Producto = $_GET['PROD'];
    $detalleItem = "";

    $Malla_Tipo = "";
    $Malla_Hueco = "";
    $Malla_Calibre = "";
    $Malla_Ancho = 0;
    $Malla_Gancho = 0;
    $Malla_TipoGancho = "";
    $Malla_Largo = 0;
    $Malla_Traslapo = 0;

    if (isset($_POST['DetItem'])) {
        $detalleItem= strtoupper($_POST['DetItem']);
    }
    else {
        $Malla_Tipo = datos_Malla($Producto)[0];
        $Malla_Hueco = datos_Malla($Producto)[1];
        $Malla_Calibre = datos_Malla($Producto)[2];
        $Malla_Ancho = $_POST['Malla_Ancho'];
        $Malla_Gancho = $_POST['Malla_Gancho'];
        $Malla_TipoGancho = $_POST['Malla_TipoGancho'];
        $Malla_Largo = $_POST['Malla_Largo'];
        $Malla_Traslapo = $_POST['Malla_Traslapo'];

        $detalleItem = "MALLA ".$Malla_Tipo.", ";
        $detalleItem .= "ANCHO: ".$Malla_Ancho."(mts), ";
        $detalleItem .= "LARGO: ".$Malla_Largo."(mts), ";
        $detalleItem .= "HUECO: ".$Malla_Hueco."(mm), ";
        $detalleItem .= "CALIBRE: ".$Malla_Calibre."(mm), ";
        $detalleItem .= "TIPO DE GANCHO: ".$Malla_TipoGancho.", ";
        $detalleItem .= "GANCHO: ".$Malla_Gancho."(mts), ";
        $detalleItem .= "TRASLAPO: ".$Malla_Traslapo."(mts).";
    }
    $cantidadItem= intval(str_replace(",","",($_POST['CantItem'])));
    $precioItem= intval(str_replace(",","",($_POST['PreItem'])));
    $valorTotalItems= $cantidadItem*$precioItem;

    if (estaItemProvCotizacion($codeProvCotizacion,$detalleItem)) {
        header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&IPC=$codeProvCotizacion&NT=$nitTercero&TE=$TiempoEntrega&DCTO=$Descuento&PTercero=$PlantaTercero&msj=PEC");
        exit();
    }

    $conn = conexionBD();
    $sql = "";
    if ($TipoProducto == 1) {
        $sql = "INSERT INTO cotizacion_itemsprovisional 
                            (cotizacion_itemsprovisional_CodeProv,
                            cotizacion_itemsProvisional_TipoProducto,
                            cotizacion_itemsProvisional_IdProducto,
                            cotizacion_itemsProvisional_DetalleProducto,
                            cotizacion_itemsProvisional_CantidadProducto,
                            cotizacion_itemsProvisional_PrecioProducto,
                            cotizacion_itemsProvisional_ValorTotal,
                            cotizacion_Malla_Tipo,
                            cotizacion_Malla_Hueco,
                            cotizacion_Malla_Calibre,
                            cotizacion_Malla_Ancho,
                            cotizacion_Malla_Gancho,
                            cotizacion_Malla_TipoGancho,
                            cotizacion_Malla_Largo,
                            cotizacion_Malla_Traslapo,
                            cotizacion_itemsProvisional_Usuario) 
                            VALUES 
                            ('$codeProvCotizacion',
                            '$TipoProducto',
                            '$Producto',
                            '$detalleItem',
                            '$cantidadItem',
                            '$precioItem',
                            '$valorTotalItems',
                            '$Malla_Tipo',
                            '$Malla_Hueco',
                            '$Malla_Calibre',
                            '$Malla_Ancho',
                            '$Malla_Gancho',
                            '$Malla_TipoGancho',
                            '$Malla_Largo',
                            '$Malla_Traslapo',
                            '$Documento')";
    } else {
        $sql = "INSERT INTO cotizacion_itemsprovisional 
                            (cotizacion_itemsprovisional_CodeProv,
                            cotizacion_itemsProvisional_TipoProducto,
                            cotizacion_itemsProvisional_IdProducto,
                            cotizacion_itemsProvisional_DetalleProducto,
                            cotizacion_itemsProvisional_CantidadProducto,
                            cotizacion_itemsProvisional_PrecioProducto,
                            cotizacion_itemsProvisional_ValorTotal,
                            cotizacion_itemsProvisional_Usuario) 
                            VALUES 
                            ('$codeProvCotizacion',
                            '$TipoProducto',
                            '$Producto',
                            '$detalleItem',
                            '$cantidadItem',
                            '$precioItem',
                            '$valorTotalItems',
                            '$Documento')";
    }

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&IPC=$codeProvCotizacion&NT=$nitTercero&TE=$TiempoEntrega&DCTO=$Descuento&PTercero=$PlantaTercero&msj=PAC");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&IPC=$codeProvCotizacion&NT=$nitTercero&TE=$TiempoEntrega&DCTO=$Descuento&PTercero=$PlantaTercero&msj=EAPC");
        exit();
    }

?>