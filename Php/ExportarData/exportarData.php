<?php
    
    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
    }

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $cantData = 0;
    $cotizacion = 0;
    $planillaProduccion = 0;
    $remision = 0;
    $facturaVenta = 0;
    $legalizacionCM = 0;
    $legalizacionCXP = 0;
    $terceros = 0;
    $plantasterceros = 0;

    if (isset($_GET['COT'])){
        $cotizacion = $_GET['COT'];
    }
    if (isset($_GET['PP'])){
        $planillaProduccion = $_GET['PP'];
    }
    if (isset($_GET['REM'])){
        $remision = $_GET['REM'];
    }
    if (isset($_GET['FV'])){
        $facturaVenta = $_GET['FV'];
    }
    if (isset($_GET['LEGCM'])){
        $legalizacionCM = $_GET['LEGCM'];
    }
    if (isset($_GET['LEGCXP'])){
        $legalizacionCXP = $_GET['LEGCXP'];
    }
    if (isset($_GET['TER'])){
        $terceros = $_GET['TER'];
    }
    if (isset($_GET['PLTER'])){
        $plantasterceros = $_GET['PLTER'];
    }

    if (isset($_POST['data'])) {
        if ($_POST['data'] == "COT"){
            $cotizacion = 1;
            $cantData = 1;
        } else if ($_POST['data'] == "PP"){
            $planillaProduccion = 1;
            $cantData = 1;
        } else if ($_POST['data'] == "REM"){
            $remision = 1;
            $cantData = 1;
        } else if ($_POST['data'] == "FV"){
            $facturaVenta = 1;
            $cantData = 1;
        } else if ($_POST['data'] == "LEGCM"){
            $legalizacionCM = 1;
            $cantData = 1;
        } else if ($_POST['data'] == "LEGCXP"){
            $legalizacionCXP = 1;
            $cantData = 1;
        } else if ($_POST['data'] == "TER"){
            $terceros = 1;
            $cantData = 1;
        }  else if ($_POST['data'] == "PLTER"){
            $plantasterceros = 1;
            $cantData = 1;
        }
    }

    
?>

<!DOCTYPE html PUBLIC>

<html>

    <head>
        <?php
            include '../Static/Head.html';
        ?>
    </head>

    <body>

        <?php
            include '../Static/Header.php';
        ?>

        <section>
            <img class="img_logo_section" src="../../Images/logo.png">
            <p class="txt_Normal">Usuario: <?php echo $datosUsuario['usuario_Nombre'];?> <?php echo $datosUsuario['usuario_Apellido'];?></p>
            <div class="div_Style"></div>

            <form class="form_Style" method="post" action="exportarData.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&COT=<?php echo $cotizacion; ?>&PP=<?php echo $planillaProduccion; ?>&REM=<?php echo $remision; ?>&FV=<?php echo $facturaVenta; ?>&TER=<?php echo $terceros; ?>&PLTER=<?php echo $plantasterceros; ?>&LEGCM=<?php echo $legalizacionCM; ?>&LEGCXP=<?php echo $legalizacionCXP; ?>">
                <p class="txt_Titulo">Exportar DATA</p>
                <div>
                    <label>Data:</label>
                    <select name="data" id="data" required>
                        <option></option>
                        <option value="COT">COTIZACIÓN</option>
                        <option value="PP">PLANILLA PRODUCCIÓN</option>
                        <option value="REM">REMISIÓN</option>
                        <option value="FV">FACTURA VENTA</option>
                        <option value="LEGCM">LEGALIZACIONES CM</option>
                        <option value="LEGCXP">LEGALIZACIONES CXP</option>
                        <option value="TER">TERCEROS</option>
                        <option value="PLTER">PLANTAS TERCEROS</option>
                    </select>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Añadir</button>
                </div>
            </form>

            <?php
            if ($cantData==1) {?>
                <div id="tabla_vistaEscritorio">
                    <div class="div_Style">
                        <table class="tabla_items">
                            <p class="txt_Titulo">Bases de datos añadidas</p>
                            <tr>
                                <th>Tipo DATA</th>
                            </tr>
                            <tr>
                                <?php
                                if ($cotizacion == 1) { ?>
                                    <td>DATA_Cotización</td>
                                <?php
                                }?>
                            </tr>
                            <tr>
                                <?php
                                if ($planillaProduccion == 1) { ?>
                                    <td>DATA_PlanillaProduccion</td>
                                <?php
                                }?>
                            </tr>
                            <tr>
                                <?php
                                if ($remision == 1) { ?>
                                    <td>DATA_Remisión</td>
                                <?php
                                }?>
                            </tr>
                            <tr>
                                <?php
                                if ($facturaVenta == 1) { ?>
                                    <td>DATA_FacturaVenta</td>
                                <?php
                                }?>
                            </tr>
                            <tr>
                                <?php
                                if ($legalizacionCM == 1) { ?>
                                    <td>DATA_LEG_CM</td>
                                <?php
                                }?>
                            </tr>
                            <tr>
                                <?php
                                if ($legalizacionCXP == 1) { ?>
                                    <td>DATA_LEG_CXP</td>
                                <?php
                                }?>
                            </tr>
                            <tr>
                                <?php
                                if ($terceros == 1) { ?>
                                    <td>DATA_Terceros</td>
                                <?php
                                }?>
                            </tr>
                            <tr>
                                <?php
                                if ($plantasterceros == 1) { ?>
                                    <td>DATA_PlantasTerceros</td>
                                <?php
                                }?>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="lista_WR">
                    <div class="div_Style"></div>
                    <p class="txt_Titulo">Bases de datos añadidas</p>
                    <ul>
                        <?php
                        if ($cotizacion == 1) { ?>
                            <li>DATA_Cotización</li>
                        <?php
                        }
                        if ($planillaProduccion == 1) { ?>
                            <li>DATA_PlanillaProduccion</li>
                        <?php
                        }
                        if ($remision == 1) { ?>
                            <li>DATA_Remisión</li>
                        <?php
                        }
                        if ($facturaVenta == 1) { ?>
                            <li>DATA_FacturaVenta</li>
                        <?php
                        }
                        if ($legalizacionCM == 1) { ?>
                            <li>DATA_LEG_CM</li>
                        <?php
                        }
                        if ($legalizacionCXP == 1) { ?>
                            <li>DATA_LEG_CXP</li>
                        <?php
                        }
                        if ($terceros == 1) { ?>
                            <li>DATA_Terceros</li>
                        <?php
                        }
                        if ($facturaVenta == 1) { ?>
                            <li>DATA_PlantasTerceros</li>
                        <?php
                        }?>
                    </ul>
                </div>

                <form name="form" class="form_Style" method="post" action="exportarDataDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&COT=<?php echo $cotizacion; ?>&PP=<?php echo $planillaProduccion; ?>&REM=<?php echo $remision; ?>&FV=<?php echo $facturaVenta; ?>&TER=<?php echo $terceros; ?>&PLTER=<?php echo $plantasterceros; ?>&LEGCM=<?php echo $legalizacionCM; ?>&LEGCXP=<?php echo $legalizacionCXP; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
                    <div>
                        <button type=button onclick="pregunta()" value="Enviar">Exportar</button>
                    </div>
                </form>
            <?php
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>