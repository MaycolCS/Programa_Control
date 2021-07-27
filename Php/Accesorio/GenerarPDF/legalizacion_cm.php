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
    $DatosLegalizacion = datosLegalizacionCM($Legalizacion);
    $ValorSubtotalItems = 0;
    $ValorIvaItems = 0;

    $CantidadItems = cantidadDatosLegalizacionCM($Legalizacion);
    $celdasRelleno = 0;
    if (($CantidadItems == 1) or ($CantidadItems == 7) or ($CantidadItems == 13) or ($CantidadItems == 19)) {
        $celdasRelleno = 4;
    } elseif (($CantidadItems == 2) or ($CantidadItems == 8) or ($CantidadItems == 14) or ($CantidadItems == 20)) {
        $celdasRelleno = 3;
    } elseif (($CantidadItems == 3) or ($CantidadItems == 9) or ($CantidadItems == 15)) {
        $celdasRelleno = 2;
    } elseif (($CantidadItems == 4) or ($CantidadItems == 10) or ($CantidadItems == 16)) {
        $celdasRelleno = 1;
    } elseif (($CantidadItems == 12) or ($CantidadItems == 18)) {
        $celdasRelleno = 5;
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
            <td class="datos_fijos" rowspan="2">LEGALIZACIÓN</td>
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
            <td class="datos_fijos">RAZON SOCIAL</td>
            <td class="datos_variables">'.$DatosLegalizacion[6].'</td>
        </tr>
    </table>';

    $Datos = '
        <table class="tabla_items">
            <tr>
                <th>Item</th>
                <th>Centro costo</th>
                <th>NIT</th>
                <th>Razón social</th>
                <th>Detalle</th>
                <th>Cantidad</th>
                <th>Valor unitario</th>
                <th>Valor total</th>
                <th>Valor IVA</th>
            </tr>';
            $PosItems = 9;
            $AuxCantidadItems = 1;
            while ($AuxCantidadItems <= $CantidadItems) {
                $Datos .= '<tr>
                    <td>'.$AuxCantidadItems.'</td>
                    <td>'.$DatosLegalizacion[$PosItems].'</td>
                    <td>'.$DatosLegalizacion[$PosItems+1].'</td>
                    <td>'.$DatosLegalizacion[$PosItems+2].'</td>
                    <td>'.$DatosLegalizacion[$PosItems+3].'</td>
                    <td>'.$DatosLegalizacion[$PosItems+4].'</td>
                    <td>$ '.number_format($DatosLegalizacion[$PosItems+5]).'</td>
                    <td>$ '.number_format($DatosLegalizacion[$PosItems+6]).'</td>
                    <td>$ '.number_format($DatosLegalizacion[$PosItems+7]).'</td>
                </tr>';
                $ValorSubtotalItems = $ValorSubtotalItems + $DatosLegalizacion[$PosItems+6];
                $ValorIvaItems = $ValorIvaItems + $DatosLegalizacion[$PosItems+7];
                $PosItems = $PosItems + 9;
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
                <td class="datos_variables">$ '.number_format($ValorIvaItems).'</td>
                <td class="datos_variables">$ -</td>
                <td class="datos_variables">$ -</td>
                <td class="datos_variables">$ -</td>
                <td class="datos_variables">$ '.number_format(($ValorSubtotalItems+$ValorIvaItems)).'</td>
            </tr>
            <tr>
                <td class="datos_fijos" colspan="2">ELABORADO POR:</td>
                <td class="datos_variables" colspan="4">'.datosUsuario($DatosLegalizacion[7])['usuario_Nombre']." ".datosUsuario($DatosLegalizacion[7])['usuario_Apellido'].'</td>
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