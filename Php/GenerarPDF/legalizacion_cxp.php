<?php

    include '../Funciones.php';
    include 'encabezadoTablas.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(15,16,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $Legalizacion = $_GET['LEG'];
    $DatosLegalizacion = datosLegalizacionCXP($Legalizacion);
    $ValorSubtotalItems = 0;
    $ValorIvaItems = 0;

    $CantidadItems = cantidadDatosLegalizacionCXP($Legalizacion);
    $celdasRelleno = 0;
    if (($CantidadItems == 1) or ($CantidadItems == 6) or ($CantidadItems == 11) or ($CantidadItems == 16)) {
        $celdasRelleno = 3;
    } elseif (($CantidadItems == 2) or ($CantidadItems == 7) or ($CantidadItems == 12) or ($CantidadItems == 17)) {
        $celdasRelleno = 2;
    } elseif (($CantidadItems == 3) or ($CantidadItems == 8) or ($CantidadItems == 13) or ($CantidadItems == 18)) {
        $celdasRelleno = 1;
    } elseif (($CantidadItems == 5) or ($CantidadItems == 10) or ($CantidadItems == 15) or ($CantidadItems == 20)) {
        $celdasRelleno = 4;
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
    </table>
    <table class="tabla_encabezado">     
        <tr>
            <td class="datos_fijos" rowspan="2">FECHA</td>
            <td class="datos_fijos">AÑO</td>
            <td class="datos_fijos">MES</td>
            <td class="datos_fijos">DÍA</td>
            <td class="datos_empresa" rowspan="2"></td>
            <td class="datos_fijos" rowspan="2">CUENTA POR PAGAR</td>
            <td class="datos_variables" rowspan="2">'.$DatosLegalizacion[0].'</td>
        </tr>
        <tr>
            <td class="datos_variables">'.$DatosLegalizacion[1].'</td>
            <td class="datos_variables">'.$DatosLegalizacion[2].'</td>
            <td class="datos_variables">'.$DatosLegalizacion[3].'</td>
        </tr>
        <tr>
            <td class="espacio" colspan="7"></td>
        </tr>
        <tr>
            <td class="datos_fijos">NIT</td>
            <td class="datos_variables" colspan="2">'.$DatosLegalizacion[4].'</td>
            <td class="datos_fijos">DV</td>
            <td class="datos_variables">'.$DatosLegalizacion[5].'</td>
            <td class="datos_fijos">COTIZACION</td>
            <td class="datos_variables">'.$DatosLegalizacion[11].'</td>
        </tr>
        <tr>
            <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
            <td class="datos_variables" colspan="4" rowspan="2">'.$DatosLegalizacion[6].'</td>
        </tr>
        <tr>
            <td class="datos_fijos" >CENTRO COSTO</td>
            <td class="datos_variables">'.$DatosLegalizacion[12].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">TELEFONO</td>
            <td class="datos_variables" colspan="4">'.$DatosLegalizacion[7].'</td>
            <td class="datos_fijos" >FACTURA COMPRA</td>
            <td class="datos_variables">'.$DatosLegalizacion[13].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">EMAIL</td>
            <td class="datos_variables" colspan="4">'.$DatosLegalizacion[8].'</td>
            <td class="datos_fijos">NIT CLIENTE</td>
            <td class="datos_variables">'.$DatosLegalizacion[14].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">CIUDAD</td>
            <td class="datos_variables" colspan="4">'.$DatosLegalizacion[9].'</td>
            <td class="datos_fijos" rowspan="2">CLIENTE</td>
            <td class="datos_variables" rowspan="2">'.$DatosLegalizacion[15].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">DIRECCIÓN</td>
            <td class="datos_variables" colspan="4">'.$DatosLegalizacion[10].'</td>
        </tr>
    </table>';

    $Datos = '
        <table class="tabla_items">
            <tr>
                <th>Item</th>
                <th>Detalle</th>
                <th>Cantidad</th>
                <th>Valor unitario</th>
                <th>Valor total</th>
                <th>Valor IVA</th>
            </tr>';
            $PosItems = 18;
            $AuxCantidadItems = 1;
            while ($AuxCantidadItems <= $CantidadItems) {
                $Datos .= '<tr>
                    <td>'.$AuxCantidadItems.'</td>
                    <td>'.$DatosLegalizacion[$PosItems+1].'</td>
                    <td>'.$DatosLegalizacion[$PosItems+2].'</td>
                    <td>$ '.number_format($DatosLegalizacion[$PosItems+3]).'</td>
                    <td>$ '.number_format($DatosLegalizacion[$PosItems+4]).'</td>
                    <td>$ '.number_format($DatosLegalizacion[$PosItems+5]).'</td>
                </tr>';
                $ValorSubtotalItems = $ValorSubtotalItems + $DatosLegalizacion[$PosItems+4];
                $ValorIvaItems = $ValorIvaItems + $DatosLegalizacion[$PosItems+5];
                $PosItems = $PosItems + 6;
                $AuxCantidadItems = $AuxCantidadItems + 1;
            }
            while ($celdasRelleno > 0) {
                $Datos .= '<tr>
                    <td></td>
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
                <td class="datos_fijos">SUBTOTAL</td>
                <td class="datos_fijos">IVA DESCONTABLE</td>
                <td class="datos_fijos">RETEFUENTE</td>
                <td class="datos_fijos">RETEIVA</td>
                <td class="datos_fijos">RETEICA</td>
                <td class="datos_fijos">TOTAL</td>
            </tr>
            <tr>
                <td class="datos_variables">$ '.number_format($ValorSubtotalItems).'</td>
                <td class="datos_variables">$ '.number_format($ValorIvaItems).'</td>';
                if ($ValorSubtotalItems > 895000) {
                    $Datos .= '<td class="datos_variables">$ '.number_format(($ValorSubtotalItems*0.025)).'</td>';
                } else {
                    $Datos .= '<td class="datos_variables">$ 0</td>';
                }
                $Datos .= '<td class="datos_variables">$ '.number_format(($ValorIvaItems*0.15)).'</td>
                <td class="datos_variables">$'.number_format((($ValorSubtotalItems*11.04)/1000)).'</td>
                <td class="datos_variables">$ '.number_format(($ValorSubtotalItems+$ValorIvaItems)).'</td>
            </tr>
            <tr>
                <td class="datos_fijos" colspan="2">ELABORADO POR:</td>
                <td class="datos_variables" colspan="4">'.datosUsuario($DatosLegalizacion[16])['usuario_Nombre']." ".datosUsuario($DatosLegalizacion[16])['usuario_Apellido'].'</td>
            </tr>
            
        </table>
    ';

    require_once __DIR__ . '../../../PDF/vendor/autoload.php';

    $css = file_get_contents('Style_PDF.css');

    $mpdf = new \Mpdf\Mpdf([
        "format" => "Letter",
        'pagenumPrefix' => 'Página ',
        'nbpgPrefix' => ' de '
    ]);

    $mpdf->SetFooter('{PAGENO}{nbpg}');

    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader($Encabezado);
    $mpdf->AddPage('L');
    $mpdf->WriteHTML($Datos, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("$Legalizacion ".$DatosLegalizacion[6].".pdf", "D");
    
?>