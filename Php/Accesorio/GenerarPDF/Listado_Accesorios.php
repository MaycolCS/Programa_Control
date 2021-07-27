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

    $Lista_Accesorios = lista_accesorios();

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
                <th colspan="3">ACCESORIOS</th>
            </tr>
            <tr>
                <th>DETALLE</th>
                <th>PRECIO</th>
                <th>USUARIO</th>
            </tr>';
            for ($i = 0; $i < count($Lista_Accesorios); $i += 2) {
                $Id_Accesorio = $Lista_Accesorios[$i];
                $Datos_Accesorio = datos_accesorio($Id_Accesorio);
                $Datos .= '<tr>
                    <td>'.$Datos_Accesorio[0].'</td>
                    <td>$ '.number_format($Datos_Accesorio[1]).'</td>
                    <td>'.datosUsuario($Datos_Accesorio[2])['usuario_Nombre']." ".datosUsuario($Datos_Accesorio[2])['usuario_Apellido'].'</td>
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
    $mpdf->AddPage('P');
    $mpdf->WriteHTML($Datos, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("Listado_Accesorios.pdf", "D");
    
?>