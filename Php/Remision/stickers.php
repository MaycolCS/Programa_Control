<?php

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

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "ESIS") {
            echo '<script>alert("¡Debe seleccionar al menos un item!")</script>';
        }       
    }

    $datosUsuario = datosUsuario($Documento);

    $ListaRemisiones = listaRemisiones();

    $IdRemision = "";
    if (isset($_POST['Remision'])) {
        $IdRemision = $_POST['Remision'];
        if (!estaRemision($IdRemision)) {
            ?><script>alert("La remisión no se encuentra registrada")</script><?php
            $IdRemision = "";
        }
    } elseif (isset($_GET['Remision'])) {
        $IdRemision = $_GET['Remision'];
    }

    $DatosRemision = datosRemision($IdRemision);
    $DatosRemision_Items = itemsRemision($IdRemision);

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
                <form class="form_Style" method="post" action="stickers? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&Remision=<?php echo $IdRemision; ?>">
                    <p class="txt_Titulo">Generar stickers</p>
                    <div>
                        <label>Remisión:</label>
                        <input list="listaRemisiones" name="Remision" id="Remision" autocomplete="off" required/>
                        <datalist id="listaRemisiones">
                            <?php
                            for ($i = 0; $i < count($ListaRemisiones); $i += 2) {
                                if (!estaAnuladaRemision($ListaRemisiones[$i])) {?>
                                    <option value="<?php echo $ListaRemisiones[$i] ;?>"><?php echo $ListaRemisiones[$i+1] ;?></option>
                                <?php
                                }
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
                    <form class="form_Tabla" method="post" action="../GenerarPDF/stickers.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&Remision=<?php echo $IdRemision; ?>">
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
                                <th>Detalle item</th>
                                <th>Cantidad item</th>
                                <th>Cantidad stickers</th>
                            </tr>
                            <?php 
                            for ($i = 0; $i < count($DatosRemision_Items); $i += 4) {?>
                                <tr>
                                    <td><input type="checkbox" name="item<?php echo ($i/4+1); ?>" id="item<?php echo ($i/4+1); ?>" value="<?php echo ($i/4+1);?>"/></td>
                                    <td><?php echo $DatosRemision_Items[$i]; ?></td>
                                    <td><?php echo $DatosRemision_Items[$i+1];?></td>
                                    <td><input type="number" name="cantidad<?php echo ($i/4+1); ?>" id="cantidad<?php echo ($i/4+1); ?>" min="1"/></td>
                                </tr>
                            <?php
                            }?>
                        </table>

                        <div class="Boton_Style">
                            <button type="submit">Generar</button>
                        </div>
                    </form>
                </div>
                <div id="lista_WR">
                    <form class="form_Tabla" method="post" action="../GenerarPDF/stickers.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&Remision=<?php echo $IdRemision; ?>">
                        <ul>
                            <p class="txt_Subtitulo">REMISIÓN <?php echo $DatosRemision['remision_Id']; ?></p>
                            <li>AÑO: <?php echo $DatosRemision['remision_Año']; ?></li>
                            <li>MES: <?php echo $DatosRemision['remision_Mes']; ?></li>
                            <li>DÍA: <?php echo $DatosRemision['remision_Dia']; ?></li>
                            <li>PLANILLA PRODUCCIÓN: <?php echo $DatosRemision['remision_PlanillaProduccion']; ?></li>
                            <li>COTIZACIÓN: <?php echo PlanillaProduccion_IdCotizacion($DatosRemision['remision_PlanillaProduccion']); ?></li>
                            <li>OBSERVACIONES: <?php echo $DatosRemision['remision_Observaciones']; ?></li>
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
                        <ul>
                            <?php
                            for ($i = 0; $i < count($DatosRemision_Items); $i += 4) {?>
                                <div class="div_Style"></div>
                                <li>Item # <?php echo ($i/4+1); ?><input type="checkbox" name="item<?php echo ($i/4+1); ?>" id="item<?php echo ($i/4+1); ?>" value="<?php echo ($i/4+1);?>"/></li>
                                <ul>
                                    <li>Detalle item: <?php echo $DatosRemision_Items[$i]; ?></li>
                                    <li>Cantidad item: <?php echo $DatosRemision_Items[$i+1];?></li>
                                    <li>Cantidad stickers: <input type="number" name="cantidad<?php echo ($i/4+1); ?>" id="cantidad<?php echo ($i/4+1); ?>" min="1"/></li>
                                </ul>
                            <?php
                            }?>
                        </ul>
                        <div class="div_Style"></div>
                        <div class="Boton_Style">
                            <button type="submit">Generar</button>
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