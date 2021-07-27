<?php

    $Documento=$_GET['cc'];

    include 'Funciones.php';

    $conn = conexionBD();
    $sql = "DELETE FROM cotizacion_itemsprovisional WHERE cotizacion_itemsProvisional_Usuario='$Documento'";
    if (mysqli_query($conn, $sql)) {
        $sql = "DELETE FROM facturaventa_provisional WHERE facturaventa_Provisional_Usuario='$Documento'";
        if (mysqli_query($conn, $sql)) {
            $sql = "DELETE FROM legalizacion_cm_itemsprovisional WHERE legalizacion_itemsprovisional_Usuario='$Documento'";
            if (mysqli_query($conn, $sql)) {
                $sql = "DELETE FROM legalizacion_cxp_itemsprovisional WHERE legalizacion_itemsprovisional_Usuario='$Documento'";
                if (mysqli_query($conn, $sql)) {
                    $sql = "UPDATE usuario Set usuario_Sesion=FALSE, usuario_IP=NULL, usuario_MDSafety=NULL WHERE usuario_Documento='$Documento'";
                    if (mysqli_query($conn, $sql)) {
			session_write_close();
                        mysqli_close($conn);
                        header("Location: Login? msj=SC");
                        exit();
                    } else {
                        mysqli_close($conn);
                        header("Location: MainPage.php? cc=$Documento&msj=ECS");
                        exit();
                    }
                } else {
                    mysqli_close($conn);
                    header("Location: MainPage.php? cc=$Documento&msj=ECS");
                    exit();
                }
            } else {
                mysqli_close($conn);
                header("Location: MainPage.php? cc=$Documento&msj=ECS");
                exit();
            }
        } else {
            mysqli_close($conn);
            header("Location: MainPage.php? cc=$Documento&msj=ECS");
            exit();
        }
    } else {
        mysqli_close($conn);
        header("Location: MainPage.php? cc=$Documento&msj=ECS");
        exit();
    }

?>