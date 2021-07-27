<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $Usuario= $_POST['Cedula'];
    if (estaDocumento($Usuario)) {
        header("Location: IngresarUsuario? cc=$Documento&cs=$CS&msj=EUR");
        exit();
    }
    $NombrePost= $_POST['Nombre'];
    $Nombre= strtoupper($NombrePost);
    $ApellidoPost= $_POST['Apellido'];
    $Apellido= strtoupper($ApellidoPost);
    $Celular= $_POST['Celular'];
    $Correo= $_POST['email'];
    if (estaCorreo($Correo)) {
        header("Location: IngresarUsuario? cc=$Documento&cs=$CS&msj=ECR");
        exit();
    }
    $Permiso1 = $_POST['Permiso1'];
    $Permiso2 = $_POST['Permiso2'];
    $Permiso3 = $_POST['Permiso3'];
    $Permiso4 = $_POST['Permiso4'];
    $Contraseña= rand(1000,20000);
    
    $conn = conexionBD();
    $sql = "INSERT INTO usuario 
                        (usuario_Documento, 
                        usuario_Nombre, 
                        usuario_Apellido, 
                        usuario_Celular, 
                        usuario_Correo, 
                        usuario_Permiso_1, 
                        usuario_Contrasena, 
                        usuario_Permiso_2, 
                        usuario_Permiso_3, 
                        usuario_Permiso_4) 
                        VALUES 
                        ('$Usuario', 
                        '$Nombre', 
                        '$Apellido', 
                        '$Celular', 
                        '$Correo', 
                        '$Permiso1', 
                        '$Contraseña', 
                        '$Permiso2', 
                        '$Permiso3', 
                        '$Permiso4')";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=ORU");
        exit();
    } else {
        mysqli_close($conn);
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=ERU");
        exit();
    }

?>