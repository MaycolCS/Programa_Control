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

    $Lista_Mallas = lista_Mallas();

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
    </table>';

    $Datos = '
        <table class="tabla_items">
            <tr>
                <th colspan="8">MALLAS</th>
            </tr>
            <tr>
                <th>TIPO</th>
                <th>HUECO</th>
                <th>CALIBRE</th>
                <th>PESO (Kg/M<sup>2</sup>)</th>
                <th>HORAS (hrs/M<sup>2</sup>)</th>
                <th>PRECIO ACTUAL</th>
                <th>PRECIO ANTERIOR</th>
                <th>USUARIO</th>
            </tr>';
            for ($i = 0; $i < count($Lista_Mallas); $i += 4) {
                $Id_Malla = $Lista_Mallas[$i];
                $Datos_Malla = datos_Malla($Id_Malla);
                $Datos .= '<tr>
                    <td>'.$Datos_Malla[0].'</td>
                    <td>'.$Datos_Malla[1].'</td>
                    <td>'.$Datos_Malla[2].'</td>
                    <td>'.$Datos_Malla[3].'</td>
                    <td>'.$Datos_Malla[4].'</td>
                    <td>$ '.number_format($Datos_Malla[5]).'</td>
                    <td>$ '.number_format($Datos_Malla[6]).'</td>
                    <td>'.datosUsuario($Datos_Malla[7])['usuario_Nombre']." ".datosUsuario($Datos_Malla[7])['usuario_Apellido'].'</td>
                </tr>';
            }
        $Datos .= '</table>';

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
    $mpdf->Output("Listado_Mallas.pdf", "D");
    
?>