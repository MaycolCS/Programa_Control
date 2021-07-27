<?php
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if($Mensaje=="ESPP") {
            echo '<script>alert("¡La planilla de producción no se encuentra registrada!")</script>';
        }  
    }

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(22,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $PlanillasProduccion = listaPlanillasProduccionIncompletas();
    if (count($PlanillasProduccion) == 0) {
        header("Location: ../MainPage.php? cc=$Documento&cs=$CS&msj=LSPPA");
        exit();
    }

    $IdPlanillaProduccion = "";
    if (isset($_POST['PlanillaProduccion'])) {
        $IdPlanillaProduccion = $_POST['PlanillaProduccion'];
        if (!estaPlanillaProduccion($IdPlanillaProduccion)) {
            $IdPlanillaProduccion = "";
            echo '<script>alert("¡La planilla de producción no se encuentra registrada!")</script>';
        } elseif(estaAnuladaPlanillaProduccion($IdPlanillaProduccion)) {
            $IdPlanillaProduccion = "";
            echo '<script>alert("¡La planilla de producción ya se encuentra anulada!")</script>';
        } elseif (PlanillaProduccionTieneRemision($IdPlanillaProduccion)) {
            $IdPlanillaProduccion = "";
            echo '<script>alert("¡La planilla de producción tiene una remision asignada, por este motivo no puede ser anulada!")</script>';
        } else {
            $DatosPlanillaProduccion = datosPlanillaProduccion($IdPlanillaProduccion);
            $Datos_ItemsPlanillaProduccion = itemsPlanilla($IdPlanillaProduccion);
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
            if ($IdPlanillaProduccion=="") {?>
                <form class="form_Style" method="post" action="AnularPP.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Anular planilla producción</p>
                    <div>
                        <label>P. Producción:</label>
                        <input list="listaPlanillaProduccion" name="PlanillaProduccion" id="PlanillaProduccion" autocomplete="off" required/>
                        <datalist id="listaPlanillaProduccion">
                            <?php
                            for ($i = 0; $i < count($PlanillasProduccion); $i += 2) {?>
                                <option value="<?php echo $PlanillasProduccion[$i] ;?>"><?php echo $PlanillasProduccion[$i+1] ;?></option>
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
                            <td class="datos_variables" colspan="2"><?php echo number_format($DatosPlanillaProduccion['planilla_produccion_NitTercero']); ?></td>
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
                        for ($i = 0; $i < count($Datos_ItemsPlanillaProduccion); $i += 4) {?>
                            <tr>
                                <td><?php echo ($i/4+1); ?></td>
                                <td colspan="3"><?php echo $Datos_ItemsPlanillaProduccion[$i]; ?></td>
                                <td><?php echo $Datos_ItemsPlanillaProduccion[$i+1]; ?></td>
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
                            <td class="datos_variables"><?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Apellido']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables">TEL: <?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Celular']; ?></td>
                        </tr>
                    </table>
                </div>

                <div id="lista_WR">
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
                        for ($i = 0; $i < count($Datos_ItemsPlanillaProduccion); $i += 4) {?>
                            <li>Item # <?php echo ($i/4+1); ?></li>
                            <ul>
                                <li colspan="3">Detalle: <?php echo $Datos_ItemsPlanillaProduccion[$i]; ?></li>
                                <li>Cantidad: <?php echo $Datos_ItemsPlanillaProduccion[$i+1]; ?></li>
                            </ul>
                        <?php
                        }?>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Vendedor</p>
                        <li>Nombre: <?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Apellido']; ?></li>
                        <li>Telefono: <?php echo datosUsuario($DatosPlanillaProduccion['planilla_produccion_Vendedor'])['usuario_Celular']; ?></li>
                    </ul>
                </div>
                <div class="div_Style"></div>
                <?php
                    if ($DatosPlanillaProduccion['planilla_produccion_Anulada'] != "SI") {?>
                        <form name="form" class="form_Style" method="post" action="AnularPPDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&pp=<?php echo $DatosPlanillaProduccion['planilla_produccion_Id']; ?>">
                            <p class="txt_Titulo">Anular planilla producción</p>
                            <div>
                                <label>Motivo:</label>
                                <textarea type="text" name="MotivoAnulacion" id="MotivoAnulacion" autocomplete="off" required></textarea>
                            </div>
                            <div>
                                <button type="submit">Anular</button>
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