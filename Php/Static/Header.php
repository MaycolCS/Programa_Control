<html>
    <body>
        <header>
            <nav id="menuWR">
                <input type="checkbox" id="mostrar_menuWR">
                <label for="mostrar_menuWR"><img src="../../Images/Iconos/icono-menu.png" width="45vh" heigth="45ex" title="Menú"></label>
                <ul>
                    <label for="mostrar_menuWR"><img id="go-back" src="../../Images/Iconos/go-back.jpg"></label>
                    <img src="../../Images/logo.png">
                    <li>
                        <a role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">Inicio</a>
                    </li>
                    <?php
                    if (validarPermisosUsuario($Documento,array(12,22,16,26))) {?>
                        <li>
                            <a role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&#MD_Cotizaciones">Cotizaciones</a>
                        </li>
                    <?php
                    }?>
                    <?php
                    if (validarPermisosUsuario($Documento,array(12,16,22,26))) {?>
                        <li>
                            <a role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&#MD_PlanillasProducción">Planillas</a>
                        </li>
                    <?php
                    }?>
                    <?php
                    if (validarPermisosUsuario($Documento,array(13,16,23,26))) {?>
                        <li>
                            <a role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&#MD_Remisiones">Remisiones</a>
                        </li>
                    <?php
                    }?>
                    <?php
                    if (validarPermisosUsuario($Documento,array(14,16,24,26))) {?>
                        <li>
                            <a role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&#MD_FacturasVenta">Facturas</a>
                        </li>
                    <?php
                    }?>
                    <?php
                    if (validarPermisosUsuario($Documento,array(12,15,16,22,25,26))) {?>
                        <li>
                            <a role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&#MD_Terceros">Terceros</a>
                        </li>
                    <?php
                    }?>
                    <?php
                    if (validarPermisosUsuario($Documento,array(16,26))) {?>
                        <li>
                            <a role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&#MD_Usuarios">Usuarios</a>
                        </li>
                    <?php
                    }?>
                </ul>
            </nav>

            <nav class="div_BarraSuperiorPrincipal">
                <li class="div_BarraSuperiorInternos">
                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../MainPage? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>" title="Inicio">Inicio</a>
                </li>
                <?php
                if (validarPermisosUsuario($Documento,array(12,22,16,26))) {?>
                    <li class="div_BarraSuperiorInternos">
                        <a class="a_BarraSuperior" role="link" aria-selected="true" href="">Cotizaciones</a>
                        <div class="div_BarraSuperiorLista">
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Cotizacion/IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Ingresar cotización
                                </a>
                            </div>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Cotizacion/ConsultarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Consultar cotización
                                </a>
                            </div>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Cotizacion/ConsultarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&msj=COTT">
                                    Cotizaciones tercero
                                </a>
                            </div>
                            <?php
                            if (validarPermisosUsuario($Documento,array(22,26))) {?>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Cotizacion/ActualizarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Actualizar cotización
                                    </a>
                                </div>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Cotizacion/AnularCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Anular cotización
                                    </a>
                                </div>
                            <?php
                            }?>
                        </div>
                    </li>
                <?php
                }?>
                <?php
                if (validarPermisosUsuario($Documento,array(12,16,22,26))) {?>
                    <li class="div_BarraSuperiorInternos">
                        <a class="a_BarraSuperior" role="link" aria-selected="true" href="">Planillas</a>
                        <div class="div_BarraSuperiorLista">
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../PP/IngresarPP? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Ingresar P.P.
                                </a>
                            </div>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../PP/ConsultarPP? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Consultar P.P.
                                </a>
                            </div>
                            <?php
                            if (validarPermisosUsuario($Documento,array(22,26))) {?>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../PP/AnularPP? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Anular P.P.
                                    </a>
                                </div>
                            <?php
                            }?>
                        </div>
                    </li>
                <?php
                }?>
                <?php
                if (validarPermisosUsuario($Documento,array(13,16,23,26))) {?>
                    <li class="div_BarraSuperiorInternos">
                        <a class="a_BarraSuperior" role="link" aria-selected="true" href="">Remisiones</a>
                        <div class="div_BarraSuperiorLista">
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Remision/IngresarRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Ingresar remisión
                                </a>
                            </div>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Remision/ConsultarRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Consultar remisión
                                </a>
                            </div>
                            <?php
                            if (validarPermisosUsuario($Documento,array(23,26))) {?>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Remision/AnularRemision? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Anular remisión
                                    </a>
                                </div>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Remision/stickers? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Stickers
                                    </a>
                                </div>
                            <?php
                            }?>
                        </div>
                    </li>
                <?php
                }?>
                <?php
                if (validarPermisosUsuario($Documento,array(14,16,24,26))) {?>
                    <li class="div_BarraSuperiorInternos">
                        <a class="a_BarraSuperior" role="link" aria-selected="true" href="">Facturas</a>
                        <div class="div_BarraSuperiorLista">
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../FacturaVenta/IngresarFV? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Ingresar factura
                                </a>
                            </div>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../FacturaVenta/ConsultarFV? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Consultar factura
                                </a>
                            </div>
                            <?php
                            if (validarPermisosUsuario($Documento,array(24,26))) {?>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../FacturaVenta/AnularFV? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Anular factura
                                    </a>
                                </div>
                            <?php
                            }?>
                        </div>
                    </li>
                <?php
                }?>
                <?php
                if (validarPermisosUsuario($Documento,array(12,15,16,22,25,26))) {?>
                    <li class="div_BarraSuperiorInternos">
                        <a class="a_BarraSuperior" role="link" aria-selected="true" href="">Terceros</a>
                        <div class="div_BarraSuperiorLista">
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Tercero/IngresarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Registrar tercero
                                </a>
                            </div>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Tercero/ConsultarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Consultar tercero
                                </a>
                            </div>
                            <?php
                            if (validarPermisosUsuario($Documento,array(22,25,26))) {?>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Tercero/EliminarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Eliminar tercero
                                    </a>
                                </div>
                            <?php
                            }?>
                            <?php
                            if (validarPermisosUsuario($Documento,array(13,16,23,26))) {?>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Planta_Tercero/IngresarPlantaT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Registrar planta
                                    </a>
                                </div>
                                <div class="div_BarraSuperiorInternosLista">
                                    <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Planta_Tercero/ConsultarPlantaT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                        Consultar planta
                                    </a>
                                </div>
                                <?php
                                if (validarPermisosUsuario($Documento,array(23,26))) {?>
                                    <div class="div_BarraSuperiorInternosLista">
                                        <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Planta_Tercero/EliminarPlantaT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                            Eliminar planta
                                        </a>
                                    </div>
                                <?php
                                }?>
                            <?php
                            }?>
                        </div>
                    </li>
                <?php
                }?>
                <?php
                if (validarPermisosUsuario($Documento,array(16,26))) {?>
                    <li class="div_BarraSuperiorInternos">
                        <a class="a_BarraSuperior" role="link" aria-selected="true" href="">Usuarios</a>
                        <div class="div_BarraSuperiorLista">
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Usuario/IngresarUsuario? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Registrar usuario
                                </a>
                            </div>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Usuario/ConsultarUsuario? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Consultar usuario
                                </a>
                            </div>
                            <?php
                            if (validarPermisosUsuario($Documento,array(26))) {?>
                            <div class="div_BarraSuperiorInternosLista">
                                <a class="a_BarraSuperior" role="link" aria-selected="true" href="../Usuario/EliminarUsuario? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                                    Eliminar usuario
                                </a>
                            </div>
                            <?php
                            }?>
                        </div>
                    </li>
                <?php
                }?>
            </nav>
        </header>
    </body>
</html>