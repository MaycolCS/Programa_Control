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
            while (estaCodeProvLegalizacionCXP($codeProvisionalLG)) {
                $NumAlt = rand(1000,20000);
            }
            $codeProvisionalLG = $NumAlt;
        }
        
        $CentroCosto = $_GET['CCosto'];
        $FacturaCompra = $_GET['FC'];

        $detalleItem= strtoupper($_POST['DetItem']);
        $cantidadItem= intval(str_replace(",","",($_POST['CantItem'])));
        $ValorUnidadItem= intval(str_replace(",","",($_POST['PreItem'])));
        $valorTotalItem= ($cantidadItem*$ValorUnidadItem);
        $ValorIva = intval(str_replace(",","",($_POST['IvaItem'])));
        $SubcuentaPUC= $_POST['subcuentaPUC'];
        if (!estaPucSubcuenta($SubcuentaPUC)) {
            header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG$codeProvisionalLG&NT=$Tercero&CCosto=$CentroCosto&FC=$FacturaCompra&msj=ESCNE");
            exit();
        }

        $conn = conexionBD();
        $sql = "INSERT INTO legalizacion_cxp_itemsprovisional 
                            (legalizacion_itemsprovisional_CodeProv,
                            legalizacion_itemsprovisional_CuentaPUC,
                            legalizacion_itemsprovisional_Detalle,
                            legalizacion_itemsprovisional_Cantidad,
                            legalizacion_itemsprovisional_ValorUnitario,
                            legalizacion_itemsprovisional_ValorTotal,
                            legalizacion_itemsprovisional_Iva,
                            legalizacion_itemsprovisional_Usuario) 
                            VALUES 
                            ('$codeProvisionalLG',
                            '$SubcuentaPUC',
                            '$detalleItem',
                            '$cantidadItem',
                            '$ValorUnidadItem',
                            '$valorTotalItem',
                            '$ValorIva',
                            '$Documento')";

        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            header("Location: IngresarLegalizacion.php? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&CCosto=$CentroCosto&FC=$FacturaCompra&msj=IALG");
            exit();
        } else {
            mysqli_close($conn);
            header("Location: IngresarLegalizacion.php? cc=$Documento&cs=$CS&IPLEG=$codeProvisionalLG&NT=$Tercero&CCosto=$CentroCosto&FC=$FacturaCompra&msj=EIALG");
            exit();
        }
    }

?>