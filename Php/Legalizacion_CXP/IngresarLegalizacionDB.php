<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    else if (!validarPermisosUsuario($Documento,array(15,16,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    else {
        $legalizacion_Id = datosConsecutivo("CXP");
        $legalizacion_Año = date("Y");
        $legalizacion_Mes = date("m");
        $legalizacion_Dia = date("d");

        $Tercero = $_GET['NT'];
        $DatosTercero = datosTercero($Tercero);
        $legalizacion_NitTercero = $DatosTercero[0];
        $legalizacion_DVTercero = $DatosTercero[1];
        $legalizacion_RazonSocialTercero = $DatosTercero[2];
        $legalizacion_cxp_TelefonoTercero = $DatosTercero[7];
        $legalizacion_cxp_EmailTercero = $DatosTercero[10];
        $legalizacion_cxp_CiudadTercero = nombreCiudad($DatosTercero[6]);
        $legalizacion_cxp_DireccionTercero = $DatosTercero[4];

        $legalizacion_cxp_CentroCosto = $_GET['CCosto'];
        $legalizacion_cxp_FacturaCompra = $_GET['FC'];

        $legalizacion_cxp_NitCliente = datosCotizacion($legalizacion_cxp_CentroCosto)['cotizacion_NitTercero'];   
        $legalizacion_cxp_RazonSocialCliente = nombreTercero(datosCotizacion($legalizacion_cxp_CentroCosto)['cotizacion_NitTercero']);
        
        $legalizacion_Usuario = $Documento;

        $IdProvLegalizacion = $_GET['IPLEG'];
        $ItemsProvLegalizacion = listaItemsProvLegalizacionCXP($IdProvLegalizacion);
        $cant_ItemsProvLegalizacion = count($ItemsProvLegalizacion);
        $aux_cant_ItemsProvLegalizacion = 0;

        $conn = conexionBD();
        $intentos = 0;
        while (($aux_cant_ItemsProvLegalizacion < $cant_ItemsProvLegalizacion) and ($intentos < 3)) {
            $Detalle = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion];
            $Cantidad = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+1];
            $ValorUnitario = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+2];
            $ValorTotal = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+3];
            $ValorIva = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+4];
            $CuentaPUC = $ItemsProvLegalizacion[$aux_cant_ItemsProvLegalizacion+6];

            $sql = "INSERT INTO legalizacion_cxp 
                                (legalizacion_cxp_Id,
                                legalizacion_cxp_Año,
                                legalizacion_cxp_Mes,
                                legalizacion_cxp_Dia,
                                legalizacion_cxp_NitTercero,
                                legalizacion_cxp_DVTercero,
                                legalizacion_cxp_RazonSocialTercero,
                                legalizacion_cxp_TelefonoTercero,
                                legalizacion_cxp_EmailTercero,
                                legalizacion_cxp_CiudadTercero,
                                legalizacion_cxp_DireccionTercero,
                                legalizacion_cxp_CentroCosto,
                                legalizacion_cxp_FacturaCompra,
                                legalizacion_cxp_NitCliente,
                                legalizacion_cxp_RazonSocialCliente,
                                legalizacion_cxp_Cuenta,
                                legalizacion_cxp_Detalle,
                                legalizacion_cxp_Cantidad,
                                legalizacion_cxp_ValorUnitario,
                                legalizacion_cxp_ValorTotal,
                                legalizacion_cxp_ValorIva,
                                legalizacion_cxp_Usuario)
                                VALUES 
                                ('$legalizacion_Id',
                                '$legalizacion_Año',
                                '$legalizacion_Mes',
                                '$legalizacion_Dia',
                                '$legalizacion_NitTercero',
                                '$legalizacion_DVTercero',
                                '$legalizacion_RazonSocialTercero',
                                '$legalizacion_cxp_TelefonoTercero',
                                '$legalizacion_cxp_EmailTercero',
                                '$legalizacion_cxp_CiudadTercero',
                                '$legalizacion_cxp_DireccionTercero',
                                '$legalizacion_cxp_CentroCosto',
                                '$legalizacion_cxp_FacturaCompra',
                                '$legalizacion_cxp_NitCliente',
                                '$legalizacion_cxp_RazonSocialCliente',
                                '$CuentaPUC',
                                '$Detalle',
                                '$Cantidad',
                                '$ValorUnitario',
                                '$ValorTotal',
                                '$ValorIva',
                                '$legalizacion_Usuario')";
            if (mysqli_query($conn, $sql)) {
                $aux_cant_ItemsProvLegalizacion = $aux_cant_ItemsProvLegalizacion+7;
                $intentos = 0;
            } else {
                $intentos = $intentos + 1;
            }
            
        }
        
        if ($intentos == 3) {
            header("Location: IngresarLegalizacion.php? cc=$Documento&cs=$CS&IPLEG=$IdProvLegalizacion&NT=$Tercero&msj=ERLEG");
            exit();
        } else {
            $NewConsecutivo = numeroConsecutivo("CXP")+1;
            $sql = "UPDATE consecutivo Set consecutivo_Numero='$NewConsecutivo' WHERE consecutivo_Id='6'";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            header("Location: ConsultarLegalizacion? cc=$Documento&cs=$CS&msj=ORLEG&LEG=$legalizacion_Id");
            exit();
        }
    }

?>