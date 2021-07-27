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
        $cuentaPUC = $_POST['cuentaPUC'];
        $subcuentaPUC = strtoupper($_POST['subcuentaPUC']);
        if (!estaPucCuenta($cuentaPUC)) {
            header("Location: IngresarSubcuenta? cc=$Documento&cs=$CS&msj=ECNE");
            exit();
        } else {
            if (estaPucSubcuenta($DetallePucSubcuenta)) {
                header("Location: IngresarSubcuenta? cc=$Documento&cs=$CS&msj=ESCE");
                exit();
            }
            else {
                $consecutivoSubcuenta = nuevoConsecutivoSubcuenta_PucCuenta($cuentaPUC);
                $conn = conexionBD();
                $sql = "INSERT INTO puc_subcuenta VALUES ('$consecutivoSubcuenta','$subcuentaPUC','$cuentaPUC','$Documento')";
                if (mysqli_query($conn, $sql)) {
                    $newConsecutivoCuenta = consecutivoPucCuenta($cuentaPUC);
                    $sql = "UPDATE puc_cuenta Set puc_cuenta_Consecutivo='$newConsecutivoCuenta' WHERE puc_cuenta_Id='$cuentaPUC'";
                    mysqli_query($conn, $sql);
                    mysqli_close($conn);
                    header("Location: ../MainPage.php? cc=$Documento&cs=$CS&SC=$consecutivoSubcuenta&DSC=$subcuentaPUC&msj=ORSC");
                    exit();
                } else {
                    mysqli_close($conn);
                    header("Location: IngresarSubcuenta? cc=$Documento&cs=$CS&msj=ERSC");
                    exit();
                }
            }
        }
    }

?>