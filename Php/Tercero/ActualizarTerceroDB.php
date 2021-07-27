<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(22,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $nitTercero= $_POST['nitTercero'];
    $dvTercero= $_POST['dvTercero'];
    $nombreTerceroPost= $_POST['nombreTercero'];
    $nombreTercero= strtoupper($nombreTerceroPost);
    $contactoTerceroPost= $_POST['contactoTercero'];
    $contactoTercero= strtoupper($contactoTerceroPost);
    $direcciónTerceroPost= $_POST['direcciónTercero'];
    $direcciónTercero= strtoupper($direcciónTerceroPost);
    $DepartamentoTercero= $_POST['Departamento'];
    $ciudadTercero= $_POST['ciudadTercero'];
    $telefono1Tercero= $_POST['telefono1Tercero'];
    $telefono2Tercero= $_POST['telefono2Tercero'];
    $DiaPagoTercero= $_POST['diasPago'];
    $emailTercero= $_POST['emailTercero'];
    $formaPagoTercero= $_POST['formaPagoTercero'];
    $RetefuenteTercero= $_POST['RetefuenteTercero'];
    $DescuentoTercero= $_POST['DescuentoTercero'];
    $ubicacionTercero = $_POST['ubicacionTercero'];
    $tipoTercero = $_POST['tipoTercero'];
    
    $conn = conexionBD();    
    $sql = "UPDATE tercero Set tercero_Dv='$dvTercero', tercero_RazonSocial='$nombreTercero', tercero_Contacto='$contactoTercero', tercero_Direccion='$direcciónTercero', tercero_Departamento='$DepartamentoTercero', tercero_Ciudad='$ciudadTercero', tercero_Telefono1='$telefono1Tercero', tercero_Telefono2='$telefono2Tercero', tercero_DiasPago='$DiaPagoTercero', tercero_Email='$emailTercero', tercero_FormaPago='$formaPagoTercero', tercero_PorcentajeRetefuente='$RetefuenteTercero', tercero_PorcentajeDescuento='$DescuentoTercero', tercero_Ubicacion='$ubicacionTercero', tercero_Tipo='$tipoTercero' WHERE tercero_Nit='$nitTercero'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OAT");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EAT");
        exit();
    }

?>