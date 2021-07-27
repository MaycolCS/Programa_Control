<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(15,16,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */
    $legalizacion_Id = datosConsecutivo("LEG");
    $legalizacion_Año = date("Y");
    $legalizacion_Mes = date("m");
    $legalizacion_Dia = date("d");

    $Tercero = $_GET['NT'];
    $DatosTercero = datosTercero($Tercero);
    $legalizacion_NitTercero = $DatosTercero[0];
    $legalizacion_DVTercero = $DatosTercero[1];
    $legalizacion_RazonSocialTercero = $DatosTercero[2];
    $legalizacion_Usuario = $Documento;

    $IdProvLegalizacion = $_GET['IPLEG'];
    $ItemsProvLegalizacion = listaItemsProvLegalizacionCM($IdProvLegalizacion);
    $cant_ItemsProvLegalizacion = count($ItemsProvLegalizacion);
    $aux_cant_ItemsProvLegalizacion = 0;

    $legalizacion_Subtotal = 0;
    $legalizacion_ValorIva = 0;
    $legalizacion_Retefuente = 0;
    $legalizacion_ReteIva = 0;
    $legalizacion_ReteIca = 0;
    $conn = conexionBD();
    $intentos = 0;
    while (($aux_cant_ItemsProvLegalizacion < $cant_ItemsProvLegalizacion) and ($intentos < 3)) {
        $Nit = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion];
        $RazonSocial = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+1];
        $CentroCosto = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+2];
        $Detalle = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+3];
        $Cantidad = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+4];
        $ValorUnitario = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+5];
        $ValorTotal = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+6];
        $ValorIva = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+7];
        $CuentaPUC = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+9];

        $sql = "INSERT INTO legalizacion_cm 
                            (legalizacion_cm_Id,
                            legalizacion_cm_Año,
                            legalizacion_cm_Mes,
                            legalizacion_cm_Dia,
                            legalizacion_cm_NitTercero,
                            legalizacion_cm_DVTercero,
                            legalizacion_cm_RazonSocialTercero,
                            legalizacion_cm_CentroCosto,
                            legalizacion_cm_Nit,
                            legalizacion_cm_RazonSocial,
                            legalizacion_cm_Cuenta,
                            legalizacion_cm_Detalle,
                            legalizacion_cm_Cantidad,
                            legalizacion_cm_ValorUnitario,
                            legalizacion_cm_ValorTotal,
                            legalizacion_cm_ValorIva,
                            legalizacion_cm_Usuario)
                            VALUES 
                            ('$legalizacion_Id',
                            '$legalizacion_Año',
                            '$legalizacion_Mes',
                            '$legalizacion_Dia',
                            '$legalizacion_NitTercero',
                            '$legalizacion_DVTercero',
                            '$legalizacion_RazonSocialTercero',
                            '$CentroCosto',
                            '$Nit',
                            '$RazonSocial',
                            '$CuentaPUC',
                            '$Detalle',
                            '$Cantidad',
                            '$ValorUnitario',
                            '$ValorTotal',
                            '$ValorIva',
                            '$legalizacion_Usuario')";
        if (mysqli_query($conn, $sql)) {
            $aux_cant_ItemsProvLegalizacion = $aux_cant_ItemsProvLegalizacion+10;
            $intentos = 0;
        } else {
            $intentos = $intentos + 1;
        }
        
    }
    
    if ($intentos == 3) {
        header("Location: IngresarLegalizacion.php? cc=$Documento&cs=$CS&IPLEG=$IdProvLegalizacion&NT=$Tercero&msj=ERLEG");
        exit();
    } else {
        $NewConsecutivo = numeroConsecutivo("LEG")+1;
        $sql = "UPDATE consecutivo Set consecutivo_Numero='$NewConsecutivo'WHERE consecutivo_Id='5'";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
        header("Location: ConsultarLegalizacion? cc=$Documento&cs=$CS&msj=ORLEG&LEG=$legalizacion_Id");
        exit();
    }

?>