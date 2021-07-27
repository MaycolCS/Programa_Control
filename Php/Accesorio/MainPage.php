<?php

    include 'Funciones.php';
    
    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: Login");
        exit();
    }
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
    }
    
    /* Aqui empieza el código */
    $datosUsuario = datosUsuario($Documento);

    if($Mensaje=="Login") {
        ?><script>alert("Inicio de sesión exitosamente")</script><?php
        if (validarPermisosUsuario($Documento,array(12,16,22,26)) and PlanillasProduccion_ComprobacionFaltantes()) {
            ?><script>alert("Hay planillas que ya cumplieron la fecha de entrega y se encuentran sin remisionar")</script><?php
        }
        if (validarPermisosUsuario($Documento,array(13,16,23,26)) and Remisiones_ComprobacionFaltantes()) {
            ?><script>alert("Hay remisiones que se encuentran sin facturar")</script><?php
        }
    } else if($Mensaje=="ELREM") {
        ?><script>alert("No hay remisiones disponibles para facturar")</script><?php
    } else if($Mensaje=="ORT") {
        ?><script>alert("El tercero se registro correctamente")</script><?php
    } else if($Mensaje=="ERT") {
        ?><script>alert("El tercero no se registro correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="ORU") {
        ?><script>alert("El usuario se registro correctamente")</script><?php
    } else if($Mensaje=="ERU") {
        ?><script>alert("El usuario no se registro correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="ORPT") {
        ?><script>alert("La planta del tercero se registro correctamente")</script><?php
    } else if($Mensaje=="ERPT") {
        ?><script>alert("La planta del tercero no se registro correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="OBT") {
        ?><script>alert("El tercero se borró correctamente")</script><?php
    } else if($Mensaje=="EBT") {
        ?><script>alert("El tercero no se borró correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="OBU") {
        ?><script>alert("El usuario se borró correctamente")</script><?php
    } else if($Mensaje=="EBU") {
        ?><script>alert("El usuario no se borró correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="OBPT") {
        ?><script>alert("La planta del tercero se borró correctamente")</script><?php
    } else if($Mensaje=="EBPT") {
        ?><script>alert("La planta del tercero no se borró correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="OAU") {
        ?><script>alert("El usuario se actualizo correctamente")</script><?php
    } else if($Mensaje=="EAU") {
        ?><script>alert("El usuario no se actualizo correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="OAT") {
        ?><script>alert("El tercero se actualizo correctamente")</script><?php
    } else if($Mensaje=="EAT") {
        ?><script>alert("El tercero no se actualizo correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="OAPT") {
        ?><script>alert("La planta del tercero se actualizo correctamente")</script><?php
    } else if($Mensaje=="EAPT") {
        ?><script>alert("La planta del tercero no se actualizo correctamente, intentelo nuevamente")</script><?php
    } else if($Mensaje=="EPD") {
        ?><script>alert("Usted no tiene permisos para acceder al servicio solicitado")</script><?php
    } else if($Mensaje=="ORCOT") {
        $cotizacion_Id= $_GET['cot'];
        ?><script>alert("Cotización <?php echo $cotizacion_Id;?> guardada correctamente")</script><?php
    } else if($Mensaje=="OACOT") {
        $cotizacion_Id= $_GET['cot'];
        ?><script>alert("Cotización <?php echo $cotizacion_Id;?> anulada correctamente")</script><?php
    } else if($Mensaje=="ORPP") {
        $pp_Id= $_GET['pp'];
        ?><script>alert("Planilla de producción <?php echo $pp_Id;?> guardada correctamente")</script><?php
    } else if($Mensaje=="OAPP") {
        $pp_Id= $_GET['pp'];
        ?><script>alert("Planilla de producción <?php echo $pp_Id;?> anulada correctamente")</script><?php
    } else if($Mensaje=="ORREM") {
        $pp_Id= $_GET['REM'];
        ?><script>alert("Remisión <?php echo $pp_Id;?> guardada correctamente")</script><?php
    } else if($Mensaje=="OAREM") {
        $pp_Id= $_GET['REM'];
        ?><script>alert("Remisión <?php echo $pp_Id;?> anulada correctamente")</script><?php
    } else if($Mensaje=="TNTPR") {
        $pp_Id= $_GET['TR'];
        ?><script>alert("El tercero <?php echo $pp_Id;?> no tiene plantas registradas, para continuar registre una planta.")</script><?php
    } else if($Mensaje=="ORFV") {
        $fv_Id= $_GET['FV'];
        ?><script>alert("Factura de venta <?php echo $fv_Id;?> guardada correctamente")</script><?php
    } else if($Mensaje=="OAFV") {
        $fv_Id= $_GET['FV'];
        ?><script>alert("Factura de venta <?php echo $fv_Id;?> anulada correctamente")</script><?php
    } else if($Mensaje=="ORCC") {
        $cc_Id= $_GET['CentroCosto'];
        ?><script>alert("Centro de costo <?php echo $cc_Id;?> guardado correctamente")</script><?php
    } else if($Mensaje=="OBCC") {
        ?><script>alert("Centro de costo eliminado correctamente")</script><?php
    } else if($Mensaje=="ORLEGCM") {
        $LEG_Id= $_GET['LEG'];
        ?><script>alert("Legalización de caja menor <?php echo $LEG_Id;?> guardada correctamente")</script><?php
    } else if($Mensaje=="OALEGCM") {
        $LEG_Id= $_GET['LEG'];
        ?><script>alert("Legalización de caja menor <?php echo $LEG_Id;?> anulada correctamente")</script><?php
    } else if($Mensaje=="EALEGCM") {
        ?><script>alert("Error al anular legalización de caja menor, intentelo nuevamente")</script><?php
    } else if($Mensaje=="ORLEGCXP") {
        $LEG_Id= $_GET['LEG'];
        ?><script>alert("Legalización de cuenta por pagar <?php echo $LEG_Id;?> guardada correctamente")</script><?php
    } else if($Mensaje=="OALEGCXP") {
        $LEG_Id= $_GET['LEG'];
        ?><script>alert("Legalización de cuenta por pagar <?php echo $LEG_Id;?> anulada correctamente")</script><?php
    } else if($Mensaje=="EALEGCXP") {
        ?><script>alert("Error al anular legalización de cuenta por pagar, intentelo nuevamente")</script><?php
    } else if($Mensaje=="LSCPA") {
        ?><script>alert("No hay cotizaciones disponibles para anular, todas tienen una planilla de producción asignada")</script><?php
    } else if($Mensaje=="LSCPP") {
        ?><script>alert("No hay cotizaciones disponibles para generar la planilla de producción")</script><?php
    } else if($Mensaje=="LSPPA") {
        ?><script>alert("No hay planillas de producción disponibles para anular, todas tienen una remisión asignada")</script><?php
    } else if($Mensaje=="LSPPR") {
        ?><script>alert("No hay planillas de producción disponibles para remisionar")</script><?php
    } else if($Mensaje=="LSRPA") {
        ?><script>alert("No hay remisiones disponibles para anular, todas tienes una factura de venta asignada")</script><?php
    } else if($Mensaje=="LSFPA") {
        ?><script>alert("No hay facturas de venta disponibles para anular")</script><?php
    } else if($Mensaje=="LSLCMPA") {
        ?><script>alert("No hay legalizaciones de caja menor disponibles para anular")</script><?php
    } else if($Mensaje=="LSLCM") {
        ?><script>alert("No hay legalizaciones de caja menor guardadas")</script><?php
    } else if($Mensaje=="LSLCXPPA") {
        ?><script>alert("No hay legalizaciones de cuentas por pagar disponibles para anular")</script><?php
    } else if($Mensaje=="LSLCXP") {
        ?><script>alert("No hay legalizaciones de cuentas por pagar guardadas")</script><?php
    } else if($Mensaje=="ECHC") {
        ?><script>alert("No hay datos para la consulta del historico del cliente")</script><?php
    } else if($Mensaje=="ECFVREM") {
        ?><script>alert("No hay remisiones sin facturar en el sistema en este momento")</script><?php
    } else if($Mensaje=="ECFV") {
        ?><script>alert("No hay facturas de venta guardadas en el sistema en este momento")</script><?php
    } else if($Mensaje=="ECREMCOT") {
        ?><script>alert("No hay datos para el tercero seleccionado")</script><?php
    } else if($Mensaje=="ORSC") {
        $ID_Subcuenta = $_GET['SC'];
        $Detalle_Subcuenta = $_GET['DSC'];
        ?><script>alert("Subcuenta <?php echo ($ID_Subcuenta." ".$Detalle_Subcuenta);?> guardada correctamente")</script><?php
    } else if($Mensaje=="OBSC") {
        ?><script>alert("La subcuenta se elimino correctamente")</script><?php
    } else if($Mensaje=="ORLEGRC") {
        $ID_LEG_RC = $_GET['LEG'];
        ?><script>alert("Recibo de caja <?php echo ($ID_LEG_RC);?> guardado correctamente")</script><?php
    } else if($Mensaje=="OGMC") {
        ?><script>alert("Calibre de malla guardado correctamente")</script><?php
    } else if($Mensaje=="OBMC") {
        ?><script>alert("Calibre de malla eliminado correctamente")</script><?php
    } else if($Mensaje=="OGMH") {
        ?><script>alert("Hueco de malla guardado correctamente")</script><?php
    } else if($Mensaje=="OBMH") {
        ?><script>alert("Hueco de malla eliminado correctamente")</script><?php
    } else if($Mensaje=="OGMT") {
        ?><script>alert("Tipo de malla guardado correctamente")</script><?php
    } else if($Mensaje=="OBMT") {
        ?><script>alert("Tipo de malla eliminado correctamente")</script><?php
    } else if($Mensaje=="OGACC") {
        ?><script>alert("Accesorio guardado correctamente")</script><?php
    } else if($Mensaje=="OBACC") {
        ?><script>alert("Accesorio eliminado correctamente")</script><?php
    } else if($Mensaje=="OAACC") {
        ?><script>alert("Accesorio actualizado correctamente")</script><?php
    } else if($Mensaje=="OGM") {
        ?><script>alert("Malla guardada correctamente")</script><?php
    } else if($Mensaje=="OAM") {
        ?><script>alert("Malla actualizada correctamente")</script><?php
    } else if($Mensaje=="OBM") {
        ?><script>alert("Malla eliminada correctamente")</script><?php
    } else if($Mensaje=="OAPM") {
        ?><script>alert("Precio de las mallas actualizado correctamente")</script><?php
    }

?>

<!DOCTYPE html PUBLIC>

<html>

    <head>
        <?php
            include 'Static/HeadP.html';
        ?>
    </head>

    <body>

        <header>
            <nav id="menuWR">
                <a class="logout" href="CerrarSesion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>" title="Cerrar sesión"><img id="logout" src="../Images/Iconos/logout.png"></a>
            </nav>
            <nav class="div_BarraSuperiorPrincipal">
                <li class="div_BarraSuperiorInternos">
                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="CerrarSesion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>" title="Cerrar sesión">Cerrar sesión</a>
                </li>
            </nav>
        </header>

        <section>
            <img class="img_logo_section" src="../Images/logo.png"/>
            <p class="txt_Normal">Usuario: <?php echo $datosUsuario['usuario_Nombre'];?> <?php echo $datosUsuario['usuario_Apellido'];?></p>
            <?php
            if (validarPermisosUsuario($Documento,array(12,22,16,26))) {?>
                <div class="div_Style" id="Cotizaciones">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Cotizaciones">COTIZACIONES<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Cotizaciones">
                        <article class="article_50">
                            <a class="botones_main" href="Cotizacion/IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Ingresar cotización
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Cotizacion/ConsultarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar cotización
                            </a>
                        </article>
                        <article class="article_100">
                            <a class="botones_main" href="Cotizacion/ConsultarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&msj=COTT">
                                Cotizaciones tercero
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(22,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Cotizacion/AnularCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Anular cotización
                                </a>
                            </article>
                            <article class="article_50">
                                <a class="botones_main" href="Cotizacion/ActualizarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Actualizar cotización
                                </a>
                            </article>
                        <?php
                        }?>
                    </div>  
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(12,16,22,26))) {?>
                <div class="div_Style" id="Planillas">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_PlanillasProducción">PLANILLAS DE PRODUCCIÓN<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_PlanillasProducción">
                        <article class="article_50">
                            <a class="botones_main" href="PP/IngresarPP? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Ingresar P.P.
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="PP/ConsultarPP? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar P.P.
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(22,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="PP/AnularPP? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Anular P.P.
                                </a>
                            </article>
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(13,16,23,26))) {?>
                <div class="div_Style" id="Remisiones">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Remisiones">REMISIONES<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Remisiones">
                        <article class="article_50">
                            <a class="botones_main" href="Remision/IngresarRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Ingresar remisión
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Remision/ConsultarRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar remisión
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(23,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Remision/AnularRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Anular remisión
                                </a>
                            </article>
                            <article class="article_50">
                                <a class="botones_main" href="Remision/stickers? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Stickers
                                </a>
                            </article>
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(14,16,24,26))) {?>
                <div class="div_Style" id="Facturas">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_FacturasVenta">FACTURAS DE VENTA<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_FacturasVenta">
                        <article class="article_50">
                            <a class="botones_main" href="FacturaVenta/IngresarFV? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Ingresar factura
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="FacturaVenta/ConsultarFV? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar factura
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(24,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="FacturaVenta/AnularFV? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Anular factura
                                </a>
                            </article>
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(12,16,22,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Mallas">MALLAS<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Mallas">
                        <article class="article_50">
                            <a class="botones_main" href="Mallas/IngresarMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Registrar malla
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="GenerarPDF/Listado_Mallas? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Listado mallas
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(22,26))) {?>
                            <article class="article_100">
                                <a class="botones_main" href="Mallas/ActualizarMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Actualizar malla
                                </a>
                            </article>
                            <article class="article_50">
                                <a class="botones_main" href="Mallas/EliminarMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Eliminar malla
                                </a>
                            </article>
                            <article class="article_50">
                                <a class="botones_main" href="Mallas/ActualizarPrecios? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Actualizar precios
                                </a>
                            </article>
                        <?php
                        }
                        ?>
                        <div class="div_Style">
                            <p class="txt_Subtitulo">HUECOS</p>
                            <article class="article_50">
                                <a class="botones_main" href="Mallas_Hueco/IngresarHueco? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Registrar hueco
                                </a>
                            </article>
                            <?php
                            if (validarPermisosUsuario($Documento,array(22,26))) {?>
                                <article class="article_50">
                                    <a class="botones_main" href="Mallas_Hueco/EliminarHueco? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Eliminar hueco
                                    </a>
                                </article>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="div_Style">
                            <p class="txt_Subtitulo">CALIBRES</p>
                            <article class="article_50">
                                <a class="botones_main" href="Mallas_Calibre/IngresarCalibre? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Registrar calibre
                                </a>
                            </article>
                            <?php
                            if (validarPermisosUsuario($Documento,array(22,26))) {?>
                                <article class="article_50">
                                    <a class="botones_main" href="Mallas_Calibre/EliminarCalibre? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Eliminar calibre
                                    </a>
                                </article>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="div_Style">
                            <p class="txt_Subtitulo">TIPOS DE MALLA</p>
                            <article class="article_50">
                                <a class="botones_main" href="Mallas_Tipo/IngresarTipoMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Registrar tipo malla
                                </a>
                            </article>
                            <?php
                            if (validarPermisosUsuario($Documento,array(22,26))) {?>
                                <article class="article_50">
                                    <a class="botones_main" href="Mallas_Tipo/EliminarTipoMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Eliminar tipo malla
                                    </a>
                                </article>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php
            if (validarPermisosUsuario($Documento,array(12,16,22,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Accesorios">ACCESORIOS<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Accesorios">
                        <article class="article_50">
                            <a class="botones_main" href="Accesorio/IngresarAccesorio? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Registrar accesorio
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="GenerarPDF/Listado_Accesorios? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Listado accesorios
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(22,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Accesorio/ActualizarAccesorio? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Actualizar accesorio
                                </a>
                            </article>
                            <article class="article_50">
                                <a class="botones_main" href="Accesorio/EliminarAccesorio? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Eliminar accesorio
                                </a>
                            </article>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php
            if (validarPermisosUsuario($Documento,array(15,16,25,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_LegalizacionesCajaMenor">CAJA MENOR<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_LegalizacionesCajaMenor">
                        <article class="article_50">
                            <a class="botones_main" href="Legalizacion_CM/IngresarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Ingresar C.M.
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Legalizacion_CM/ConsultarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar C.M.
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(25,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Legalizacion_CM/AnularLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Anular C.M.
                                </a>
                            </article>
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(15,16,25,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_LegalizacionesCuentasPagar">CUENTAS POR PAGAR<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_LegalizacionesCuentasPagar">
                        <article class="article_50">
                            <a class="botones_main" href="Legalizacion_CXP/IngresarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Ingresar CXP
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Legalizacion_CXP/ConsultarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar CXP
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(25,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Legalizacion_CXP/AnularLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Anular CXP
                                </a>
                            </article>
                        
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(/*15,16,25,26*/11))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_RecibosCaja">RECIBOS DE CAJA<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_RecibosCaja">
                        <article class="article_50">
                            <a class="botones_main" href="Legalizacion_RC/IngresarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Ingresar RC
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Legalizacion_RC/ConsultarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar RC
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(25,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Legalizacion_RC/AnularLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Anular RC
                                </a>
                            </article>
                        
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(15,16,25,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_CentrosCosto">CENTROS DE COSTO<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_CentrosCosto">
                        <article class="article_50">
                            <a class="botones_main" href="CentroCosto/IngresarCentroCosto? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Registrar C.C.
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(25,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="CentroCosto/EliminarCentroCosto? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Eliminar C.C.
                                </a>
                            </article>
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(15,16,25,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_PUC">PUC<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_PUC">
                        <article class="article_50">
                            <a class="botones_main" href="PUC/IngresarSubcuenta? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Registrar subcuenta
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(25,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="PUC/EliminarSubcuenta? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Eliminar subcuenta
                                </a>
                            </article>
                        <?php
                        }?>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(12,15,16,22,25,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Terceros">TERCEROS<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Terceros">
                        <article class="article_50">
                            <a class="botones_main" href="Tercero/IngresarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Registrar tercero
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Tercero/ConsultarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar tercero
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(22,25,26))) {?>
                            <article class="article_100">
                                <a class="botones_main" href="Tercero/EliminarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Eliminar tercero
                                </a>
                            </article>
                        <?php
                        }?>
                        <?php
                        if (validarPermisosUsuario($Documento,array(13,16,23,26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Planta_Tercero/IngresarPlantaT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Registrar planta
                                </a>
                            </article>
                            <article class="article_50">
                                <a class="botones_main" href="Planta_Tercero/ConsultarPlantaT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Consultar planta
                                </a>
                            </article>
                            <?php
                            if (validarPermisosUsuario($Documento,array(23,26))) {?>
                                <article class="article_100">
                                    <a class="botones_main" href="Planta_Tercero/EliminarPlantaT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Eliminar planta
                                    </a>
                                </article>
                            <?php
                            }?>
                        <?php
                        }?>
                    </div> 
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(16,26))) {?>
                <div class="div_Style" id="Usuarios">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Usuarios">USUARIOS<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Usuarios">
                        <article class="article_50">
                            <a class="botones_main" href="Usuario/IngresarUsuario? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Registrar usuario
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Usuario/ConsultarUsuario? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Consultar usuario
                            </a>
                        </article>
                        <?php
                        if (validarPermisosUsuario($Documento,array(26))) {?>
                            <article class="article_50">
                                <a class="botones_main" href="Usuario/EliminarUsuario? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Eliminar acceso
                                </a>
                            </article>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php
            if (validarPermisosUsuario($Documento,array(16,22,23,24,25,26))) {?>
                <div class="div_Style" id="moduloInformes">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Informes">INFORMES<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Informes">
                        <article class="article_50">
                            <a class="botones_main" href="Informes/FV_vs_REM? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                FV vs REM
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Informes/REM_vs_COT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                REM vs COT
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Informes/HistoricoCliente? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Historico cliente
                            </a>
                        </article>
                        <article class="article_50">
                            <a class="botones_main" href="Informes/RelacionFV? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Rel. FV
                            </a>
                        </article>
                    </div>
                </div>
            <?php
            }?>
            <?php
            if (validarPermisosUsuario($Documento,array(16,26))) {?>
                <div class="div_Style">
                    <p class="txt_Subtitulo"><a class="a_MenuDesplegable" href="#MD_Data">BASES DE DATOS<img class="img_MenuDesplegable" src="../Images/Iconos/icono-MD.png"/></a></p>
                    <div class="div_MenuDesplegable" id="MD_Data">
                        <article class="article_50">
                            <a class="botones_main" href="ExportarData/exportarData? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                Exportar
                            </a>
                        </article>
                    </div>
                </div>
            <?php
            }?>

        </section>

        <?php
            include 'Static/Footer.html';
        ?>

    </body>

</html>