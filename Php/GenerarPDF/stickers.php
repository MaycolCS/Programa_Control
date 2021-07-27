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
    $Remision_Id = $_GET['Remision'];
    $Datos_Remision = DatosRemision($Remision_Id);
    $Datos_Remision_items = itemsRemision($Remision_Id);

    $Remision_Detalle_Item1 = null;
    $Remision_Cantidad_Item1 = null;

    $Remision_Detalle_Item2 = null;
    $Remision_Cantidad_Item2 = null;

    $Remision_Detalle_Item3 = null;
    $Remision_Cantidad_Item3 = null;

    $Remision_Detalle_Item4 = null;
    $Remision_Cantidad_Item4 = null;

    $Remision_Detalle_Item5 = null;
    $Remision_Cantidad_Item5 = null;

    $Remision_Detalle_Item6 = null;
    $Remision_Cantidad_Item6 = null;

    $Remision_Detalle_Item7 = null;
    $Remision_Cantidad_Item7 = null;

    $Remision_Detalle_Item8 = null;
    $Remision_Cantidad_Item8 = null;

    $Remision_Detalle_Item9 = null;
    $Remision_Cantidad_Item9 = null;

    $Remision_Detalle_Item10 = null;
    $Remision_Cantidad_Item10 = null;

    $Remision_Detalle_Item11 = null;
    $Remision_Cantidad_Item11 = null;

    $Remision_Detalle_Item12 = null;
    $Remision_Cantidad_Item12 = null;

    $validacion = FALSE;

    for ($i = 0; $i < count($Datos_Remision_items); $i += 4) {
        if (isset($_POST['cantidad1']) and $_POST['cantidad1'] != "" and $_POST['item1']==1 and $i == 0) {
            $Remision_Detalle_Item1 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item1 = $_POST['cantidad1'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad2']) and $_POST['cantidad2'] != "" and $_POST['item2']==2 and $i == 4) {
            $Remision_Detalle_Item2 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item2 = $_POST['cantidad2'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad3']) and $_POST['cantidad3'] != "" and $_POST['item3']==3 and $i == 8) {
            $Remision_Detalle_Item3 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item3 = $_POST['cantidad3'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad4']) and $_POST['cantidad4'] != "" and $_POST['item4']==4 and $i == 12) {
            $Remision_Detalle_Item4 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item4 = $_POST['cantidad4'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad5']) and $_POST['cantidad5'] != "" and $_POST['item5']==5 and $i == 16) {
            $Remision_Detalle_Item5 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item5 = $_POST['cantidad5'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad6']) and $_POST['cantidad6'] != "" and $_POST['item6']==6 and $i == 20) {
            $Remision_Detalle_Item6 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item6 = $_POST['cantidad6'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad7']) and $_POST['cantidad7'] != "" and $_POST['item7']==7 and $i == 24) {
            $Remision_Detalle_Item7 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item7 = $_POST['cantidad7'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad8']) and $_POST['cantidad8'] != "" and $_POST['item8']==8 and $i == 28) {
            $Remision_Detalle_Item8 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item8 = $_POST['cantidad8'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad9']) and $_POST['cantidad9'] != "" and $_POST['item9']==9 and $i == 32) {
            $Remision_Detalle_Item9 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item9 = $_POST['cantidad9'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad10']) and $_POST['cantidad10'] != "" and $_POST['item10']==10 and $i == 36) {
            $Remision_Detalle_Item10 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item10 = $_POST['cantidad10'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad11']) and $_POST['cantidad11'] != "" and $_POST['item11']==11 and $i == 40) {
            $Remision_Detalle_Item11 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item11 = $_POST['cantidad11'];
            $validacion = TRUE;
        }
        if (isset($_POST['cantidad12']) and $_POST['cantidad12'] != "" and $_POST['item12']==12 and $i == 44) {
            $Remision_Detalle_Item12 = $Datos_Remision_items[$i];
            $Remision_Cantidad_Item12 = $_POST['cantidad12'];
            $validacion = TRUE;
        }
    }

    if ($validacion == FALSE) {
        header("Location: ../Remision/stickers? cc=$Documento&cs=$CS&Remision=$Remision_Id&msj=ESIS");
        exit();
    }

    $Datos = '';
    if ($Remision_Cantidad_Item1 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item1; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables_detalle" colspan="6">'.$Remision_Detalle_Item1.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item2 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item2; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item2.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item3 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item3; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item3.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item4 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item4; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item4.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item5 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item5; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item5.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item6 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item6; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item6.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item7 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item7; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item7.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item8 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item8; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item8.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item9 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item9; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item9.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item10 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item10; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item10.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item11 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item11; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item11.'</td>
                </tr>
            </table>';
        }
    }

    if ($Remision_Cantidad_Item12 != NULL) {
        for ($i = 0; $i < $Remision_Cantidad_Item12; $i++) {
            $Datos .= '
            <table class="tabla_items_stickers">
                <tr>
                    <td class="datos_variables" rowspan="3"><img src="../../Images/logo.png" height="2cm"></td>
                    <td class="datos_fijos">NIT</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_NitTercero'].'</td>
                    <td class="datos_fijos" >DPTO. / CDAD</td>
                    <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                    <td class="datos_fijos" >DIRECCIÓN</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
                </tr>
                <tr>
                    <td class="datos_fijos">RAZÓN SOCIAL</td>
                    <td class="datos_variables">'.datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
                    <td class="datos_fijos" >O. COMPRA</td>
                    <td class="datos_variables">'.$Datos_Remision['remision_OrdenCompra'].'</td>
                    <td class="datos_fijos" >TELEFONO</td>
                    <td class="datos_variables">'.datosPlantaTercero($Datos_Remision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
                </tr>
                <tr>
                    <td class="datos_variables" colspan="6">'.$Remision_Detalle_Item12.'</td>
                </tr>
            </table>';
        }
    }


    require_once __DIR__ . '../../../PDF/vendor/autoload.php';

    $css = file_get_contents('Style_PDF.css');

    $mpdf = new \Mpdf\Mpdf([
        "format" => "Letter",
        'margin_top' => 0,
        'margin_bottom' => 0,
        'margin_left' => 0,
        'margin_right' => 0,
    ]);

    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->AddPage('L');
    $mpdf->WriteHTML($Datos, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("$Remision_Id ".datosTercero($Datos_Remision['remision_NitTercero'])['tercero_RazonSocial']." STICKERS.pdf", "D");

?>