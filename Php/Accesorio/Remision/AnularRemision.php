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
    if (!validarPermisosUsuario($Documento,array(23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $Remisiones = listaRemisionesSinFacturaVenta();
    $cant_Remisiones = count($Remisiones);
    $aux_cant_Remisiones = 0;
    if ($cant_Remisiones == 0) {
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=LSRPA");
        exit();
    }

    $IdRemision = "";
    if (isset($_POST['Remision'])) {
        $IdRemision = $_POST['Remision'];
        if (!estaRemision($IdRemision)) {
            header("Location: ConsultarRemision? cc=$Documento&cs=$CS&msj=ESREM");
            exit();
        } else {
            $DatosRemision = datosRemision($IdRemision);
            $DatosRemision_Items = itemsRemision($IdRemision);
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
            if ($IdRemision=="") {?>
                <form class="form_Style" method="post" action="AnularRemision.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Anular remisión</p>
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

                <?php
                    if ($DatosRemision['remision_Anulada'] != "SI") {?>
                        <form name="form" class="form_Style" method="post" action="AnularRemisionDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&REM=<?php echo $DatosRemision['remision_Id']; ?>">
                            <p class="txt_Titulo">Anular remisión</p>
                            <div>
                                <label>Motivo:</label>
                                <textarea type="text" name="MotivoAnulacion" id="MotivoAnulacion" autocomplete="off" required></textarea>
                            </div>    
                            <div>
                                <button type="submit">Anular remisión</button>
                            </div>
                        </form>
                    <?php
                    }?>
            <?php    
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>