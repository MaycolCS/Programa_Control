<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(13,16,23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "ERREM") {
            ?><script>alert("La remisión no se pudo guardar. Intentelo nuevamente")</script><?php
        }
    }

    $datosUsuario = datosUsuario($Documento);

    $PPes = listaPlanillasProduccionIncompletas();
    $cant_PPes = count($PPes);
    $aux_cant_PPes = 0;
    if ($cant_PPes == 0) {
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=LSPPR");
        exit();
    }

    $IdPP = "";
    if (isset($_POST['PP'])) {
        $IdPP = $_POST['PP'];
    } elseif (isset($_GET['PP'])) {
        $IdPP = $_GET['PP'];
    }

    $OrdenCompra = "";
    if (isset($_POST['OC'])) {
        $OrdenCompra = $_POST['OC'];
    }

    $PlantaTercero = 0;
    if (isset($_POST['PTercero'])) {
        $PlantaTercero = $_POST['PTercero'];
    }

    if ($IdPP != "") {
        if (!estaPlanillaProduccion($IdPP)) {
            ?><script>alert("La planilla de producción no se encuentra registrada")</script><?php
            $IdPP = "";
        } elseif (!estaDisponiblePlanillaProduccion($IdPP)) {
            ?><script>alert("La planilla de producción <?php echo ($IdPP);?> se encuentra anulada o ya esta remisionada en su totalidad, por este motivo no puede ser usada.")</script><?php
            $IdPP = "";
        } else {
            $DatosPlanillaProduccion = datosPlanillaProduccion($IdPP);
            if (!tienePlantasTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])) {
                ?><script>alert("El tercero no tiene plantas registradas, diríjase al módulo de terceros y registre la planta")</script><?php
                $IdPP = "";
            } else {
                $PlantasTerceros = listaPlantaTerceros($DatosPlanillaProduccion['planilla_produccion_NitTercero']);
                $PlantaTercero = $DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'];
                $DatosPlantaTercero = datosPlantaTercero($PlantaTercero);
            }
        }
    }

    if ($IdPP != "" and $PlantaTercero != 0 and $OrdenCompra != "") {
        $DatosPlanillaProduccion = datosPlanillaProduccion($IdPP);
        $Datos_ItemsPlanillaProduccion = itemsPlanilla($IdPP);
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
            if ($IdPP=="") {?>
                <form class="form_Style" method="post" action="IngresarRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&PP=<?php echo $IdPP; ?>">
                    <p class="txt_Titulo">Ingresar remisión</p>
                    <div>
                        <label>P. Producción:</label>
                        <input list="listaPlanillaProduccion" name="PP" id="PP" autocomplete="off" required/>
                        <datalist id="listaPlanillaProduccion">
                            <?php
                            for ($i = 0; $i < count($PPes); $i += 2) {?>
                                <option value="<?php echo $PPes[$i] ;?>"><?php echo $PPes[$i+1] ;?></option>
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
            } elseif ($PlantaTercero == 0 or $OrdenCompra == "") {?>
                <form class="form_Style" method="post" action="IngresarRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&PP=<?php echo $IdPP; ?>">
                    <p class="txt_Titulo">Ingresar remisión</p>
                    <div>
                        <label>Planta:</label>
                        <select name="PTercero" id="PTercero" required/>
                            <?php
                            if ($PlantaTercero != 0) {?>
                                <option value="<?php echo $PlantaTercero;?>"><?php echo nombreDepartamento($DatosPlantaTercero[3]);?>, <?php echo nombreCiudad($DatosPlantaTercero[4]);?>, <?php echo $DatosPlantaTercero[5];?></option>
                            <?php
                            } else {?>
                                <option></option>
                            <?php
                            }
                            for ($k = 0; $k < count($PlantasTerceros); $k += 4) {
                                if ($PlantaTercero != $PlantasTerceros[$k]) {?>
                                    <option value="<?php echo $PlantasTerceros[$k] ;?>"><?php echo nombreDepartamento($PlantasTerceros[$k+2]) ;?>, <?php echo nombreCiudad($PlantasTerceros[$k+1]) ;?>, <?php echo $PlantasTerceros[$k+3] ;?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label>O. Compra:</label>
                        <input type="text" name="OC" id="OC" placeholder="Orden de compra" autocomplete="off" required/>
                    </div> 
                    <div class="Boton_Style">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
            <?php
            } else {?>
                <div id="tabla_vistaEscritorio">
                    <form class="form_Tabla" method="post" action="IngresarRemisionDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&PP=<?php echo $IdPP; ?>&PLTR=<?php echo $PlantaTercero; ?>&OC=<?php echo $OrdenCompra; ?>">
                        <table class="tabla_encabezado">
                            <?php
                                include '../Static/encabezadoTablas.html';
                            ?>
                            <script type="text/javascript">
                                $("#emailEmpresa").text("<?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Correo'];?>");
                                $("#telefonoEmpresa").text("<?php echo "TEL: ".datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Celular'];?>");
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
                                <td class="datos_fijos_inicial" rowspan="2">PLANILLA PRODUCCIÓN</td>
                                <td class="datos_fijos" rowspan="2"><?php echo $DatosPlanillaProduccion['planilla_produccion_Id']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_variables"><?php echo $DatosPlanillaProduccion['planilla_produccion_Año']; ?></td>
                                <td class="datos_variables"><?php echo $DatosPlanillaProduccion['planilla_produccion_Mes']; ?></td>
                                <td class="datos_variables"><?php echo $DatosPlanillaProduccion['planilla_produccion_Dia']; ?></td>
                            </tr>
                            <tr>
                                <td class="espacio" colspan="7"></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">NIT</td>
                                <td class="datos_variables" colspan="2"><?php echo $DatosPlanillaProduccion['planilla_produccion_NitTercero']; ?></td>
                                <td class="datos_fijos">DV</td>
                                <td class="datos_variables"><?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Dv']; ?></td>
                                <td class="datos_fijos">COTIZACIÓN</td>
                                <td class="datos_variables"><?php echo $DatosPlanillaProduccion['planilla_produccion_Cotizacion']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">RAZON SOCIAL</td>
                                <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_RazonSocial']; ?></td>
                                <td class="datos_fijos">CONTACTO</td>
                                <td class="datos_variables">ING. <?php echo datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Contacto']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">TELEFONO</td>
                                <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Telefono1']; ?></td>
                                <td class="datos_fijos">TELEFONO</td>
                                <td class="datos_variables"><?php echo datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Telefono1']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">EMAIL</td>
                                <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Email']; ?></td>
                                <td class="datos_fijos">TIEMPO DE ENTREGA</td>
                                <td class="datos_variables"><?php echo $DatosPlanillaProduccion['planilla_produccion_TiempoEntrega']." DÍAS HABILES DESPÚES DE O.C."; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos">CIUDAD DE ENTREGA</td>
                                <td class="datos_variables" colspan="4"><?php echo nombreDepartamento(datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Ciudad']); ?></td>
                                <td class="datos_fijos">DIRECCIÓN DE ENTREGA</td>
                                <td class="datos_variables"><?php echo datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Direccion']; ?></td>
                            </tr>
                        </table>

                        <table class="tabla_items">
                            <tr>
                                <th>Item</th>
                                <th colspan="3">Detalle</th>
                                <th>Cantidad</th>
                            </tr>
                            <?php 
                            for ($i = 0; $i < count($Datos_ItemsPlanillaProduccion); $i += 4) {
                                $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_Id'], $Datos_ItemsPlanillaProduccion[$i], $Datos_ItemsPlanillaProduccion[$i+2]);
                                $CantidadDisponibleItem = $Datos_ItemsPlanillaProduccion[$i+1] - $CantidadRemisionadaItem;
                                if ($CantidadDisponibleItem > 0) {?>
                                    <tr>
                                        <td><input type="checkbox" name="item<?php echo ($i/4+1); ?>" value="<?php echo ($i/4+1);?>"></td>
                                        <td colspan="3"><?php echo $Datos_ItemsPlanillaProduccion[$i]; ?></td>
                                        <td><input type="number" name="cantidad<?php echo ($i/4+1); ?>" value="<?php echo $CantidadDisponibleItem;?>" min="1" max="<?php echo $CantidadDisponibleItem;?>" required/></td>
                                    </tr>
                                <?php
                                }
                            }?>
                        </table>

                        <table class="tabla_footer">
                            <tr>
                                <td class="datos_variables_firma" rowspan="2"></td>
                                <td class="datos_fijos" colspan="5">OBSERVACIONES PLANILLA</td>
                            </tr>
                            <tr>
                                <td class="datos_variables" colspan="5" rowspan="3"></td>
                            </tr>
                            <tr>
                                <td class="datos_variables"><?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Apellido']; ?></td>
                            </tr>
                            <tr>
                                <td class="datos_variables">TEL: <?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Celular']; ?></td>
                            </tr>
                            <tr>
                                <td class="espacio" colspan="6"></td>
                            </tr>
                            <tr>
                                <td class="datos_fijos" colspan="1">Observaciones remisión</td>
                                <td class="datos_variables" colspan="5">
                                    <textarea type="text" name="Observaciones" id="Observaciones" autocomplete="off"></textarea>
                                </td>
                            </tr>
                        </table>
                        <div class="Boton_Style">
                            <button type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
                <div id="lista_WR">
                    <form class="form_Tabla" method="post" action="IngresarRemisionDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&PP=<?php echo $IdPP; ?>&PLTR=<?php echo $PlantaTercero; ?>&OC=<?php echo $OrdenCompra; ?>">
                        <ul>
                            <p class="txt_Subtitulo">PLANILLA PRODUCCIÓN <?php echo $DatosPlanillaProduccion['planilla_produccion_Id']; ?></p>
                            <li>AÑO: <?php echo $DatosPlanillaProduccion['planilla_produccion_Año']; ?></li>
                            <li>MES: <?php echo $DatosPlanillaProduccion['planilla_produccion_Mes']; ?></li>
                            <li>DÍA: <?php echo $DatosPlanillaProduccion['planilla_produccion_Dia']; ?></li>
                            <li>COTIZACIÓN: <?php echo $DatosPlanillaProduccion['planilla_produccion_Cotizacion']; ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Datos del cliente</p>
                            <li>NIT: <?php echo $DatosPlanillaProduccion['planilla_produccion_NitTercero']; ?></li>
                            <li>DV: <?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Dv']; ?></li>
                            <li>RAZON SOCIAL: <?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_RazonSocial']; ?></li>
                            <li>TELEFONO: <?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Telefono1']; ?></li>
                            <li>EMAIL: <?php echo datosTercero($DatosPlanillaProduccion['planilla_produccion_NitTercero'])['tercero_Email']; ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Datos de entrega</p>
                            <li>CONTACTO: ING. <?php echo datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Contacto']; ?></li>
                            <li>TELEFONO: <?php echo datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Telefono1']; ?></li>
                            <li>TIEMPO DE ENTREGA: <?php echo $DatosPlanillaProduccion['planilla_produccion_TiempoEntrega']." DÍAS HABILES DESPÚES DE O.C."; ?></li>
                            <li>CIUDAD DE ENTREGA: <?php echo nombreDepartamento(datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Ciudad']); ?></li>
                            <li>DIRECCIÓN DE ENTREGA: <?php echo datosPlantaTercero($DatosPlanillaProduccion['planilla_produccion_PlantaEntrega'])['planta_tercero_Direccion']; ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Productos</p>
                            <?php 
                            for ($i = 0; $i < count($Datos_ItemsPlanillaProduccion); $i += 4) {
                                $CantidadRemisionadaItem = saberCantidadItemRemisionado($DatosPlanillaProduccion['planilla_produccion_Id'], $Datos_ItemsPlanillaProduccion[$i], $Datos_ItemsPlanillaProduccion[$i+2]);
                                $CantidadDisponibleItem = $Datos_ItemsPlanillaProduccion[$i+1] - $CantidadRemisionadaItem;
                                if ($CantidadDisponibleItem > 0) {?>
                                    <li>Item # <?php echo ($i/4+1); ?><input type="checkbox" name="item<?php echo ($i/4+1); ?>" value="<?php echo ($i/4+1);?>"></li>
                                    <ul>
                                        <li colspan="3">Detalle: <?php echo $Datos_ItemsPlanillaProduccion[$i]; ?></li>
                                        <li>Cantidad: <input type="number" name="cantidad<?php echo ($i/4+1); ?>" value="<?php echo $CantidadDisponibleItem;?>" min="1" max="<?php echo $CantidadDisponibleItem;?>" required/></li>
                                    </ul>
                                <?php
                                }
                            }?>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Vendedor</p>
                            <li>Nombre: <?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Apellido']; ?></li>
                            <li>Telefono: <?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Celular']; ?></li>
                        </ul>
                        <div>
                            <label>Observaciones:</label>
                            <textarea type="text" name="Observaciones" id="Observaciones" autocomplete="off"></textarea>
                        </div>
                        <div class="Boton_Style">
                            <button type="submit">Guardar</button>
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