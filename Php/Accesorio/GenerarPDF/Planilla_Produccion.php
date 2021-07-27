<?php

    include '../Funciones.php';
    include 'encabezadoTablas.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(12,16,22,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }

    $IdPlanillaProduccion = $_GET['pp'];
    $DatosPlanillaProduccion = datosPlanillaProduccion($IdPlanillaProduccion);
    $ListaMallas = obtenerDatos_PlanillaPlanta_Mallas(PlanillaProduccion_IdCotizacion($DatosPlanillaProduccion['planilla_produccion_Id']),$DatosPlanillaProduccion['planilla_produccion_Id']);
    $ListaAccesorios = obtenerDatos_PlanillaPlanta_Accesorios(PlanillaProduccion_IdCotizacion($DatosPlanillaProduccion['planilla_produccion_Id']),$DatosPlanillaProduccion['planilla_produccion_Id']);
    $ListaOtros = obtenerDatos_PlanillaPlanta_Otros(PlanillaProduccion_IdCotizacion($DatosPlanillaProduccion['planilla_produccion_Id']),$DatosPlanillaProduccion['planilla_produccion_Id']);

    $Encabezado = '<table class="tabla_encabezado">
            <tr>
                <td class="datos_empresa_imagen" rowspan="4"><img src="../../Images/cubo.png" width="50px"></td>
                <th class="datos_empresa" colspan="5">'.$nombreEmpresa.'</th>
                <td class="datos_empresa_imagen" rowspan="4"><img src="../../Images/cubo.png" width="50px"></td>
            </tr>
            <tr>
                <td class="datos_empresa" colspan="5">'.$nitEmpresa.'</td>
            </tr>
            <tr>
                <td class="datos_empresa" colspan="5">'.$ciudadEmpresa.'</td>
            </tr>
        </table>
        <table class="tabla_encabezado">
            <tr>
                <td class="datos_fijos">PLANILLA PRODUCCIÓN</td>
                <td class="datos_variables" colspan="2">'.$DatosPlanillaProduccion['planilla_produccion_Id'].'</td>
                <td class="datos_empresa"></td>
                <td class="datos_fijos" >COTIZACIÓN</td>
                <td class="datos_variables">'.$DatosPlanillaProduccion['planilla_produccion_Cotizacion'].'</td>
            </tr>
            <tr>
                <td class="datos_fijos">NIT</td>
                <td class="datos_variables">'.number_format($DatosPlanillaProduccion['planilla_produccion_NitTercero']).'</td>
                <td class="datos_fijos">DV</td>
                <td class="datos_variables">'.datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Dv'].'</td>
                <td class="datos_fijos">RAZON SOCIAL</td>
                <td class="datos_variables">'.datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_RazonSocial'].'</td>
            </tr>
            <tr>
                <td class="datos_fijos">EMAIL</td>
                <td class="datos_variables" colspan="3">'.datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Email'].'</td>
                <td class="datos_fijos">CONTACTO</td>
                <td class="datos_variables">ING. '.datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Contacto'].'</td>
            </tr>
            <tr>
                <td class="datos_fijos">TELEFONO</td>
                <td class="datos_variables" colspan="3">'.datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Telefono1'].'</td>
                <td class="datos_fijos">TELEFONO</td>
                <td class="datos_variables">'.datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
            </tr>
            <tr>
                <td class="datos_fijos">CIUDAD DE ENTREGA</td>
                <td class="datos_variables" colspan="3">'.nombreDepartamento(datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
                <td class="datos_fijos">DIRECCIÓN DE ENTREGA</td>
                <td class="datos_variables">'.datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
            </tr>
        </table>';
    $Datos = '';
    if (count($ListaMallas)>0) {
        $Datos .= '
        <table class="tabla_items">
            <tr>
                <th colspan="19">MALLAS</th>
            </tr>
            <tr>
                <th rowspan="2">ITEM</th>
                <th rowspan="2">TIPO</th>
                <th rowspan="2">HUECO</th>
                <th rowspan="2">CALIBRE</th>
                <th rowspan="2">ANCHO</th>
                <th rowspan="2">GANCHO</th>
                <th rowspan="2">TIPO GANCHO</th>
                <th rowspan="2">LARGO</th>
                <th rowspan="2">CANTIDAD</th>
                <th rowspan="2">M<sup>2</sup></th>
                <th rowspan="2">ACERO TEÓRICO</th>
                <th rowspan="2">ACERO REAL</th>
                <th rowspan="2">PESO MALLA</th>
                <th rowspan="2">CHAPA</th>
                <th colspan="3">FECHA SALIDA ACERO</th>
                <th rowspan="2">REF. PLANTA</th>
                <th rowspan="2">HORAS PROGRAMADAS</th>
            </tr>
            <tr>
                <th>DD</th>
                <th>MM</th>
                <th>AAAA</th>
            </tr>';
            for ($i = 0; $i < count($ListaMallas); $i += 10) {
                $Datos .= '<tr>
                    <td class="item_planilla">'.($i/10+1).'</td>
                    <td class="item_planilla">'.$ListaMallas[$i].'</td>
                    <td class="item_planilla">'.$ListaMallas[$i+1].'</td>
                    <td class="item_planilla">'.$ListaMallas[$i+2].'</td>
                    <td class="item_planilla">'.$ListaMallas[$i+3].'</td>
                    <td class="item_planilla">'.$ListaMallas[$i+4].'</td>';
                    if ($ListaMallas[$i+5] == "TIPO A") {
                        $Datos .= '<td class="item_planilla"><img src="../../Images/Tipos_Gancho/Gancho_A.jpg" width="60px"/></td>';
                    } elseif ($ListaMallas[$i+5] == "TIPO B") {
                        $Datos .= '<td class="item_planilla"><img src="../../Images/Tipos_Gancho/Gancho_B.jpg" width="60px"/></td>';
                    } elseif ($ListaMallas[$i+5] == "TIPO C") {
                        $Datos .= '<td class="item_planilla"><img src="../../Images/Tipos_Gancho/Gancho_C.jpg" width="60px"/></td>';
                    } elseif ($ListaMallas[$i+5] == "TIPO D") {
                        $Datos .= '<td class="item_planilla"><img src="../../Images/Tipos_Gancho/Gancho_D.jpg" width="60px"/></td>';
                    } elseif ($ListaMallas[$i+5] == "TIPO E") {
                        $Datos .= '<td class="item_planilla"><img src="../../Images/Tipos_Gancho/Gancho_E.jpg" width="60px"/></td>';
                    }
                    $Datos .= '
                    <td class="item_planilla">'.$ListaMallas[$i+6].'</td>
                    <td class="item_planilla">'.$ListaMallas[$i+8].'</td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla">'.((($ListaMallas[$i+3]+($ListaMallas[$i+4]*2))*$ListaMallas[$i+6])*$ListaMallas[$i+8]).'</td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla">'.((($ListaMallas[$i+3]+($ListaMallas[$i+4]*2))*$ListaMallas[$i+6])*$ListaMallas[$i+8]*datos_Malla($ListaMallas[$i+9])[4]).'</td>
                </tr>';
            }
        $Datos .= '</table>
        <br>';
    }

    if (count($ListaAccesorios)>0) {
        $Datos .= '
        <table class="tabla_items">
            <tr>
                <th colspan="6">ACCESORIOS</th>
            </tr>
            <tr>
                <th rowspan="2">ITEM</th>
                <th rowspan="2">DETALLE</th>
                <th rowspan="2">CANTIDAD</th>
                <th colspan="3">FECHA SALIDA</th>
            </tr>
            <tr>
                <th>DD</th>
                <th>MM</th>
                <th>AAAA</th>
            </tr>';
            for ($i = 0; $i < count($ListaAccesorios); $i += 2) {
                $Datos .= '<tr>
                    <td class="item_planilla">'.($i/2+1).'</td>
                    <td class="item_planilla">'.$ListaAccesorios[$i].'</td>
                    <td class="item_planilla">'.$ListaAccesorios[$i+1].'</td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                </tr>';
            }
        $Datos .= '</table>
            <br>';
    }

    if (count($ListaOtros)>0) {
        $Datos .= '
        <table class="tabla_items">
            <tr>
                <th colspan="6">OTROS</th>
            </tr>
            <tr>
                <th rowspan="2">ITEM</th>
                <th rowspan="2">DETALLE</th>
                <th rowspan="2">CANTIDAD</th>
                <th colspan="3">FECHA SALIDA</th>
            </tr>
            <tr>
                <th>DD</th>
                <th>MM</th>
                <th>AAAA</th>
            </tr>';
            for ($i = 0; $i < count($ListaOtros); $i += 2) {
                $Datos .= '<tr>
                    <td class="item_planilla">'.($i/2+1).'</td>
                    <td class="item_planilla">'.$ListaOtros[$i].'</td>
                    <td class="item_planilla">'.$ListaOtros[$i+1].'</td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                    <td class="item_planilla"></td>
                </tr>';
            }
        $Datos .= '</table>
        <br>';
    }

    $Datos .= '
        <table class="tabla_items">
            <tr>
                <th>OBSERVACIONES</th>
            </tr>
            <tr>
                <td class="CampoObservaciones">'.$DatosPlanillaProduccion['planilla_produccion_Observaciones'].'</td>
            </tr>
        </table>
        <br>';

    require_once __DIR__ . '../../../PDF/vendor/autoload.php';

    $css = file_get_contents('Style_PDF.css');

    $mpdf = new \Mpdf\Mpdf([
        "format" => "Letter",
        'margin_header' => 5,
        'margin_top' => 0,
        'margin_bottom' => 10,
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_header' => 5,
        'pagenumPrefix' => 'Página ',
        'nbpgPrefix' => ' de '
    ]);

    $mpdf->SetFooter('{PAGENO}{nbpg}');

    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader($Encabezado);
    $mpdf->AddPage('L');
    $mpdf->WriteHTML($Datos, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("$IdPlanillaProduccion ".datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_RazonSocial'].".pdf", "D");
    
?>