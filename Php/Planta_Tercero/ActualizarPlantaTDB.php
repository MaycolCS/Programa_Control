<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $PlantaTercero=$_GET['PTercero'];
    $contactoPlantaTerceroPost= $_POST['contactoPlantaTercero'];
    $contactoPlantaTercero= strtoupper($contactoPlantaTerceroPost);
    $direcciónPlantaTerceroPost= $_POST['direcciónPlantaTercero'];
    $direcciónPlantaTercero= strtoupper($direcciónPlantaTerceroPost);
    $DepartamentoPlantaTercero= $_POST['Departamento'];
    $ciudadPlantaTercero= $_POST['ciudadPlantaTercero'];
    $telefono1PlantaTercero= $_POST['telefono1PlantaTercero'];
    $telefono2PlantaTercero= $_POST['telefono2PlantaTercero'];
    $ubicacionPlantaTercero = $_POST['ubicacionPlantaTercero'];
    $emailPlantaTercero = $_POST['emailPlantaTercero'];
    
    $conn = conexionBD();    
    $sql = "UPDATE planta_tercero 
                    Set 
                    planta_tercero_Contacto='$contactoPlantaTercero', 
                    planta_tercero_Departamento='$DepartamentoPlantaTercero', 
                    planta_tercero_Ciudad='$ciudadPlantaTercero', 
                    planta_tercero_Direccion='$direcciónPlantaTercero', 
                    planta_tercero_Telefono1='$telefono1PlantaTercero', 
                    planta_tercero_Telefono2='$telefono2PlantaTercero',
                    planta_tercero_Ubicacion='$ubicacionPlantaTercero',
                    planta_tercero_Email='$emailPlantaTercero'   
                    WHERE planta_tercero_Id ='$PlantaTercero'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=OAPT");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=EAPT");
        exit();
    }

?>