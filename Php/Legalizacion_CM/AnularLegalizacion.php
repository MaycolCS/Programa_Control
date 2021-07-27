<?php
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "ESLEG") {
            echo '<script>alert("¡La legalización no se encuentra registrada!")</script>';
        }
    }

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $Legalizaciones = listaLegalizacionesCMSinAnular();
    $cant_Legalizaciones = count($Legalizaciones);
    $aux_cant_Legalizaciones = 0;
    if ($cant_Legalizaciones == 0) {
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=LSLCMPA");
        exit();
    }

    $Legalizacion = "";
    if (isset($_POST['Legalizacion'])) {
        $Legalizacion = $_POST['Legalizacion'];
        if (!estaLegalizacionCM($Legalizacion)) {
            header("Location: AnularLegalizacion? cc=$Documento&cs=$CS&msj=ESLEG");
            exit();
        }
    }
    $DatosLegalizacion = datosLegalizacionCM($Legalizacion);
    $ValorSubtotalItems = 0;
    $ValorIvaItems = 0;
    
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
                <form class="form_Style" method="post" action="AnularLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Anular legalización CM</p>
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
                                    if ($DatosLegalizacion[8] == "SI") {
                                        echo "LEGALIZACIÓN C.M. ANULADA";
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
                            <td class="datos_fijos_inicial" rowspan="2">LEGALIZACIÓN</td>
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
                            <td class="datos_fijos">RAZON SOCIAL</td>
                            <td class="datos_variables"><?php echo $DatosLegalizacion[6]; ?></td>
                        </tr>
                        
                    </table>

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
                        </tr>
                        <?php
                        $PosItems = 9;
                        $CantidadItems = cantidadDatosLegalizacionCM($Legalizacion);
                        $AuxCantidadItems = 1;
                        while ($AuxCantidadItems <= $CantidadItems) {?>
                            <tr>
                                <td><?php echo $AuxCantidadItems; ?></td>
                                <td><?php echo $DatosLegalizacion[$PosItems]; ?></td>
                                <td><?php echo $DatosLegalizacion[$PosItems+1]; ?></td>
                                <td><?php echo $DatosLegalizacion[$PosItems+2]; ?></td>
                                <td><?php echo $DatosLegalizacion[$PosItems+3]; ?></td>
                                <td><?php echo $DatosLegalizacion[$PosItems+4]; ?></td>
                                <td>$ <?php echo number_format($DatosLegalizacion[$PosItems+5]); ?></td>
                                <td>$ <?php echo number_format($DatosLegalizacion[$PosItems+6]); ?></td>
                                <td>$ <?php echo number_format($DatosLegalizacion[$PosItems+7]); ?></td>
                            </tr>
                            <?php
                            $ValorSubtotalItems = $ValorSubtotalItems + $DatosLegalizacion[$PosItems+6];
                            $ValorIvaItems = $ValorIvaItems + $DatosLegalizacion[$PosItems+7];
                            $PosItems = $PosItems + 9;
                            $AuxCantidadItems = $AuxCantidadItems + 1;
                        }?>
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
                            <td class="datos_variables">$ -</td>
                            <td class="datos_variables">$ -</td>
                            <td class="datos_variables">$ -</td>
                            <td class="datos_variables">$ <?php echo number_format(($ValorSubtotalItems+$ValorIvaItems)); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" colspan="2">ELABORADO POR:</td>
                            <td class="datos_variables" colspan="4"><?php echo datosUsuario($DatosLegalizacion[7])['usuario_Nombre']." ".datosUsuario($DatosLegalizacion[7])['usuario_Apellido']; ?></td>
                        </tr>
                    </table>
                </div>

                <div id="lista_WR">
                    <ul>
                        <p class="txt_Subtitulo">LEGALIZACIÓN <?php echo $DatosLegalizacion[0]; ?></p>
                        <?php
                            if ($DatosLegalizacion[8] == "SI") {?>
                                <li>
                                    <?php echo "LEGALIZACIÓN C.M. ANULADA"; ?>
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
                        $PosItems = 9;
                        $CantidadItems = cantidadDatosLegalizacionCM($Legalizacion);
                        $AuxCantidadItems = 1;
                        while ($AuxCantidadItems <= $CantidadItems) {?>
                            <li><?php echo $AuxCantidadItems; ?></li>
                            <ul>
                                <li><?php echo $DatosLegalizacion[$PosItems]; ?></li>
                                <li><?php echo $DatosLegalizacion[$PosItems+1]; ?></li>
                                <li><?php echo $DatosLegalizacion[$PosItems+2]; ?></li>
                                <li><?php echo $DatosLegalizacion[$PosItems+3]; ?></li>
                                <li><?php echo $DatosLegalizacion[$PosItems+4]; ?></li>
                                <li>$ <?php echo number_format($DatosLegalizacion[$PosItems+5]); ?></li>
                                <li>$ <?php echo number_format($DatosLegalizacion[$PosItems+6]); ?></li>
                                <li>$ <?php echo number_format($DatosLegalizacion[$PosItems+7]); ?></li>
                            </ul>
                            <?php
                            $PosItems = $PosItems + 9;
                            $AuxCantidadItems = $AuxCantidadItems + 1;
                        }?>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <li class="datos_fijos">SUBTOTAL: $ <?php echo number_format($ValorSubtotalItems); ?></li>
                        <td class="datos_fijos">IVA DESCONTABLE: $ <?php echo number_format($ValorIvaItems); ?></td>
                        <td class="datos_fijos">RETEFUENTE: $ -</td>
                        <td class="datos_fijos">RETEIVA: $ -</td>
                        <td class="datos_fijos">RETEICA: $ -</td>
                        <li class="datos_fijos">TOTAL: $ <?php echo number_format(($ValorSubtotalItems+$ValorIvaItems)); ?></li>
                    </ul>
                    <ul>
                        <li class="datos_fijos" colspan="2">ELABORADO POR: <?php echo $DatosLegalizacion[7]; ?></li>
                    </ul>

                </div>
                <?php
                    if ($DatosLegalizacion[8] != "SI") {?>
                        <form name="form" class="form_Style" method="post" action="AnularLegalizacionDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&LEG=<?php echo $DatosLegalizacion[0]; ?>">
                            <div>
                                <button type="submit">Anular legalización</button>
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