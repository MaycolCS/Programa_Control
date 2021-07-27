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

        /* Aqui empieza el código */

        $Tercero= $_GET['NT'];
        $codeProvisionalLG= $_GET['IPLEG'];
        if ($codeProvisionalLG == 0) {
            $NumAlt = rand(1000,20000);
            while (estaCodeProvLegalizacionCM($codeProvisionalLG)) {
                $NumAlt = rand(1000,20000);
            }
            $codeProvisionalLG = $NumAlt;
        }
        
        $NitTercero = intval(str_replace(",","",($_POST['nitCliente'])));
        if (!estaTercero($NitTercero)) {
            header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&msj=EST");
            exit();
        }
        $NombreTercero = nombreTercero($NitTercero);
        $CentroCosto= $_POST['CentroCosto'];
        $detalleItem= strtoupper($_POST['DetItem']);
        $cantidadItem= intval(str_replace(",","",($_POST['CantItem'])));
        $ValorUnidadItem= intval(str_replace(",","",($_POST['PreItem'])));
        $valorTotalItem= ($cantidadItem*$ValorUnidadItem);
        $ValorIva = intval(str_replace(",","",($_POST['IvaItem'])));
        $SubcuentaPUC= $_POST['subcuentaPUC'];
        if (!estaPucSubcuenta($SubcuentaPUC)) {
            header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&msj=ESCNE");
            exit();
        }

        $conn = conexionBD();
        $sql = "INSERT INTO legalizacion_cm_itemsprovisional 
                            (legalizacion_itemsprovisional_CodeProv,
                            legalizacion_itemsprovisional_Nit,
                            legalizacion_itemsprovisional_RazonSocial,
                            legalizacion_itemsprovisional_CentroCosto,
                            legalizacion_itemsprovisional_CuentaPuc,
                            legalizacion_itemsprovisional_Detalle,
                            legalizacion_itemsprovisional_Cantidad,
                            legalizacion_itemsprovisional_ValorUnitario,
                            legalizacion_itemsprovisional_ValorTotal,
                            legalizacion_itemsprovisional_Iva,
                            legalizacion_itemsprovisional_Usuario) 
                            VALUES 
                            ('$codeProvisionalLG',
                            '$NitTercero',
                            '$NombreTercero',
                            '$CentroCosto',
                            '$SubcuentaPUC',
                            '$detalleItem',
                            '$cantidadItem',
                            '$ValorUnidadItem',
                            '$valorTotalItem',
                            '$ValorIva',
                            '$Documento')";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: IngresarLegalizacion.php? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&msj=IALG");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: IngresarLegalizacion.php? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&msj=EIALG");
            exit();
        }
    }

?>