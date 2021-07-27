<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(13,16,23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $nitTercero= $_POST['nitTercero'];
    $contactoTerceroPost= $_POST['contactoPlantaTercero'];
    $contactoTercero= "ING. ".strtoupper($contactoTerceroPost);
    $direcciónTerceroPost= $_POST['direcciónPlantaTercero'];
    $direcciónTercero= strtoupper($direcciónTerceroPost);
    $DepartamentoTercero= $_POST['Departamento'];
    $ciudadTercero= $_POST['ciudadPlantaTercero'];
    $telefono1Tercero= $_POST['telefono1PlantaTercero'];
    $telefono2Tercero= $_POST['telefono2PlantaTercero'];
    $ubicacionPlantaTercero = $_POST['ubicacionPlantaTercero'];
    $emailPlantaTercero = $_POST['emailPlantaTercero'];
    
    if (estaPlantaTercero($nitTercero,$contactoTercero,$DepartamentoTercero,$ciudadTercero,$direcciónTercero)) {
        header("Location: IngresarPlantaT.php? cc=$Documento&cs=$CS&msj=ERPT");
        exit();
    }

    $conn = conexionBD();
    $sql = "INSERT INTO planta_tercero 
                        (planta_tercero_NitTercero,
                        planta_tercero_Contacto,
                        planta_tercero_Departamento,
                        planta_tercero_Ciudad,
                        planta_tercero_Direccion,
                        planta_tercero_Telefono1,
                        planta_tercero_Telefono2,
                        planta_tercero_Ubicacion,
                        planta_tercero_Email) 
                        VALUES 
                        ('$nitTercero',
                        '$contactoTercero',
                        '$DepartamentoTercero',
                        '$ciudadTercero',
                        '$direcciónTercero',
                        '$telefono1Tercero',
                        '$telefono2Tercero',
                        '$ubicacionPlantaTercero',
                        '$emailPlantaTercero')";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=ORPT");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=ERPT");
        exit();
    }

?>