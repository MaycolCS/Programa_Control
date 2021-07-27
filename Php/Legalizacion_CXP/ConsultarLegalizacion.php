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
    if (!validarPermisosUsuario($Documento,array(15,16,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $Legalizaciones = listaLegalizacionesCXP();
    $cant_Legalizaciones = count($Legalizaciones);
    $aux_cant_Legalizaciones = 0;
    if ($cant_Legalizaciones == 0) {
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=LSLCXP");
        exit();
    }

    $Legalizacion = "";
    if (isset($_POST['Legalizacion'])) {
        $Legalizacion = $_POST['Legalizacion'];
        if (!estaLegalizacionCXP($Legalizacion)) {
            ?><script>alert("¡La legalización no se encuentra registrada!")</script><?php
            $Legalizacion = "";
        }
    } elseif ($Mensaje == "ORLEG") {
        ?><script>alert("Legalización de cuenta por pagar <?php echo $_GET['LEG'];?> guardada correctamente")</script><?php
        $Legalizacion = $_GET['LEG'];
    }

    $DatosLegalizacion = datosLegalizacionCXP($Legalizacion);
    $ValorSubtotalItems = 0;
    $ValorIvaItems = 0;
    $ReteFuente_cxp = 0;
    $ReteICA_cxp = 0;
    $ReteIVA_cxp = 0;
    
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
            if ($Legalizacion=="") {?>
                <form class="form_Style" method="post" action="ConsultarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Consultar legalización CXP</p>
                    <div>
                        <label>Legalización:</label>
                        <input list="listaLegalizaciones" name="Legalizacion" id="Legalizacion" autocomplete="off" required/>
                        <datalist id="listaLegalizaciones">
                            <?php
                            for ($i = 0; $i < count($Legalizaciones); $i += 2) {?>
                                <option value="<?php echo $Legalizaciones[$i] ;?>"><?php echo $Legalizaciones[$i+1] ;?></option>
                            <?php
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="Boton_Style">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
            <?php
            } else {?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <?php
                            include '../Static/encabezadoTablas.html';
                        ?>
                        <script type="text/javascript">
                            elemento = document.getElementById("direccionEmpresa");
                            elemento.style.display='none';
                            elemento = document.getElementById("telefonoEmpresa");
                            elemento.style.display='none';
                            elemento = document.getElementById("ciudadEmpresa");
                            elemento.style.display='none';
                            elemento = document.getElementById("actividadEconomicaEmpresa");
                            elemento.style.display='none';
                            elemento = document.getElementById("retencionEmpresa");
                            elemento.style.display='none';
                            elemento = document.getElementById("facturacionEmpresa");
                            elemento.style.display='none';
                        </script>
                        <tr>
                            <td class="espacio" colspan="7">
                                <?php
                                    if ($DatosLegalizacion[17] == "SI") {
                                        echo "LEGALIZACIÓN CXP ANULADA";
                                    }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <table class="tabla_encabezado">
                        <tr>
                            <td class="datos_fijos_inicial" rowspan="2">FECHA</td>
                            <td class="datos_fijos">AÑO</td>
                            <td class="datos_fijos">MES</td>
                            <td class="datos_fijos">DÍA</td>
                            <td class="datos_empresa" rowspan="2"></td>
                            <td class="datos_fijos_inicial" rowspan="2">CUENTA POR PAGAR</td>
                            <td class="datos_fijos" rowspan="2"><?php echo $DatosLegalizacion[0]; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[1]; ?></td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[2]; ?></td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[3]; ?></td>
                        </tr>
                        <tr>
                            <td class="espacio" colspan="7"></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">NIT</td>
                            <td class="datos_variables" colspan="2"><?php echo $DatosLegalizacion[4]; ?></td>
                            <td class="datos_fijos">DV</td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[5]; ?></td>
                            <td class="datos_fijos">COTIZACION</td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[11]; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
                            <td class="datos_variables" colspan="4" rowspan="2"><?php echo $DatosLegalizacion[6]; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" >C.C.</td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[12]; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">TELEFONO</td>
                            <td class="datos_variables" colspan="4"><?php echo $DatosLegalizacion[7]; ?></td>
                            <td class="datos_fijos" >F.C.</td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[13]; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">EMAIL</td>
                            <td class="datos_variables" colspan="4"><?php echo $DatosLegalizacion[8]; ?></td>
                            <td class="datos_fijos">NIT CLIENTE</td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[14]; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">CIUDAD</td>
                            <td class="datos_variables" colspan="4"><?php echo $DatosLegalizacion[9]; ?></td>
                            <td class="datos_fijos" rowspan="2">CLIENTE</td>
                            <td class="datos_variables" rowspan="2"><?php echo $DatosLegalizacion[15]; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">DIRECCIÓN</td>
                            <td class="datos_variables" colspan="4"><?php echo $DatosLegalizacion[10]; ?></td>
                        </tr>

                    </table>

                    <table class="tabla_items">
                        <tr>
                            <th>Item</th>
                            <th>Detalle</th>
                            <th>Cantidad</th>
                            <th>Valor unitario</th>
                            <th>Valor total</th>
                            <th>Valor IVA</th>
                        </tr>
                        <?php
                        $PosItems = 18;
                        $CantidadItems = cantidadDatosLegalizacionCXP($Legalizacion);
                        $AuxCantidadItems = 1;
                        while ($AuxCantidadItems <= $CantidadItems) {?>
                            <tr>
                                <td><?php echo $AuxCantidadItems; ?></td>
                                <td><?php echo $DatosLegalizacion[$PosItems+1]; ?></td>
                                <td><?php echo $DatosLegalizacion[$PosItems+2]; ?></td>
                                <td>$ <?php echo number_format($DatosLegalizacion[$PosItems+3]); ?></td>
                                <td>$ <?php echo number_format($DatosLegalizacion[$PosItems+4]); ?></td>
                                <td>$ <?php echo number_format($DatosLegalizacion[$PosItems+5]); ?></td>
                            </tr>
                            <?php
                            $ValorSubtotalItems = $ValorSubtotalItems + $DatosLegalizacion[$PosItems+4];
                            $ValorIvaItems = $ValorIvaItems + $DatosLegalizacion[$PosItems+5];
                            $PosItems = $PosItems + 6;
                            $AuxCantidadItems = $AuxCantidadItems + 1;
                        }
                        $ReteFuente_cxp = 0;
                        if ($ValorSubtotalItems > 895000) { 
                            $ReteFuente_cxp = ($ValorSubtotalItems*0.025);
                        }
                        $ReteICA_cxp = (($ValorSubtotalItems*11.04)/1000);
                        $ReteIVA_cxp = ($ValorIvaItems*0.15);
                        ?>
                    </table>

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
                            <td class="datos_variables">$ <?php echo number_format($ValorSubtotalItems); ?></td>
                            <td class="datos_variables">$ <?php echo number_format($ValorIvaItems); ?></td>
                            <td class="datos_variables">$ <?php  ?></td>
                            <td class="datos_variables">$ <?php echo number_format(($ValorIvaItems*0.15)); ?></td>
                            <td class="datos_variables">$ <?php echo number_format((($ValorSubtotalItems*11.04)/1000)); ?></td>
                            <td class="datos_variables">$ <?php echo number_format(($ValorSubtotalItems+$ValorIvaItems)-$ReteFuente_cxp-$ReteIVA_cxp-$ReteICA_cxp); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" colspan="2">ELABORADO POR:</td>
                            <td class="datos_variables" colspan="4"><?php echo datosUsuario($DatosLegalizacion[16])['usuario_Nombre']." ".datosUsuario($DatosLegalizacion[16])['usuario_Apellido']; ?></td>
                        </tr>
                    </table>
                </div>

                <div id="lista_WR">
                    <ul>
                        <p class="txt_Subtitulo">CUENTA POR PAGAR <?php echo $DatosLegalizacion[0]; ?></p>
                        <?php
                            if ($DatosLegalizacion[17] == "SI") {?>
                                <li>
                                    <?php echo "LEGALIZACIÓN CXP ANULADA"; ?>
                                </li>
                            <?php
                            }
                            ?>
                        <li>AÑO: <?php echo $DatosLegalizacion[1]; ?></li>
                        <li>MES: <?php echo $DatosLegalizacion[2]; ?></li>
                        <li>DÍA: <?php echo $DatosLegalizacion[3]; ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Datos tercero</p>
                        <li>NIT: <?php echo $DatosLegalizacion[4]; ?></li>
                        <li>DV: <?php echo $DatosLegalizacion[5]; ?></li>
                        <li>RAZON SOCIAL: <?php echo $DatosLegalizacion[6]; ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Listado items</p>
                        <?php
                        $PosItems = 18;
                        $CantidadItems = cantidadDatosLegalizacionCXP($Legalizacion);
                        $AuxCantidadItems = 1;
                        while ($AuxCantidadItems <= $CantidadItems) {?>
                            <li>Item #<?php echo $AuxCantidadItems; ?></li>
                            <ul>
                                <li>Detalle: <?php echo $DatosLegalizacion[$PosItems+1]; ?></li>
                                <li>Cantidad: <?php echo $DatosLegalizacion[$PosItems+2]; ?></li>
                                <li>Valor unitario: $ <?php echo number_format($DatosLegalizacion[$PosItems+3]); ?></li>
                                <li>Valor total: $ <?php echo number_format($DatosLegalizacion[$PosItems+4]); ?></li>
                                <li>Valor IVA: $ <?php echo number_format($DatosLegalizacion[$PosItems+5]); ?></li>
                            </ul>
                            <?php
                            $PosItems = $PosItems + 6;
                            $AuxCantidadItems = $AuxCantidadItems + 1;
                        }?>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <li class="datos_fijos">SUBTOTAL: $ <?php echo number_format($ValorSubtotalItems); ?></li>
                        <li class="datos_fijos">IVA DESCONTABLE: $ <?php echo number_format($ValorIvaItems); ?></li>
                        <li class="datos_fijos">RETEFUENTE: $ <?php if ($ValorSubtotalItems > 895000) { echo number_format(($ValorSubtotalItems*0.025));} else { echo 0;} ?></li>
                        <li class="datos_fijos">RETEIVA: $ <?php echo number_format(($ValorIvaItems*0.15)); ?></li>
                        <li class="datos_fijos">RETEICA: $ <?php echo number_format((($ValorSubtotalItems*11.04)/1000)); ?></li>
                        <li class="datos_fijos">TOTAL: $ <?php echo number_format(($ValorSubtotalItems+$ValorIvaItems)-$ReteFuente_cxp-$ReteIVA_cxp-$ReteICA_cxp); ?></li>
                    </ul>
                    <ul>
                        <li class="datos_fijos" colspan="2">ELABORADO POR: <?php echo $DatosLegalizacion[16]; ?></li>
                    </ul>

                </div>
                <?php
                    if ($DatosLegalizacion[17] != "SI") {?>
                        <form name="form" class="form_Style" method="post" action="../GenerarPDF/legalizacion_cxp? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&LEG=<?php echo $DatosLegalizacion[0]; ?>">
                            <div>
                                <button type="submit">Generar PDF</button>
                            </div>
                        </form>
                    <?php
                    }
                ?>
            <?php    
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>