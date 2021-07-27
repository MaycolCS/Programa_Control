<?php

    include '../Funciones.php';
    include 'encabezadoTablas.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(11,21,16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $IdCotizacion = $_GET['cot'];
    $DatosCotizacion = datosCotizacion($IdCotizacion);
    $Datos_ItemsCotizacion = itemsCotizacion($IdCotizacion);

    $contItems = (count($Datos_ItemsCotizacion)/4);

    $celdasRelleno = 0;
    if ($contItems == 1) {
        $celdasRelleno = 4;
    } elseif ($contItems == 2) {
        $celdasRelleno = 3;
    } elseif ($contItems == 3) {
        $celdasRelleno = 2;
    } elseif ($contItems == 4) {
        $celdasRelleno = 1;
    } elseif ($contItems == 6) {
        $celdasRelleno = 6;
    } elseif ($contItems == 7) {
        $celdasRelleno = 5;
    } elseif ($contItems == 8) {
        $celdasRelleno = 4;
    } elseif ($contItems == 9) {
        $celdasRelleno = 3;
    } elseif ($contItems == 10) {
        $celdasRelleno = 2;
    } elseif ($contItems == 11) {
        $celdasRelleno = 1;
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
            <td class="datos_empresa" colspan="5">'.datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Correo'].'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$direccionEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">TEL: '.datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Celular'].'</td>
        </tr>
    </table>
    <table class="tabla_encabezado">
        <tr>
            <td class="datos_fijos" rowspan="2">FECHA</td>
            <td class="datos_fijos">AÑO</td>
            <td class="datos_fijos">MES</td>
            <td class="datos_fijos">DÍA</td>
            <td class="datos_empresa" rowspan="2"></td>
            <td class="datos_fijos" rowspan="2">COTIZACIÓN</td>
            <td class="datos_variables" rowspan="2">'.$DatosCotizacion['cotizacion_Id'].'</td>
        </tr>
        <tr>
            <td class="datos_variables">'.$DatosCotizacion['cotizacion_Año'].'</td>
            <td class="datos_variables">'.$DatosCotizacion['cotizacion_Mes'].'</td>
            <td class="datos_variables">'.$DatosCotizacion['cotizacion_Dia'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">NIT</td>
            <td class="datos_variables" colspan="2">'.number_format($DatosCotizacion['cotizacion_NitTercero']).'</td>
            <td class="datos_fijos">DV</td>
            <td class="datos_variables">'.datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Dv'].'</td>
            <td class="datos_fijos">VALIDEZ OFERTA</td>
            <td class="datos_variables">'.date("Y-m-d",strtotime(date($DatosCotizacion['cotizacion_Fecha'])."+ 15 days")).'</td>
        </tr>
        <tr>
            <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
            <td class="datos_variables" rowspan="2" colspan="4">'.datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_RazonSocial'].'</td>

            <td class="datos_fijos">CONTACTO</td>
            <td class="datos_variables">ING. '.datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Contacto'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">TELEFONO</td>
            <td class="datos_variables">'.datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Telefono1'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">TELEFONO</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Telefono1'].'</td>

            <td class="datos_fijos">FORMA DE PAGO</td>
            <td class="datos_variables">'.nombre_FormaPago(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_FormaPago']).'</td>
        </tr>
        <tr>
            <td class="datos_fijos">EMAIL</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Email'].'</td>
            <td class="datos_fijos">TIEMPO DE ENTREGA</td>
            <td class="datos_variables">'.$DatosCotizacion['cotizacion_TiempoEntrega'].' DÍAS HABILES DESPÚES DE O.C.</td>
        </tr>
        <tr>
            <td class="datos_fijos">CIUDAD</td>
            <td class="datos_variables" colspan="4">'.nombreDepartamento(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Ciudad']).'</td>
            <td class="datos_fijos">CIUDAD DE ENTREGA</td>
            <td class="datos_variables">'.nombreDepartamento(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Ciudad']).'</td>
        </tr>
        <tr>
            <td class="datos_fijos">DIRECCIÓN</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Direccion'].'</td>
            <td class="datos_fijos">DIRECCIÓN DE ENTREGA</td>
            <td class="datos_variables">'.datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Direccion'].'</td>
        </tr>
    </table>';

    $Datos = '
        <table class="tabla_items">
            <tr>
                <th>Item</th>
                <th>Detalle</th>
                <th>Cantidad</th>
                <th>Precio unidad</th>
                <th>Precio total</th>
            </tr>';
            for ($i = 0; $i < count($Datos_ItemsCotizacion); $i += 4) {
                $Datos .= '<tr>
                    <td>'.($i/4+1).'</td>
                    <td>'.$Datos_ItemsCotizacion[$i].'</td>
                    <td>'.$Datos_ItemsCotizacion[$i+1].'</td>
                    <td>$ '.number_format($Datos_ItemsCotizacion[$i+2]).'</td>
                    <td>$ '.number_format($Datos_ItemsCotizacion[$i+3]).'</td>
                </tr>';
            }
            while ($celdasRelleno > 0) {
                $Datos .= '<tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>';
                $celdasRelleno = $celdasRelleno-1;
            }
        $Datos .= '</table>

        <table class="tabla_footer">
            <tr>
                <td class="datos_variables" colspan="2" rowspan="4"><img src="../../Images/sello.png" width="150px"></td>
                <td class="datos_fijos" colspan="4">OBSERVACIONES</td>
                <td class="datos_fijos" colspan="2">SUBTOTAL</td>
                <td class="datos_variables">$'.number_format($DatosCotizacion['cotizacion_Subtotal']).'</td>
            </tr>
            <tr>
                <td class="datos_variables" colspan="4" rowspan="4">
                El valor total debe ser consignado en la cuenta de ahorros del banco caja social No 24 098 446 818. 
                '.$DatosCotizacion['cotizacion_Observaciones'].'
                </td>
                <td class="datos_fijos">DCTO</td>
                <td class="datos_fijos">'.number_format(round($DatosCotizacion['cotizacion_PorcentajeDescuento'])).'%</td>
                <td class="datos_variables">$'.number_format(round($DatosCotizacion['cotizacion_ValorDescuento'])).'</td>
            </tr>
            <tr>
                <td class="datos_fijos" colspan="2">IVA 19%</td>
                <td class="datos_variables">$'.number_format(round($DatosCotizacion['cotizacion_ValorIVA'])).'</td>
            </tr>
            <tr>
                <td class="datos_fijos" rowspan="2" colspan="2">TOTAL A PAGAR</td>
                <td class="datos_variables" rowspan="2">$'.number_format(round($DatosCotizacion['cotizacion_ValorTotal'])).'</td>
            </tr>
            <tr>
                <td class="datos_variables" colspan="2" rowspan="2">ING. '.datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Apellido'].'</td>
            </tr>
            <tr>
                <td class="datos_fijos" colspan="7">VALOR EN LETRAS</td>
            </tr>
            <tr>
                <td class="datos_variables" colspan="2">TEL: '.datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Celular'].'</td>
                <td class="datos_variables" colspan="7">'.convertirNumeroLetra(round($DatosCotizacion['cotizacion_ValorTotal'])).' PESOS M/CTE.</td>
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
    $mpdf->Output("$IdCotizacion ".datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_RazonSocial'].".pdf", "D");
    
?>