<?php

    include '../Funciones.php';

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

    /* Aqui empieza el código */

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "PEC") {
            echo '<script>alert("¡El producto ya se encuentra añadido a la cotización!")</script>';
        } elseif ($Mensaje == "PAC") {
            echo '<script>alert("¡El producto se añadio a la cotización!")</script>';
        } elseif ($Mensaje == "EAPC") {
            echo '<script>alert("¡El producto no se añadio a la cotización. Intentelo nuevamente!")</script>';
        } elseif ($Mensaje == "ESITEMCOT") {
            echo '<script>alert("¡Recuerde seleccionar al menos un item de la cotización!")</script>';
        }
    }

    $datosUsuario = datosUsuario($Documento);

    $Cotizaciones = listaCotizaciones_SinFacturar();
    $cant_Cotizaciones = count($Cotizaciones);
    $aux_cant_Cotizaciones = 0;
    if ($cant_Cotizaciones == 0) {
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=LSCPP");
        exit();
    }

    $IdCotizacion = "";
    if (isset($_POST['Cotizacion']) or isset($_GET['cot'])) {
        if (isset($_POST['Cotizacion'])) {
            $IdCotizacion = $_POST['Cotizacion'];
        }
        elseif (isset($_GET['cot'])) {
            $IdCotizacion = $_GET['cot'];
        }

        if (!estaCotizacion($IdCotizacion)) {
            $IdCotizacion = "";
            echo '<script>alert("¡La cotización no se encuentra registrada!")</script>';
        } elseif (Cotizacion_Anulada($IdCotizacion)) {
            ?><script>alert("La cotización <?php echo ($IdCotizacion);?> se encuentra anulada, por este motivo no puede ser usada.")</script><?php
            $IdCotizacion = "";
        } elseif (Cotizacion_Facturada($IdCotizacion)) {
            ?><script>alert("La cotización <?php echo ($IdCotizacion);?> ya se encuentra facturada, por este motivo no puede ser usada.")</script><?php
            $IdCotizacion = "";
        } elseif (!cotizacion_DisponibleFecha($IdCotizacion)) {
            ?><script>alert("La cotización <?php echo ($IdCotizacion);?> ya paso el periodo de validez de la oferta, por este motivo no puede ser usada.")</script><?php
            $IdCotizacion = "";
        } else {
            $DatosCotizacion = datosCotizacion($IdCotizacion);
            $Datos_ItemsCotizacion = itemsCotizacion($IdCotizacion);
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
            if ($IdCotizacion=="") {?>
                <form class="form_Style" method="post" action="IngresarPP.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Ingresar planilla de producción</p>
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
                    <form class="form_Tabla" method="post" action="IngresarPPDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&cot=<?php echo $IdCotizacion; ?>">
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
                                <td class="datos_variables" colspan="2"><?php echo $DatosCotizacion['cotizacion_NitTercero']; ?></td>
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
                            </tr>
                            <?php 
                            for ($i = 0; $i < count($Datos_ItemsCotizacion); $i += 4) {?>
                                <tr>
                                    <td><input type="checkbox" name="item<?php echo ($i/4+1); ?>" value="<?php echo ($i/4+1); ?>"/></td>
                                    <td colspan="3"><?php echo $Datos_ItemsCotizacion[$i]; ?></td>
                                    <td><input type="number" name="cantidad<?php echo ($i/4+1); ?>" placeholder="Cantidad" value="<?php echo $Datos_ItemsCotizacion[$i+1]; ?>" min="1" autocomplete="off" required/></td>
                                    <td colspan="2">$ <?php echo number_format($Datos_ItemsCotizacion[$i+2]); ?></td>
                                </tr>
                            <?php
                            }?>
                            <tr>
                                <td class="espacio" colspan="7"></td>
                            </tr>
                            <tr>
                                <th colspan="1">Observaciones planilla producción</th>
                                <td colspan="6">
                                    <textarea type="text" name="Observaciones" id="Observaciones" autocomplete="off"></textarea>
                                </td>
                            </tr>
                        </table>
                        <div class="Boton_Style">
                            <button type="submit">Guardar PP</button>
                        </div>
                    </form>
                </div>

                <div id="lista_WR">
                    <form class="form_Tabla" method="post" action="IngresarPPDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&cot=<?php echo $IdCotizacion; ?>">
                        <ul>
                            <p class="txt_Subtitulo">Cotización <?php echo $DatosCotizacion['cotizacion_Id']; ?></p>
                            <li>AÑO: <?php echo $DatosCotizacion['cotizacion_Año']; ?></li>
                            <li>MES: <?php echo $DatosCotizacion['cotizacion_Mes']; ?></li>
                            <li>DÍA: <?php echo $DatosCotizacion['cotizacion_Dia']; ?></li>
                            <li>VALIDEZ OFERTA: <?php echo date("Y-m-d",strtotime(date($DatosCotizacion['cotizacion_Fecha'])."+ 15 days")); ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Datos del cliente</p>
                            <li>NIT: <?php echo $DatosCotizacion['cotizacion_NitTercero']; ?></li>
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
                            <li>TIEMPO DE ENTREGA: <?php echo $DatosCotizacion['cotizacion_TiempoEntrega']." DÍAS HABILES DESPÚES DE O.C."; ?></li>
                            <li>CIUDAD DE ENTREGA: <?php echo nombreDepartamento(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Ciudad']); ?></li>
                            <li>DIRECCIÓN DE ENTREGA: <?php echo datosPlantaTercero($DatosCotizacion['cotizacion_PlantaEntrega'])['planta_tercero_Direccion']; ?></li>
                        </ul>
                        <div class="div_Style"></div>
                        <ul>
                            <p class="txt_Normal">Productos</p>
                            <?php 
                            for ($i = 0; $i < count($Datos_ItemsCotizacion); $i += 4) {?>
                                <li>Item # <?php echo ($i/4+1); ?><input type="checkbox" name="item<?php echo ($i/4+1); ?>" value="<?php echo ($i/4+1); ?>"/></li>
                                <ul>
                                    <li colspan="3">Detalle: <?php echo $Datos_ItemsCotizacion[$i]; ?></li>
                                    <li>Cantidad: <input type="number" name="cantidad<?php echo ($i/4+1); ?>" placeholder="Cantidad" value="<?php echo $Datos_ItemsCotizacion[$i+1]; ?>" min="1" autocomplete="off" required/></li>
                                    <li colspan="2">Valor unitario: $ <?php echo number_format($Datos_ItemsCotizacion[$i+2]); ?></li>
                                </ul>
                            <?php
                            }?>
                        </ul>
                        <div class="div_Style"></div>
                        <div>
                            <label>Observaciones:</label>
                            <textarea type="text" name="Observaciones" id="Observaciones" autocomplete="off"></textarea>
                        </div>
                        <div class="Boton_Style">
                            <button type="submit">Guardar PP</button>
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