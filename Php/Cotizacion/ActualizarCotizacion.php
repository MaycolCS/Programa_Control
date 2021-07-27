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
    }

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $Tercero=0;

    $Cotizaciones = listaCotizaciones_SinPlanillaProduccion($Tercero);

    $IdCotizacion = "";
    if (isset($_POST['Cotizacion'])) {
        $IdCotizacion = $_POST['Cotizacion'];
        if (!estaCotizacion($IdCotizacion)) {
            echo '<script>alert("¡La cotización no se encuentra registrada!")</script>';
            $IdCotizacion = "";
        }
    }

    $DatosCotizacion = datosCotizacion($IdCotizacion);
    $Datos_ItemsCotizacion = itemsCotizacion($IdCotizacion);

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
            if ($IdCotizacion=="") {?>
                <form class="form_Style" method="post" action="ActualizarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&cs=<?php echo $CS; ?>&NT=<?php echo $Tercero; ?>">
                    <p class="txt_Titulo">Actualizar cotización</p>
                    <div>
                        <label>Cotización:</label>
                        <input list="listaCotizaciones" name="Cotizacion" id="Cotizacion" autocomplete="off" required/>
                        <datalist id="listaCotizaciones">
                            <?php
                            for ($i = 0; $i < count($Cotizaciones); $i += 2) {?>
                                <option value="<?php echo $Cotizaciones[$i] ;?>"><?php echo $Cotizaciones[$i+1] ;?></option>
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
                    <form class="form_Tabla" method="post" action="ActualizarCotizacionDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&cot=<?php echo $IdCotizacion; ?>">
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
                                <td class="datos_variables"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_FormaPago']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">EMAIL</td>
                                <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_Email']; ?></td>
                                <td class="datos_fijos">TIEMPO DE ENTREGA</td>
                                <td class="datos_variables"><input type="number" name="tiempoEntrega" id="tiempoEntrega" value="<?php echo $DatosCotizacion['cotizacion_TiempoEntrega']; ?>" required/> DÍAS HABILES DESPÚES DE O.C.</td>
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
                                    <td><input type="text" name="CantItem<?php echo ($i/4+1); ?>" id="CantItem<?php echo ($i/4+1); ?>" value="<?php echo number_format($Datos_ItemsCotizacion[$i+1]); ?>" onchange="cambiarDatosCotizacion()" required/></td>
                                    <td colspan="2">$ <input type="text" name="PreItem<?php echo ($i/4+1); ?>" id="PreItem<?php echo ($i/4+1); ?>" value="<?php echo number_format($Datos_ItemsCotizacion[$i+2]); ?>" onchange="cambiarDatosCotizacion()" required/></td>
                                    <td colspan="2">$ <span id="valor_total_Item<?php echo ($i/4+1); ?>"><?php echo number_format($Datos_ItemsCotizacion[$i+3]); ?></span></td>
                                </tr>
                                <?php
                            }?>
                        </table>

                        <table class="tabla_footer">
                            <tr>
                                <td class="datos_variables_firma" colspan="2" rowspan="4"></td>
                                <td class="datos_fijos" colspan="3">OBSERVACIONES</td>
                                <td class="datos_fijos" colspan="2">SUBTOTAL</td>
                                <td class="datos_variables" colspan="2">$ <span id="valor_subtotal"><?php echo number_format($DatosCotizacion['cotizacion_Subtotal']); ?></span></td>
                            </tr>
                            <tr>
                                <td class="datos_variables" colspan="3" rowspan="4">
                                    El valor total debe ser consignado en la cuenta de ahorros del banco caja social No 24 098 446 818. 
                                    <textarea type="text" name="Observaciones" id="Observaciones" autocomplete="off"><?php echo $DatosCotizacion['cotizacion_Observaciones']; ?></textarea>
                                </td>
                                <td class="datos_fijos">DCTO</td>
                                <td class="datos_fijos"><span id="valor_porcentajedescuento"><?php echo number_format($DatosCotizacion['cotizacion_PorcentajeDescuento']); ?></span>%</td>
                                <td class="datos_variables" colspan="2">$ <span id="valor_descuento"><?php echo number_format(round($DatosCotizacion['cotizacion_ValorDescuento'])); ?></span></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos" colspan="2">IVA 19%</td>
                                <td class="datos_variables" colspan="2">$ <span id="valor_iva"><?php echo number_format(round($DatosCotizacion['cotizacion_ValorIVA'])); ?></span></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos" rowspan="2" colspan="2">TOTAL A PAGAR</td>
                                <td class="datos_variables" rowspan="2" colspan="2">$ <span id="valor_total"><?php echo number_format(round($DatosCotizacion['cotizacion_ValorTotal'])); ?></span></td>
                            </tr>
                            <tr>
                                <td class="datos_variables" colspan="2" rowspan="2"><?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Apellido']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos" colspan="7">VALOR EN LETRAS</td>
                            </tr>
                            <tr>
                                <td class="datos_variables" colspan="2">TEL: <?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Celular']; ?></td>
                                <td class="datos_variables" colspan="7"></td>
                            </tr>
                        </table>
                        <div class="Boton_Style">
                            <button type="submit">Actualizar</button>
                        </div>
                    </form>
                </div>

                <div id="lista_WR">
                    <form class="form_Tabla" method="post" action="ActualizarCotizacionDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&cot=<?php echo $IdCotizacion; ?>">
                        <ul>
                            <p class="txt_Subtitulo">Cotización <?php echo $DatosCotizacion['cotizacion_Id']; ?></p>
                            <li>
                                <?php
                                    if ($DatosCotizacion['cotizacion_Anulada'] == "SI") {
                                        echo "COTIZACIÓN ANULADA";
                                    } elseif ($DatosCotizacion['cotizacion_PlanillaProduccion'] == NULL) {
                                        echo "Cotización sin planilla de trabajo";
                                    } else {
                                        echo "Cotización con planilla de trabajo ".$DatosCotizacion['cotizacion_PlanillaProduccion'];
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
                            <li>OBSERVACIONES: <textarea type="text" name="Observaciones" id="Observaciones" autocomplete="off"><?php echo $DatosCotizacion['cotizacion_Observaciones']; ?></textarea></li>
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
                            <li>FORMA DE PAGO: <?php echo datosTercero($DatosCotizacion['cotizacion_NitTercero'])['tercero_FormaPago']; ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Datos de entrega</p>
                            <li>CONTACTO: ING. <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Contacto']; ?></li>
                            <li>TELEFONO: <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Telefono1']; ?></li>
                            <li>TIEMPO DE ENTREGA: <input type="number" name="tiempoEntrega" id="tiempoEntrega" value="<?php echo $DatosCotizacion['cotizacion_TiempoEntrega']; ?>" required/> DÍAS HABILES DESPÚES DE O.C.</li>
                            <li>CIUDAD DE ENTREGA: <?php echo nombreDepartamento(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Ciudad']); ?></li>
                            <li>DIRECCIÓN DE ENTREGA: <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Direccion']; ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Productos</p>
                            <?php 
                            for ($i = 0; $i < count($Datos_ItemsCotizacion); $i += 4) {?>
                                <li>Item # <?php echo ($i/4+1); ?></li>
                                <ul>
                                    <li>Detalle: <?php echo $Datos_ItemsCotizacion[$i]; ?></li>
                                    <li>Cantidad: <input type="text" name="CantItem<?php echo ($i/4+1); ?>" id="CantItem<?php echo ($i/4+1); ?>" value="<?php echo number_format($Datos_ItemsCotizacion[$i+1]); ?>" onchange="cambiarDatosCotizacion()" required/></li>
                                    <li>Valor unitario: $ <input type="text" name="PreItem<?php echo ($i/4+1); ?>" id="PreItem<?php echo ($i/4+1); ?>" value="<?php echo number_format($Datos_ItemsCotizacion[$i+2]); ?>" onchange="cambiarDatosCotizacion()" required/></li>
                                </ul>
                                <?php
                            }?>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Vendedor</p>
                            <li>Nombre: ING. <?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Apellido']; ?></li>
                            <li>Telefono: <?php echo datosUsuario($DatosCotizacion['cotizacion_Vendedor'])['usuario_Celular']; ?></li>
                        </ul>
                        <div class="Boton_Style">
                            <button type="submit">Actualizar</button>
                        </div>
                    </form>
                </div>
            <?php    
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>