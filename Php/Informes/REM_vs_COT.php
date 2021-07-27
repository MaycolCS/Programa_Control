<?php
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
    }

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

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    $Terceros = listaTerceros();
    $Tercero = 0;
    if (isset($_POST['Tercero'])) {
        $Tercero = $_POST['Tercero'];
        $ListadoRemisiones = listaRemisionesHistoricoCliente($Tercero);
        $ValorTotalRemisiones = valorTotalRemisionesHistoricoCliente($Tercero);
        $ListadoCotizaciones = listaCotizacionesHistoricoCliente($Tercero);
        $ValorTotalCotizaciones = valorTotalCotizacionesHistoricoCliente($Tercero);
        if ($ValorTotalCotizaciones == 0 and $ValorTotalRemisiones == 0) {
            header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ECREMCOT&#moduloInformes");
            exit();
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
                
            <?php
            if ($Tercero==0) {?>
                <form class="form_Style" method="post" action="REM_vs_COT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">REM vs COT</p>
                    <div>
                        <label>Tercero:</label>
                        <input list="listaTerceros" name="Tercero" id="Tercero" autocomplete="off" required/>
                        <datalist id="listaTerceros">
                            <?php
                            for ($i = 0; $i < count($Terceros); $i += 2) {?>
                                <option value="<?php echo $Terceros[$i] ;?>"><?php echo $Terceros[$i+1] ;?></option>
                            <?php
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="Boton_Style">
                        <button type="submit">Consultar</button>
                    </div>
                </form>
            <?php
            } else {?>
                <p class="txt_Titulo">REM vs COT</p>
                <div>
                    <p class="txt_Normal">Cliente: <?php echo nombreTercero($Tercero);?></p>
                    <p class="txt_Normal">NIT/CC: <?php echo $Tercero;?></p>
                </div>
                <div id="tabla_vistaEscritorio">
                    <article class="article_50">
                        <?php
                        if ($ValorTotalCotizaciones == 0) {?>
                            <p class="txt_Normal">Sin datos</p>
                        <?php
                        }?>
                        <p class="txt_Normal">Total Cotizaciones: $ <?php echo number_format($ValorTotalCotizaciones);?></p>
                        <p class="txt_Normal">Cantidad cotizaciones: <?php echo number_format(count($ListadoCotizaciones)/3);?></p>
                        <table class="tabla_encabezado">
                            <tr>
                                <td class="datos_fijos">Fecha</td>
                                <td class="datos_fijos">COT</td>
                                <td class="datos_fijos">Valor</td>
                            </tr>
                            <?php
                            for ($i = 0; $i < count($ListadoCotizaciones); $i += 3) {?>
                                <tr>
                                    <td class="datos_variables"><?php echo $ListadoCotizaciones[$i];?></td>
                                    <td class="datos_variables"><?php echo $ListadoCotizaciones[$i+1];?></td>
                                    <td class="datos_variables">$ <?php echo number_format($ListadoCotizaciones[$i+2]);?></td>
                                </tr>
                            <?php
                            }?>
                        </table>
                    </article>
                    <article class="article_50">
                        <?php
                        if ($ValorTotalRemisiones == 0) {?>
                            <p class="txt_Normal">Sin datos</p>
                        <?php
                        }?>
                        <p class="txt_Normal">Total remisiones: $ <?php echo number_format($ValorTotalRemisiones);?></p>
                        <p class="txt_Normal">Cantidad remisiones: <?php echo number_format(count($ListadoRemisiones)/4);?></p>
                        <table class="tabla_encabezado">
                            <tr>
                                <td class="datos_fijos">Fecha</td>
                                <td class="datos_fijos">REM</td>
                                <td class="datos_fijos">Valor</td>
                            </tr>
                            <?php
                            for ($i = 0; $i < count($ListadoRemisiones); $i += 4) {?>
                                <tr>
                                    <td rowspan="2" class="datos_variables"><?php echo $ListadoRemisiones[$i];?></td>
                                    <td class="datos_variables"><b><?php echo $ListadoRemisiones[$i+1];?></b></td>
                                    <td rowspan="2" class="datos_variables">$ <?php echo number_format($ListadoRemisiones[$i+3]);?></td>
                                </tr>
                                <tr>
                                    <td class="datos_variables"><?php echo datosPlanillaProduccion($ListadoRemisiones[$i+2])['planilla_produccion_Cotizacion'];?></td>
                                </tr>
                            <?php
                            }?>
                        </table>
                    </article>
                </div>
                <div id="lista_WR">
                    <div class="div_Style"></div>
                    <?php
                    if ($ValorTotalCotizaciones == 0) {?>
                        <p class="txt_Normal">Sin datos de cotizaciones</p>
                    <?php
                    } else {?>
                        <p class="txt_Normal">Total cotizaciones: $ <?php echo number_format($ValorTotalCotizaciones);?></p>
                        <p class="txt_Normal">Cantidad cotizaciones: <?php echo number_format(count($ListadoCotizaciones)/3);?></p>
                        <ul>
                            <?php
                            for ($i = 0; $i < count($ListadoCotizaciones); $i += 3) {?>
                                <li class="datos_variables">COT: <?php echo $ListadoCotizaciones[$i+1];?></li>
                                <ul>
                                    <li class="datos_variables">Fecha: <?php echo $ListadoCotizaciones[$i];?></li>
                                    <li class="datos_variables">Valor: $ <?php echo number_format($ListadoCotizaciones[$i+2]);?></li>
                                </ul>
                            <?php
                            }?>
                        </ul>
                    <?php
                    }?>
                    <div class="div_Style"></div>
                    <?php
                    if ($ValorTotalRemisiones == 0) {?>
                        <p class="txt_Normal">Sin datos de remisiones</p>
                    <?php
                    } else {?>
                        <p class="txt_Normal">Total remisiones: $ <?php echo number_format($ValorTotalRemisiones);?></p>
                        <p class="txt_Normal">Cantidad remisiones: <?php echo number_format(count($ListadoRemisiones)/4);?></p>
                        <ul>
                            <?php
                            for ($i = 0; $i < count($ListadoRemisiones); $i += 4) {?>
                                <li class="datos_variables">REM: <?php echo $ListadoRemisiones[$i+1];?></li>
                                <ul>
                                    <li class="datos_variables">Fecha: <?php echo $ListadoRemisiones[$i];?></li>
                                    <li class="datos_variables">COT: <?php echo datosPlanillaProduccion($ListadoRemisiones[$i+2])['planilla_produccion_Cotizacion'];?></li>
                                    <li class="datos_variables">Valor: $ <?php echo number_format($ListadoRemisiones[$i+3]);?></li>
                                </ul>
                            <?php
                            }?>
                        </ul>
                    <?php
                    }?>
                </div>
            <?php    
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>