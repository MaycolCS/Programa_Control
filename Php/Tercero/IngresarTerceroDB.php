<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(12,15,16,22,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    } 

    /* Aqui empieza el código */

    $Leg=$_GET['Leg'];

    $nitTercero = intval(str_replace(",","",($_POST['nitTercero'])));
    $dvTercero = intval(str_replace(",","",($_POST['dvTercero'])));
    $nombreTerceroPost = $_POST['nombreTercero'];
    $nombreTercero= strtoupper($nombreTerceroPost);
    $contactoTerceroPost = $_POST['contactoTercero'];
    $contactoTercero= strtoupper($contactoTerceroPost);
    $direcciónTerceroPost = $_POST['direcciónTercero'];
    $direcciónTercero= strtoupper($direcciónTerceroPost);
    $DepartamentoTercero = $_POST['Departamento'];
    $ciudadTercero = $_POST['ciudadTercero'];
    $telefono1Tercero = $_POST['telefono1Tercero'];
    $telefono2Tercero = $_POST['telefono2Tercero'];
    $emailTercero = $_POST['emailTercero'];
    $formaPagoTercero = $_POST['formaPagoTercero'];
    $DiaPagoTercero = $_POST['diasPago'];
    $tipoTercero = $_POST['tipoTercero'];
    
    $RetefuenteTercero = $_POST['RetefuenteTercero'];
    $DescuentoTercero = $_POST['DescuentoTercero'];
    if ($DescuentoTercero == "") {
        $DescuentoTercero = 0;
    }
    $ubicacionTercero = $_POST['ubicacionTercero'];
    
    if (estaTercero($nitTercero)) {
        header("Location: IngresarTercero.php? cc=$Documento&cs=$CS&msj=ERT");
        exit();
    }
    
    $conn = conexionBD();
    $sql = "INSERT INTO tercero 
                        VALUES 
                        ('$nitTercero',
                        '$dvTercero',
                        '$nombreTercero',
                        '$contactoTercero',
                        '$direcciónTercero',
                        '$DepartamentoTercero',
                        '$ciudadTercero',
                        '$telefono1Tercero',
                        '$telefono2Tercero',
                        '$DiaPagoTercero',
                        '$emailTercero',
                        '$formaPagoTercero',
                        '$RetefuenteTercero',
                        '$DescuentoTercero',
                        '$ubicacionTercero',
                        '$tipoTercero')";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        if ($Leg != "") {
            if ($Leg == "CM") {
                $Tercero = $_GET['NT'];
                $IdProvLegalizacion = $_GET['IPLEG'];
                header("Location: ../Legalizacion_CM/IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG=$IdProvLegalizacion&NT=$Tercero&msj=ORT");
                exit();
            }
        } else {
            header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ORT");
            exit();
        }
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ERT");
        exit();
    }

?>