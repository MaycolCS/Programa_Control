<?php

    include '../Funciones.php';
    include 'encabezadoTablas.php';

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

    $IdRemision = $_GET['REM'];
    $DatosRemision = DatosRemision($IdRemision);
    $DatosRemision_Items = itemsRemision($IdRemision);
    $contItems = (count($DatosRemision_Items)/4);

    $celdasRelleno = 0;
    if ($contItems == 1) {
        $celdasRelleno = 5;
    } elseif ($contItems == 2) {
        $celdasRelleno = 4;
    } elseif ($contItems == 3) {
        $celdasRelleno = 3;
    } elseif ($contItems == 4) {
        $celdasRelleno = 2;
    } elseif ($contItems == 5) {
        $celdasRelleno = 1;
    } elseif ($contItems == 7) {
        $celdasRelleno = 8;
    } elseif ($contItems == 8) {
        $celdasRelleno = 7;
    } elseif ($contItems == 9) {
        $celdasRelleno = 6;
    } elseif ($contItems == 10) {
        $celdasRelleno = 5;
    } elseif ($contItems == 11) {
        $celdasRelleno = 4;
    } elseif ($contItems == 12) {
        $celdasRelleno = 3;
    }

    $Encabezado = '<table class="tabla_encabezado">
        <tr>
            <td class="datos_empresa_imagen" rowspan="5"><img src="../../Images/cubo.png" width="50px"></td>
            <th class="datos_empresa" colspan="5">'.$nombreEmpresa.'</th>
            <td class="datos_empresa_imagen" rowspan="5"><img src="../../Images/cubo.png" width="50px"></td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$nitEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$emailEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$direccionEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$telefonoEmpresa.'</td>
        </tr>
    </table>
    <table class="tabla_encabezado">
        <tr>
            <td class="datos_fijos" rowspan="2">FECHA</td>
            <td class="datos_fijos">AÑO</td>
            <td class="datos_fijos">MES</td>
            <td class="datos_fijos">DÍA</td>
            <td class="datos_empresa" rowspan="2"></td>
            <td class="datos_fijos" rowspan="2">REMISIÓN</td>
            <td class="datos_variables" rowspan="2">'.$DatosRemision['remision_Id'].'</td>
        </tr>
        <tr>
            <td class="datos_variables">'.$DatosRemision['remision_Año'].'</td>
            <td class="datos_variables">'.$DatosRemision['remision_Mes'].'</td>
            <td class="datos_variables">'.$DatosRemision['remision_Dia'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">NIT</td>
            <td class="datos_variables" colspan="2">'.number_format($DatosRemision['remision_NitTercero']).'</td>
            <td class="datos_fijos">DV</td>
            <td class="datos_variables">'.datosTercero($DatosRemision['remision_NitTercero'])['tercero_Dv'].'</td>
            <td class="datos_fijos">PLANILLA PRODUCCIÓN</td>
            <td class="datos_variables">'.$DatosRemision['remision_PlanillaProduccion'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
            <td class="datos_variables" rowspan="2" colspan="4">'.datosTercero($DatosRemision['remision_NitTercero'])['tercero_RazonSocial'].'</td>
            <td class="datos_fijos">COTIZACIÓN</td>
            <td class="datos_variables">'.PlanillaProduccion_IdCotizacion($DatosRemision['remision_PlanillaProduccion']).'</td>
        </tr>
        <tr>
            <td class="datos_fijos">CONTACTO</td>
            <td class="datos_variables">ING. '.datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Contacto'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">TELEFONO</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosRemision['remision_NitTercero'])['tercero_Telefono1'].'</td>
            <td class="datos_fijos">TELEFONO</td>
            <td class="datos_variables">'.datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">EMAIL</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosRemision['remision_NitTercero'])['tercero_Email'].'</td>
            <td class="datos_fijos">ORDEN DE COMPRA</td>
            <td class="datos_variables">'.$DatosRemision['remision_OrdenCompra'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">CIUDAD</td>
            <td class="datos_variables" colspan="4">'.nombreDepartamento(datosTercero($DatosRemision['remision_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosRemision['remision_NitTercero'])['tercero_Ciudad']).'</td>
            <td class="datos_fijos">CIUDAD DE ENTREGA</td>
            <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
        </tr>
        <tr>
            <td class="datos_fijos">DIRECCIÓN</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosRemision['remision_NitTercero'])['tercero_Direccion'].'</td>
            <td class="datos_fijos">DIRECCIÓN DE ENTREGA</td>
            <td class="datos_variables">'.datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
        </tr>
    </table>';

    $Datos = '
        <table class="tabla_items">
            <tr>
                <th>Item</th>
                <th>Detalle</th>
                <th>Cantidad</th>
            </tr>';
            for ($i = 0; $i < count($DatosRemision_Items); $i += 4) {
                $Datos .= '<tr>
                    <td>'.($i/4+1).'</td>
                    <td>'.$DatosRemision_Items[$i].'</td>
                    <td>'.$DatosRemision_Items[$i+1].'</td>
                </tr>';
            }
            while ($celdasRelleno > 0) {
                $Datos .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
                $celdasRelleno = $celdasRelleno-1;
            }
        $Datos .= '</table>

        <table class="tabla_footer">
            <tr>
                <td class="datos_variables" rowspan="2"><img src="../../Images/sello.png" width="120px"></td>
                <td class="datos_fijos" colspan="2">OBSERVACIONES</td>
            </tr>
            
            <tr>
                <td class="datos_variables" colspan="2" rowspan="3">'.$DatosRemision['remision_Observaciones'].'</td>
            </tr>
            <tr>
                <td class="datos_variables">ING. '.datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Apellido'].'</td> 
            </tr>
            <tr>
                <td class="datos_variables">TEL: '.datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Celular'].'</td>
            </tr>
            
        </table>
    ';

    require_once __DIR__ . '../../../PDF/vendor/autoload.php';

    $css = file_get_contents('Style_PDF.css');

    $mpdf = new \Mpdf\Mpdf([
        "format" => "Letter",
        'margin_left' => 10,
        'margin_right' => 10,
        'pagenumPrefix' => 'Página ',
        'nbpgPrefix' => ' de '
    ]);

    $mpdf->SetFooter('{PAGENO}{nbpg}');

    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader($Encabezado);
    $mpdf->AddPage('P');
    $mpdf->WriteHTML($Datos, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("$IdRemision ".datosTercero($DatosRemision['remision_NitTercero'])['tercero_RazonSocial'].".pdf", "D");
    
?>