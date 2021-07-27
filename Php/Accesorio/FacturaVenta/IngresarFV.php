<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(14,16,24,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "EREMADD") {
            ?><script>alert("La remisión no se pudo añadir a la factura. Intentelo nuevamente")</script><?php
        } else if ($Mensaje == "REMEX") {
            ?><script>alert("La remisión ya se encuentra añadida a la factura")</script><?php
        } else if ($Mensaje == "REMADD") {
            ?><script>alert("La remisión fue añadida a la factura exitosamente")</script><?php
        } else if ($Mensaje == "ERFV") {
            ?><script>alert("La factura de venta no se pudo guardar, intentelo nuevamente.")</script><?php
        } else if ($Mensaje == "ESREM") {
            ?><script>alert("La remisión no se encuentra registrada")</script><?php
        }
    }

    $datosUsuario = datosUsuario($Documento);

    $Tercero = 0;
    if (isset($_GET['TR'])) {
        if ($_GET['TR'] != 0) {
            $Tercero = $_GET['TR'];
        }
    }

    $IdRem = "";
    if (isset($_POST['Remision'])) {
        $IdRem = $_POST['Remision'];
        if (!estaRemision($IdRem)) {
            $IPFV = $_GET['IPFV'];
            header("Location: IngresarFV? cc=$Documento&cs=$CS&IPFV=$IPFV&TR=$Tercero&msj=ESREM");
            exit();
        }
        elseif (!estaDisponibleRemision($IdRem)) {
            ?><script>alert("La remisión <?php echo ($IdRem);?> se encuentra anulada o ya tiene una factura de venta asignada, por este motivo no puede ser usada.")</script><?php
            $IdRem = "";
        }
    }

    if ($IdRem != "") {
        $DatosRemision = datosRemision($IdRem);
        if ($_GET['TR'] != 0) {
            $Tercero = $_GET['TR'];
        } else {
            $Tercero = $DatosRemision['remision_NitTercero'];
        }
        $DatosRemision_Items = itemsRemision($IdRem);
    }

    if ($Tercero == 0) {
        $Remisiones = listaRemisionesSinFacturaVenta();
        $cant_Remisiones = count($Remisiones);
        if ($cant_Remisiones == 0) {
            header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ELREM");
            exit();
        }
        $aux_cant_Remisiones = 0;
    } else {
        $Remisiones = listaRemisionesSinFacturaVentaTercero($Tercero);
        $cant_Remisiones = count($Remisiones);
        $aux_cant_Remisiones = 0;
    }

    $IdProvFV = 0;
    if (isset($_GET['IPFV'])) {
        $IdProvFV = $_GET['IPFV'];
        if ($IdProvFV != 0) {
            $CantidadRemisiones = countRemisiones_ProvFV($IdProvFV);
        }
    }
    $RemProvFV = listaRemisiones_ProvFV($IdProvFV);
    $cant_RemProvFV = count($RemProvFV);
    $aux_cant_RemProvFV = 0;

    $CantidadRemisiones = countRemisiones_ProvFV($IdProvFV);
    if ($CantidadRemisiones == 24) {
        ?><script>alert("¡Ha llegado al máximo de remisiones por factura de venta, continue el proceso dando al boton de finalizar!")</script><?php
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
            
            <?php
            if ($CantidadRemisiones < 24) {
                ?><div class="div_Style"></div><?php
                if ($IdRem=="") {?>
                    <form class="form_Style" method="post" action="IngresarFV.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&TR=<?php echo $Tercero; ?>&IPFV=<?php echo $IdProvFV; ?>">
                        <p class="txt_Titulo">Registro factura venta</p>
                        <div>
                            <label>Remisión:</label>
                            <input list="listaRemisiones" name="Remision" id="Remision" autocomplete="off" required/>
                            <datalist id="listaRemisiones">
                                <?php
                                for ($i = 0; $i < count($Remisiones); $i += 2) {?>
                                    <option value="<?php echo $Remisiones[$i] ;?>"><?php echo $Remisiones[$i+1] ;?></option>
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
                                <td class="datos_fijos_inicial" rowspan="2">REMISIÓN</td>
                                <td class="datos_fijos" rowspan="2"><?php echo $DatosRemision['remision_Id']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_variables"><?php echo $DatosRemision['remision_Año']; ?></td>
                                <td class="datos_variables"><?php echo $DatosRemision['remision_Mes']; ?></td>
                                <td class="datos_variables"><?php echo $DatosRemision['remision_Dia']; ?></td>
                            </tr>
                            <tr>
                                <td class="espacio" colspan="7"></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">NIT</td>
                                <td class="datos_variables" colspan="2"><?php echo $DatosRemision['remision_NitTercero']; ?></td>
                                <td class="datos_fijos">DV</td>
                                <td class="datos_variables"><?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Dv']; ?></td>
                                <td class="datos_fijos">PLANILLA PRODUCCIÓN</td>
                                <td class="datos_variables"><?php echo $DatosRemision['remision_PlanillaProduccion']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
                                <td class="datos_variables" rowspan="2" colspan="4"><?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_RazonSocial']; ?></td>
                                <td class="datos_fijos">COTIZACIÓN</td>
                                <td class="datos_variables"><?php echo PlanillaProduccion_IdCotizacion($DatosRemision['remision_PlanillaProduccion']); ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">CONTACTO</td>
                                <td class="datos_variables">ING. <?php echo datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Contacto']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">TELEFONO</td>
                                <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Telefono1']; ?></td>
                                <td class="datos_fijos">TELEFONO</td>
                                <td class="datos_variables"><?php echo datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Telefono1']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">EMAIL</td>
                                <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Email']; ?></td>
                                <td class="datos_fijos">ORDEN DE COMPRA</td>
                            <td class="datos_variables"><?php echo $DatosRemision['remision_OrdenCompra']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">CIUDAD</td>
                                <td class="datos_variables" colspan="4"><?php echo nombreDepartamento(datosTercero($DatosRemision['remision_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosRemision['remision_NitTercero'])['tercero_Ciudad']); ?></td>
                                <td class="datos_fijos">CIUDAD DE ENTREGA</td>
                                <td class="datos_variables"><?php echo nombreDepartamento(datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Ciudad']); ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">DIRECCIÓN</td>
                                <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Direccion']; ?></td>
                                <td class="datos_fijos">DIRECCIÓN DE ENTREGA</td>
                                <td class="datos_variables"><?php echo datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Direccion']; ?></td>
                            </tr>
                            
                        </table>

                        <table class="tabla_items">
                            <tr>
                                <th>Item</th>
                                <th colspan="3">Detalle</th>
                                <th>Cantidad</th>
                            </tr>
                            <?php
                            for ($i = 0; $i < count($DatosRemision_Items); $i += 4) {?>
                                <tr>
                                    <td><?php echo ($i/4+1); ?></td>
                                    <td colspan="3"><?php echo $DatosRemision_Items[$i]; ?></td>
                                    <td><?php echo $DatosRemision_Items[$i+1]; ?></td>
                                </tr>
                                <?php
                            }?>
                        </table>

                        <table class="tabla_footer">
                            <tr>
                                <td class="datos_variables_firma" rowspan="2"></td>
                                <td class="datos_fijos" colspan="5">OBSERVACIONES</td>
                            </tr>
                            <tr>
                                <td class="datos_variables" colspan="5" rowspan="3"></td>
                            </tr>
                            <tr>
                                <td class="datos_variables">ING. <?php echo datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Apellido']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_variables">TEL: <?php echo datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Celular']; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div id="lista_WR">
                        <ul>
                            <p class="txt_Subtitulo">REMISIÓN <?php echo $DatosRemision['remision_Id']; ?></p>
                            <li>AÑO: <?php echo $DatosRemision['remision_Año']; ?></li>
                            <li>MES: <?php echo $DatosRemision['remision_Mes']; ?></li>
                            <li>DÍA: <?php echo $DatosRemision['remision_Dia']; ?></li>
                            <li>PLANILLA PRODUCCIÓN: <?php echo $DatosRemision['remision_PlanillaProduccion']; ?></li>
                            <li>COTIZACIÓN: <?php echo PlanillaProduccion_IdCotizacion($DatosRemision['remision_PlanillaProduccion']); ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Datos del cliente</p>
                            <li>NIT: <?php echo $DatosRemision['remision_NitTercero']; ?></li>
                            <li>DV: <?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Dv']; ?></li>
                            <li>RAZON SOCIAL: <?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_RazonSocial']; ?></li>
                            <li>TELEFONO: <?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Telefono1']; ?></li>
                            <li>EMAIL: <?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Email']; ?></li>
                            <li>CIUDAD: <?php echo nombreDepartamento(datosTercero($DatosRemision['remision_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosRemision['remision_NitTercero'])['tercero_Ciudad']); ?></li>
                            <li>DIRECCIÓN: <?php echo datosTercero($DatosRemision['remision_NitTercero'])['tercero_Direccion']; ?></li>
                            <li>CONTACTO: ING. <?php echo datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Contacto']; ?></li>
                            <li>TELEFONO: <?php echo datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Telefono1']; ?></li>
                            <li>CIUDAD DE ENTREGA: <?php echo nombreDepartamento(datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Ciudad']); ?></li>
                            <li>DIRECCIÓN DE ENTREGA: <?php echo datosPlantaTercero($DatosRemision['remision_PlantaEntrega'])['planta_tercero_Direccion']; ?></li>
                            <li>ORDEN DE COMPRA: <?php echo $DatosRemision['remision_OrdenCompra']; ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Productos</p>
                            <?php
                            for ($i = 0; $i < count($DatosRemision_Items); $i += 4) {?>
                                <li>Item # <?php echo ($i/4+1); ?></li>
                                <ul>
                                    <li>Detalle: <?php echo $DatosRemision_Items[$i]; ?></li>
                                    <li>Cantidad: <?php echo $DatosRemision_Items[$i+1]; ?></li>
                                </ul>
                                <?php
                            }?>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Vendedor</p>
                            <li>Nombre: ING. <?php echo datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Apellido']; ?></li>
                            <li>Telefono: <?php echo datosUsuario($DatosRemision['remision_Vendedor'])['usuario_Celular']; ?></li>
                        </ul>
                    </div>
                    <div class="div_Style"></div>
                    <form class="form_Style" method="post" action="AddRemFV.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&TR=<?php echo $Tercero; ?>&IPFV=<?php echo $IdProvFV; ?>&REM=<?php echo $IdRem; ?>&VLREM=<?php echo $DatosRemision['remision_ValorTotal']; ?>">  
                        <div class="Boton_Style">
                            <button type="submit">Añadir remisión</button>
                        </div>
                    </form>
                <?php
                }
            }?>

            <?php
            if ($CantidadRemisiones>0) {?>
                <div class="div_Style"></div>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_items">
                        <p class="txt_Titulo">Remisiones añadidas</p>
                        <tr>
                            <th>Remision</th>
                            <th>Detalle item</th>
                            <th>Cantidad item</th>
                            <th>Valor unidad item</th>
                            <th>Valor total item</th>
                            <th>Valor remisión</th>
                        </tr>
                        <?php
                        $Remisiones_ValorTotal = 0;
                        while ($aux_cant_RemProvFV < $cant_RemProvFV) {
                            $Remision_Items = itemsRemision($RemProvFV[$aux_cant_RemProvFV]); 
                            $Remision_cantidadItems = (count($Remision_Items)/4); ?>
                            <tr>
                                <td rowspan="<?php echo $Remision_cantidadItems;?>"><?php echo $RemProvFV[$aux_cant_RemProvFV];?></td>
                                <?php
                                $val = FALSE;
                                for ($k = 0; $k < count($Remision_Items); $k += 4) {?>
                                    <?php if ($val) {?><tr><?php }?>
                                        <td><?php echo $Remision_Items[$k];?></td>
                                        <td><?php echo $Remision_Items[$k+1];?></td>
                                        <td>$ <?php echo number_format(round($Remision_Items[$k+2]));?></td>
                                        <td>$ <?php echo number_format(round($Remision_Items[$k+3]));?></td>
                                    <?php if ($val) {?>
                                        </tr>
                                    <?php 
                                    } else {?>
                                        <td rowspan="<?php echo $Remision_cantidadItems;?>">$ <?php echo number_format(round($RemProvFV[$aux_cant_RemProvFV+1]));?></td>
                                        <?php
                                        $Remisiones_ValorTotal += $RemProvFV[$aux_cant_RemProvFV+1];
                                    }
                                    $val = TRUE;
                                }?> 
                            </tr>
                            <?php
                            $aux_cant_RemProvFV = $aux_cant_RemProvFV+3;
                        }
                        ?>
                        <tr>
                            <th colspan="2">Valor total remisiones</th>
                            <td colspan="4">$ <?php echo number_format(round($Remisiones_ValorTotal));?></td>
                        </tr>
                    </table>
                </div>
                <div id="lista_WR">
                    <p class="txt_Titulo">Remisiones añadidas</p>
                    <?php
                    $Remisiones_ValorTotal = 0;
                    $aux_cant_RemProvFV = 0;
                    while ($aux_cant_RemProvFV < $cant_RemProvFV) {
                        $Remision_Items = itemsRemision($RemProvFV[$aux_cant_RemProvFV]); 
                        $Remision_cantidadItems = (count($Remision_Items)/4); ?>
                        <li>Remisión <?php echo $RemProvFV[$aux_cant_RemProvFV];?></li>
                        <ul>
                            <li>Items</li>
                            <ul>
                                <?php
                                for ($k = 0; $k < count($Remision_Items); $k += 4) {?>
                                    <li>Item # <?php echo ($k+4+1);?></li>
                                    <ul>
                                        <li>Detalle item: <?php echo $Remision_Items[$k];?></li>
                                        <li>Cantidad item: <?php echo $Remision_Items[$k+1];?></li>
                                        <li>Valor unidad item: $ <?php echo number_format(round($Remision_Items[$k+2]));?></li>
                                        <li>Valor total item: $ <?php echo number_format(round($Remision_Items[$k+3]));?></li>
                                    </ul>
                                    <?php
                                    $Remisiones_ValorTotal += $RemProvFV[$aux_cant_RemProvFV+1];
                                }?>
                            </ul>
                            <li>Valor total remisión: $ <?php echo number_format(round($RemProvFV[$aux_cant_RemProvFV+1]));?></td>
                        </ul>
                        <div class="div_Style"></div>
                        <?php
                        $aux_cant_RemProvFV = $aux_cant_RemProvFV+3;
                    }
                    ?>
                    <ul>
                        <li colspan="2">Valor total remisiones</li>
                        <ul>
                            <li colspan="4">$ <?php echo number_format(round($Remisiones_ValorTotal));?></li>
                        </ul>
                    </ul>
                </div>
                
                <form name="form" class="form_Style" method="post" action="IngresarFVDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPFV=<?php echo $IdProvFV; ?>&TR=<?php echo $Tercero; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
                    <br>
                    <div>
                        <label>Observaciones:</label>
                        <textarea type="text" name="Observaciones" id="Observaciones" autocomplete="off"></textarea>
                    </div>    
                    <div>
                        <button type=button onclick="pregunta()" value="Enviar">Finalizar</button>
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