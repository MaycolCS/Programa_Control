<?php

    $Usuario = $_POST['usuario'];
    $Password = $_POST['contrasena'];

    $Nombre = "";
    $Apellido = "";
    $Documento = 0;
    $Msj = "Login";
    $CS = 0;

    include 'Funciones.php';

    $conexion = conexionBD();

    $estaDocumento = estaDocumento($Usuario);

    $sql = "";
    if ($estaDocumento == TRUE) {
        $datos = conexionBDUsuario();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($Usuario) == number_format($fila['usuario_Documento'])) {
                $Password = md5($Password, FALSE);
                if ($Password == $fila['usuario_Contrasena']) {
                    $CS = rand(1000,200000);
                    $Nombre = $fila['usuario_Nombre'];
                    $Apellido = $fila['usuario_Apellido'];
                    $Documento = $fila['usuario_Documento'];
                    $MDSafety = md5(($Documento*$CS+$CS/$CS), FALSE);
                    session_start(); 
                    $IP = session_id();
                    session_write_close();
                    $sql = "UPDATE usuario Set usuario_Sesion=TRUE, usuario_IP='$IP', usuario_MDSafety='$MDSafety' WHERE usuario_Documento='$Documento'";
                } else {
                    header("Location: Login.php? msj=EVC");
                    exit();
                }
            }
        }
        if ($Documento==0) {
            header("Location: Login.php? msj=EVD");
            exit();
        } else {
            if(mysqli_query($conexion, $sql)) {
                mysqli_close($conexion);
                header("Location: MainPage? cc=$Documento&cs=$CS&msj=$Msj");
                exit();
            }
            else {
                mysqli_close($conexion);
                header("Location: Login? msj=EC");
                exit();
            }
        }
    } else {
        header("Location: Login? msj=UNR");
        exit();
    }
?>