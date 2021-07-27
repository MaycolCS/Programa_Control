<?php
    
    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(12,22,16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if($Mensaje=="ESCOT") {
            if ($_GET['NT'] != 0) {
                $Mensaje="COTT";
            }
            echo '<script>alert("¡La cotización no se encuentra registrada!")</script>';
        }        
    }

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $Terceros = listaTerceros();
    $Tercero=0;
    if (isset($_POST['nitTercero']) or (isset($_GET['NT']) and $_GET['NT'] != 0)) {
        if (isset($_POST['nitTercero'])) {
            $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        } elseif (isset($_GET['NT'])) {
            $Tercero = $_GET['NT'];
        }
        if (!estaTercero($Tercero)) {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
            $Tercero=0;
        }
    }

    $CotizacionesTercero = listaCotizacionesTercero($Tercero);
    $cant_CotizacionesTercero = count($CotizacionesTercero);
    if ($Tercero != 0 and count($CotizacionesTercero) == 0) {
        $NitTercero= nombreTercero($Tercero);
        ?><script>alert("El tercero <?php echo $NitTercero;?> no tiene cotizaciones generadas actualmente")</script><?php
        $Tercero=0;
        $Mensaje="COTT";
    }

    $Cotizaciones = listaCotizaciones();

    $IdCotizacion = "";
    if (isset($_POST['Cotizacion'])) {
        $IdCotizacion = $_POST['Cotizacion'];
        if (!estaCotizacion($IdCotizacion)) {
            header("Location: ConsultarCotizacion? cc=$Documento&cs=$CS&NT=$Tercero&msj=ESCOT");
            exit();
        }
    } elseif ($Mensaje == "ORCOT") {
        ?><script>alert("Cotización <?php echo $_GET['cot'];?> guardada correctamente")</script><?php
        $IdCotizacion = $_GET['cot'];
    } elseif ($Mensaje == "OACOT") {
        ?><script>alert("Cotización <?php echo $_GET['cot'];?> actualizada correctamente")</script><?php
        $IdCotizacion = $_GET['cot'];
    }

    $DatosCotizacion = datosCotizacion($IdCotizacion);
    $Datos_ItemsCotizacion = itemsCotizacion($IdCotizacion);
    $listaCotizacionesSinPP = listaCotizaciones_SinPlanillaProduccion($Tercero);

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
            if ($Mensaje=="COTT" and $Tercero == 0) {?>
                <form class="form_Style" method="post" action="ConsultarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Cotizaciones tercero</p>
                    <div>
                        <label>Tercero:</label>
                        <input list="listaTerceros" name="nitTercero" id="nitTercero" title="Solo se permiten números" autocomplete="off" required/>
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
                        <button type="submit">Continuar</button>
                    </div>
                </form>
            <?php
            } elseif ($IdCotizacion=="") {?>
                <form class="form_Style" method="post" action="ConsultarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&cs=<?php echo $CS; ?>&NT=<?php echo $Tercero; ?>">
                    <p class="txt_Titulo">Consultar cotización</p>
                    <div>
                        <label>Cotización:</label>
                        <?php
                        if ($Tercero != 0) {?>
                            <input list="listaCotizacionesTercero" name="Cotizacion" id="Cotizacion" autocomplete="off" required/>
                            <datalist id="listaCotizacionesTercero">
                                <?php
                                for ($i = 0; $i < count($CotizacionesTercero); $i += 2) {?>
                                    <option value="<?php echo $CotizacionesTercero[$i] ;?>"><?php echo $CotizacionesTercero[$i+1] ;?></option>
                                <?php
                                }
                                ?>
                            </datalist>
                        <?php
                        } else {?>
                            <input list="listaCotizaciones" name="Cotizacion" id="Cotizacion" autocomplete="off" required/>
                            <datalist id="listaCotizaciones">
                                <?php
                                for ($i = 0; $i < count($Cotizaciones); $i += 2) {?>
                                    <option value="<?php echo $Cotizaciones[$i] ;?>"><?php echo $Cotizaciones[$i+1] ;?></option>
                                <?php
                                }
                                ?>
                            </datalist>
                        <?php
                        }?>
                    </div>
                    <div class="Boton_Style">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
                <?php
                if (count($listaCotizacionesSinPP) > 0) {?>
                    <div id="tabla_vistaEscritorio">
                        <table class="tabla_encabezado">
                            <tr>
                                <td class="datos_fijos">Fecha cotización</td>
                                <td class="datos_fijos">Cotízación</td>
                                <td class="datos_fijos">NIT</td>
                                <td class="datos_fijos">Razón social</td>
                                <td class="datos_fijos">Detalle</td>
                                <td class="datos_fijos">Cantidad</td>
                                <td class="datos_fijos">Valor unitario</td>
                                <td class="datos_fijos">Vendedor</td>
                            </tr>
                            <?php
                            $cant_max_cot = 0;
                            for ($i = 0; $i < count($listaCotizacionesSinPP) and $cant_max_cot < 20; $i += 2) {
                                $DatosCotizacion = datosCotizacion($listaCotizacionesSinPP[$i]);
                                $itemsCotizacion = itemsCotizacion($DatosCotizacion['cotizacion_Id']);
                                $val = FALSE;?>
                                <tr>
                                    <td class="datos_variables" rowspan="<?php echo (count($itemsCotizacion)/4);?>"><?php echo $DatosCotizacion['cotizacion_Fecha'];?></td>
                                    <td class="datos_variables" rowspan="<?php echo (count($itemsCotizacion)/4);?>"><?php echo $DatosCotizacion['cotizacion_Id'];?></td>
                                    <td class="datos_variables" rowspan="<?php echo (count($itemsCotizacion)/4);?>"><?php echo number_format($DatosCotizacion['cotizacion_NitTercero']);?></td>
                                    <td class="datos_variables" rowspan="<?php echo (count($itemsCotizacion)/4);?>"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_RazonSocial'];?></td>
                                    <?php
                                    for ($j = 0; $j < count($itemsCotizacion); $j += 4) {?>
                                        <?php
                                        if ($val) {?>
                                            <tr>
                                        <?php
                                        }?>
                                        <td class="datos_variables"><?php echo $itemsCotizacion[$j];?></td>
                                        <td class="datos_variables"><?php echo $itemsCotizacion[$j+1];?></td>
                                        <td class="datos_variables">$ <?php echo number_format($itemsCotizacion[$j+2]);?></td>
                                        <?php
                                        if ($val) {?>
                                            </tr>
                                        <?php
                                        } else {?>
                                            <td class="datos_variables" rowspan="<?php echo (count($itemsCotizacion)/4);?>"><?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Apellido'];?></td>
                                        <?php
                                        }
                                        $val = TRUE;?>
                                    <?php
                                    }?>
                                </tr>
                                <?php
                                $cant_max_cot += 1;
                            }?>
                        </table>
                    </div>
                    <div id="lista_WR">
                        <ul>
                            <?php
                            $cant_max_cot = 0;
                            for ($i = 0; $i < count($listaCotizacionesSinPP) and $cant_max_cot < 20; $i += 2) {
                                $DatosCotizacion = datosCotizacion($listaCotizacionesSinPP[$i]);
                                $itemsCotizacion = itemsCotizacion($DatosCotizacion['cotizacion_Id']);?>
                                <div class="div_Style"></div>
                                <p class="txt_Normal"><?php echo $DatosCotizacion['cotizacion_Id'];?></p>
                                <ul>
                                    <li class="datos_variables">Fecha: <?php echo $DatosCotizacion['cotizacion_Fecha'];?></li>
                                    <li class="datos_variables">Nit: <?php echo number_format($DatosCotizacion['cotizacion_NitTercero']);?></li>
                                    <li class="datos_variables">Tercero: <?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_RazonSocial'];?></li>
                                    <li class="datos_variables">Vendedor: <?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Apellido'];?></li>
                                    <p class="txt_Normal">Items</p>
                                    <?php
                                    for ($j = 0; $j < count($itemsCotizacion); $j += 4) {?>
                                        <li class="datos_variables">Detalle: <?php echo $itemsCotizacion[$j];?></li>
                                        <ul>
                                            <li class="datos_variables">Cantidad: <?php echo $itemsCotizacion[$j+1];?></li>
                                            <li class="datos_variables">Valor unitario: $ <?php echo number_format($itemsCotizacion[$j+2]);?></li>
                                        </ul>
                                    <?php
                                    }
                                $cant_max_cot += 1;?>
                                </ul>
                            <?php
                            }?>
                        </ul>
                    </div>
                <?php
                }?>
            <?php
            } else {?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <?php
                            include '../Static/encabezadoTablas.html';
                        ?>
                        <script type="text/javascript">
                            $("#emailEmpresa").text("<?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Correo'];?>");
                            $("#telefonoEmpresa").text("<?php echo "TEL: ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Celular'];?>");
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
                                    if ($DatosCotizacion['cotizacion_Anulada'] == "SI") {
                                        echo "COTIZACIÓN ANULADA";
                                    } elseif (!CotizacionTienePlanilla($DatosCotizacion['cotizacion_Id'])) {
                                        echo "Cotización sin planilla de trabajo";
                                    } else {
                                        echo "Cotización con planilla de trabajo ".Cotizacion_PlanillasProduccion($DatosCotizacion['cotizacion_Id']);
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if ($DatosCotizacion['cotizacion_Anulada'] == "SI") {?>
                            <tr>
                                <td class="datos_fijos">MOTIVO ANULACIÓN</td>
                                <td class="datos_variables" colspan="6"><?php echo $DatosCotizacion['cotizacion_MotivoAnulacion']; ?></td>
                            </tr>
                        <?php
                        }?>
                    </table>
                    <table class="tabla_encabezado">
                        <tr>
                            <td class="datos_fijos_inicial" rowspan="2">FECHA</td>
                            <td class="datos_fijos">AÑO</td>
                            <td class="datos_fijos">MES</td>
                            <td class="datos_fijos">DÍA</td>
                            <td class="datos_empresa" rowspan="2"></td>
                            <td class="datos_fijos_inicial" rowspan="2">COTIZACIÓN</td>
                            <td class="datos_fijos" rowspan="2"><?php echo $DatosCotizacion['cotizacion_Id']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables"><?php echo $DatosCotizacion['cotizacion_Año']; ?></td>
                            <td class="datos_variables"><?php echo $DatosCotizacion['cotizacion_Mes']; ?></td>
                            <td class="datos_variables"><?php echo $DatosCotizacion['cotizacion_Dia']; ?></td>
                        </tr>
                        <tr>
                            <td class="espacio" colspan="7"></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">NIT</td>
                            <td class="datos_variables" colspan="2"><?php echo number_format($DatosCotizacion['cotizacion_NitTercero']); ?></td>
                            <td class="datos_fijos">DV</td>
                            <td class="datos_variables"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Dv']; ?></td>
                            <td class="datos_fijos">VALIDEZ OFERTA</td>
                            <td class="datos_variables"><?php echo date("Y-m-d",strtotime(date($DatosCotizacion['cotizacion_Fecha'])."+ 15 days")); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
                            <td class="datos_variables" rowspan="2" colspan="4"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_RazonSocial']; ?></td>

                            <td class="datos_fijos">CONTACTO</td>
                            <td class="datos_variables">ING. <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Contacto']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">TELEFONO</td>
                            <td class="datos_variables"><?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Telefono1']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">TELEFONO</td>
                            <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Telefono1']; ?></td>
                            <td class="datos_fijos">FORMA DE PAGO</td>
                            <td class="datos_variables"><?php echo nombre_FormaPago(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_FormaPago']); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">EMAIL</td>
                            <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Email']; ?></td>
                            <td class="datos_fijos">TIEMPO DE ENTREGA</td>
                            <td class="datos_variables"><?php echo $DatosCotizacion['cotizacion_TiempoEntrega']." DÍAS HABILES DESPÚES DE O.C."; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">CIUDAD</td>
                            <td class="datos_variables" colspan="4"><?php echo nombreDepartamento(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Ciudad']); ?></td>
                            <td class="datos_fijos">CIUDAD DE ENTREGA</td>
                            <td class="datos_variables"><?php echo nombreDepartamento(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Ciudad']); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">DIRECCIÓN</td>
                            <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Direccion']; ?></td>
                            <td class="datos_fijos">DIRECCIÓN DE ENTREGA</td>
                            <td class="datos_variables"><?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Direccion']; ?></td>
                        </tr>
                    </table>

                    <table class="tabla_items">
                        <tr>
                            <th>Item</th>
                            <th colspan="3">Detalle</th>
                            <th>Cantidad</th>
                            <th colspan="2">Precio unidad</th>
                            <th colspan="2">Precio total</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($Datos_ItemsCotizacion); $i += 4) {?>
                            <tr>
                                <td><?php echo ($i/4+1); ?></td>
                                <td colspan="3"><?php echo $Datos_ItemsCotizacion[$i]; ?></td>
                                <td><?php echo $Datos_ItemsCotizacion[$i+1]; ?></td>
                                <td colspan="2">$ <?php echo number_format($Datos_ItemsCotizacion[$i+2]); ?></td>
                                <td colspan="2">$ <?php echo number_format($Datos_ItemsCotizacion[$i+3]); ?></td>
                            </tr>
                            <?php
                        }?>
                    </table>

                    <table class="tabla_footer">
                        <tr>
                            <td class="datos_variables_firma" colspan="2" rowspan="4"></td>
                            <td class="datos_fijos" colspan="3">OBSERVACIONES</td>
                            <td class="datos_fijos" colspan="2">SUBTOTAL</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format($DatosCotizacion['cotizacion_Subtotal']); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables" colspan="3" rowspan="4">
                                El valor total debe ser consignado en la cuenta de ahorros del banco caja social No 24 098 446 818. 
                                <?php echo $DatosCotizacion['cotizacion_Observaciones']; ?>
                            </td>
                            <td class="datos_fijos">DCTO</td>
                            <td class="datos_fijos"><?php echo number_format(round($DatosCotizacion['cotizacion_PorcentajeDescuento'])); ?>%</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format(round($DatosCotizacion['cotizacion_ValorDescuento'])); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" colspan="2">IVA 19%</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format(round($DatosCotizacion['cotizacion_ValorIVA'])); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" rowspan="2" colspan="2">TOTAL A PAGAR</td>
                            <td class="datos_variables" rowspan="2" colspan="2">$ <?php echo number_format(round($DatosCotizacion['cotizacion_ValorTotal'])); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables" colspan="2" rowspan="2"><?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Apellido']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" colspan="7">VALOR EN LETRAS</td>
                        </tr>
                        <tr>
                            <td class="datos_variables" colspan="2">TEL: <?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Celular']; ?></td>
                            <td class="datos_variables" colspan="7"><?php echo convertirNumeroLetra(round($DatosCotizacion['cotizacion_ValorTotal'])); ?> PESOS M/CTE.</td>
                        </tr>
                    </table>
                </div>

                <div id="lista_WR">
                    <ul>
                        <p class="txt_Subtitulo">Cotización <?php echo $DatosCotizacion['cotizacion_Id']; ?></p>
                        <li>
                            <?php
                                if ($DatosCotizacion['cotizacion_Anulada'] == "SI") {
                                    echo "COTIZACIÓN ANULADA";
                                } elseif (!CotizacionTienePlanilla($DatosCotizacion['cotizacion_Id'])) {
                                    echo "Cotización sin planilla de trabajo";
                                } else {
                                    echo "Cotización con planilla de trabajo ".Cotizacion_PlanillasProduccion($DatosCotizacion['cotizacion_Id']);
                                }
                            ?>
                        </li>
                        <?php
                        if ($DatosCotizacion['cotizacion_Anulada'] == "SI") {?>
                            <ul>
                                <li>
                                    <td class="datos_fijos">MOTIVO ANULACIÓN: <?php echo $DatosCotizacion['cotizacion_MotivoAnulacion']; ?></td>
                                </li>
                            </ul>
                        <?php
                        }?>
                        <li>AÑO: <?php echo $DatosCotizacion['cotizacion_Año']; ?></li>
                        <li>MES: <?php echo $DatosCotizacion['cotizacion_Mes']; ?></li>
                        <li>DÍA: <?php echo $DatosCotizacion['cotizacion_Dia']; ?></li>
                        <li>VALIDEZ OFERTA: <?php echo date("Y-m-d",strtotime(date($DatosCotizacion['cotizacion_Fecha'])."+ 15 days")); ?></li>
                        <li>OBSERVACIONES: <?php echo $DatosCotizacion['cotizacion_Observaciones']; ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Datos del cliente</p>
                        <li>NIT: <?php echo number_format($DatosCotizacion['cotizacion_NitTercero']); ?></li>
                        <li>DV: <?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Dv']; ?></li>
                        <li>RAZON SOCIAL: <?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_RazonSocial']; ?></li>
                        <li>TELEFONO: <?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Telefono1'] ?></li>
                        <li>EMAIL: <?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Email']; ?></li>
                        <li>CIUDAD: <?php echo nombreDepartamento(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Ciudad']); ?></li>
                        <li>DIRECCIÓN: <?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Direccion']; ?></li>
                        <li>FORMA DE PAGO: <?php echo nombre_FormaPago(datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_FormaPago']); ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Datos de entrega</p>
                        <li>CONTACTO: ING. <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Contacto']; ?></li>
                        <li>TELEFONO: <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Telefono1']; ?></li>
                        <li>TIEMPO DE ENTREGA: <?php echo $DatosCotizacion['cotizacion_TiempoEntrega']." DÍAS HABILES DESPÚES DE O.C."; ?></li>
                        <li>CIUDAD DE ENTREGA: <?php echo nombreDepartamento(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Ciudad']); ?></li>
                        <li>DIRECCIÓN DE ENTREGA: <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Direccion']; ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Productos</p>
                        <?php 
                        for ($j = 0; $j < count($Datos_ItemsCotizacion); $j += 4) {?>
                            <li>Item #<?php echo ($j/4+1); ?></li>
                            <ul>
                                <li colspan="3">Detalle: <?php echo $Datos_ItemsCotizacion[$j]; ?></li>
                                <li>Cantidad: <?php echo $Datos_ItemsCotizacion[$j+1]; ?></li>
                                <li colspan="2">Valor unitario: $ <?php echo number_format($Datos_ItemsCotizacion[$j+2]); ?></li>
                                <li colspan="2">Valor total: $ <?php echo number_format($Datos_ItemsCotizacion[$j+3]); ?></li>
                            </ul>
                            <?php
                        }?>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Datos de facturación</p>
                        <li>Subtotal factura: $ <?php echo number_format($DatosCotizacion['cotizacion_Subtotal']); ?></li>
                        <li>Porcentaje descuento: <?php echo number_format(round($DatosCotizacion['cotizacion_PorcentajeDescuento'])); ?>%</li>
                        <li>Valor descuento: $ <?php echo number_format(round($DatosCotizacion['cotizacion_ValorDescuento'])); ?></li>
                        <li>Valor IVA 19%: $ <?php echo number_format(round($DatosCotizacion['cotizacion_ValorIVA'])); ?></li>
                        <li>Total factura: $ <?php echo number_format(round($DatosCotizacion['cotizacion_ValorTotal'])); ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Vendedor</p>
                        <li>Nombre: ING. <?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Apellido']; ?></li>
                        <li>Telefono: <?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Celular']; ?></li>
                    </ul>
                </div>
                <?php
                    if ($DatosCotizacion['cotizacion_Anulada'] != "SI") {?>
                        <form name="form" class="form_Style" method="post" action="../GenerarPDF/Cotizacion.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&cot=<?php echo $DatosCotizacion['cotizacion_Id']; ?>">
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