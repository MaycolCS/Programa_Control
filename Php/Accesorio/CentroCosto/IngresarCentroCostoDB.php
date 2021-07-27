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
    
        $CentroCosto = strtoupper($_POST['CentroCosto']);

        if (estaCentroCosto($CentroCosto)) {
            header("Location: IngresarCentroCosto.php? cc=$Documento&cs=$CS&msj=ECC");
            exit();
        }
        else {
            $NewConsecutivo = ConsecutivoCentroCosto()+1;
            if ($NewConsecutivo == 0) {
                $NewConsecutivo = 1;
            }
            $Consecutivo_CentroCosto = "C.C.-00".$NewConsecutivo;
            $conn = conexionBD();
            $sql = "INSERT INTO centro_costo (centro_costo_Consecutivo, centro_costo_Detalle) VALUES ('$Consecutivo_CentroCosto','$CentroCosto')";

            if (mysqli_query($conn, $sql)) {
                mysqli_close($conn);
                header("Location: ../MainPage.php? cc=$Documento&cs=$CS&CentroCosto=$Consecutivo_CentroCosto&msj=ORCC");
                exit();
            } else {
                mysqli_close($conn);
                header("Location: IngresarCentroCosto.php? cc=$Documento&cs=$CS&msj=ERCC");
                exit();
            }
        }
    }

?>