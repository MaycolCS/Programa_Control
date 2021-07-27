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
        } elseif ($Mensaje == "IEC") {
            echo '<script>alert("¡El producto se elimino de la cotización!")</script>';
        } elseif ($Mensaje == "EEIC") {
            echo '<script>alert("¡El producto no se elimino de la cotización. Intentelo nuevamente!")</script>';
        } elseif($Mensaje=="EST") {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
        } elseif($Mensaje=="EPT") {
            echo '<script>alert("¡El tercero no tiene plantas registradas, diríjase al módulo de terceros y registre la planta!")</script>';
        } elseif($Mensaje=="ELMHV") {
            echo '<script>alert("¡El tipo de malla no tiene huecos ni calibres registrados en la base de datos!")</script>';
        } elseif($Mensaje=="ELMHV") {
            echo '<script>alert("¡El tipo de malla y el hueco no tienen calibres registrados en la base de datos!")</script>';
        }
    }

    $datosUsuario = datosUsuario($Documento);

    $Terceros = listaTerceros();

    $Tercero=0;
    if (isset($_POST['nitTercero']) or isset($_GET['NT'])) {
        if (isset($_POST['nitTercero'])) {
            $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        } elseif (isset($_GET['NT'])) {
            $Tercero = $_GET['NT'];
        }
        if (!estaTercero($Tercero)) {
            header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&msj=EST");
            exit();
        } else {
            if (!tienePlantasTercero($Tercero)) {
                $Tercero=0;
                header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&msj=EPT");
                exit();
            } else {
                $DatosTercero = datosTercero($Tercero);
            }
        } 

    }

    //PLANTAS TERCERO

    $PlantasTerceros = listaPlantaTerceros($Tercero);
    $PlantaTercero = 0;
    if (isset($_POST['PTercero'])) {
        $PlantaTercero = $_POST['PTercero'];
    } elseif (isset($_GET['PTercero'])) {
        $PlantaTercero = $_GET['PTercero'];
    }
    
    $Descuento = 0;
    if (isset($_POST['Descuento'])) {
        $Descuento = $_POST['Descuento'];
    } elseif (isset($_GET['DCTO'])) {
        $Descuento = $_GET['DCTO'];
    }

    $TiempoEntrega=0;
    if (isset($_POST['TEntrega'])) {
        $TiempoEntrega = $_POST['TEntrega'];
    } elseif (isset($_GET['TE'])) {
        $TiempoEntrega = $_GET['TE'];
    }

    $TipoProducto = 0;
    if (isset($_POST['TProducto'])) {
        $TipoProducto = $_POST['TProducto'];
    } elseif (isset($_GET['TP'])) {
        $TipoProducto = $_GET['TP'];
    }

    $IdProvCotizacion = 0;
    $CantItems = 0;
    if (isset($_GET['IPC'])) {
        $IdProvCotizacion = $_GET['IPC'];
        $CantItems = cantidadItemSProvCotizacion($IdProvCotizacion);
        if ($CantItems == 12) {
            echo '<script>alert("¡Ha llegado al máximo de productos por cotización, continue el proceso dando al boton de finalizar.!")</script>';
        }
    }
    $ItemsProvCotizacion = listaItemsProvCotizacion($IdProvCotizacion);
    $cant_ItemsProvCotizacion = count($ItemsProvCotizacion);
    $aux_cant_ItemsProvCotizacion = 0;

    $Producto = "";
    if (isset($_POST['Id_Item'])) {
        $Producto = $_POST['Id_Item'];
    }

    //MALLAS

    $Malla_Tipo = 0;
    $Lista_Malla_Tipos = lista_Mallas_Tipo();
    if (isset($_POST['Malla_Tipo'])) {
        if (esta_Malla_Tipo_Id($_POST['Malla_Tipo'])) {
            $Malla_Tipo = $_POST['Malla_Tipo'];
        } else {
            echo '<script>alert("El tipo de malla seleccionado no se encuentra registrado en la base de datos")</script>';
        }
    } elseif (isset($_GET['MALTIP'])) {
        $Malla_Tipo = $_GET['MALTIP'];
    }

    $Malla_Hueco = 0;
    if ($Malla_Tipo != 0) {
        $Lista_Malla_Huecos = lista_Mallas_Hueco_Filtro_Tipo($Malla_Tipo);
        if (count($Lista_Malla_Huecos) == 0) {
            header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&IPC=$IdProvCotizacion&NT=$Tercero&TE=$TiempoEntrega&DCTO=$Descuento&PTercero=$PlantaTercero&TP=$TipoProducto&msj=ELMHV");
            exit();
        }
    }
    if (isset($_POST['Malla_Hueco'])) {
        if (esta_Malla_Hueco_Id($_POST['Malla_Hueco'])) {
            $Malla_Hueco = $_POST['Malla_Hueco'];
        } else {
            echo '<script>alert("El hueco de malla seleccionado no se encuentra registrado en la base de datos")</script>';
        }
    } elseif (isset($_GET['MALHUE'])) {
        $Malla_Hueco = $_GET['MALHUE'];
    }

    $Malla_Calibre = 0;
    if ($Malla_Hueco != 0){
        $Lista_Malla_Calibres = lista_Mallas_Calibre_Filtro_Tipo_Hueco($Malla_Tipo, $Malla_Hueco);
        if (count($Lista_Malla_Calibres) == 0) {
            header("Location: IngresarCotizacion? cc=$Documento&cs=$CS&IPC=$IdProvCotizacion&NT=$Tercero&TE=$TiempoEntrega&DCTO=$Descuento&PTercero=$PlantaTercero&TP=$TipoProducto&msj=ELMCV");
            exit();
        }
    }
    if (isset($_POST['Malla_Calibre'])) {
        if (esta_Malla_Calibre_Id($_POST['Malla_Calibre'])) {
            $Malla_Calibre = $_POST['Malla_Calibre'];
        } else {
            echo '<script>alert("El calibre de malla seleccionado no se encuentra registrado en la base de datos")</script>';
        }
    } elseif (isset($_GET['MALCAL'])) {
        $Malla_Calibre = $_GET['MALCAL'];
    }

    $Id_Malla = 0;
    $Malla_Ancho = 0;
    if (isset($_POST['Malla_Ancho'])) {
        $Malla_Ancho = $_POST['Malla_Ancho'];
    }
    $Malla_Gancho = 0;
    if (isset($_POST['Malla_Gancho'])) {
        $Malla_Gancho = $_POST['Malla_Gancho'];
    }
    $Malla_TipoGancho = "";
    if (isset($_POST['Malla_TipoGancho'])) {
        $Malla_TipoGancho = $_POST['Malla_TipoGancho'];
    }
    $Malla_Largo = 0;
    if (isset($_POST['Malla_Largo'])) {
        $Malla_Largo = $_POST['Malla_Largo'];
    }
    $Malla_Traslapo = 0;
    if (isset($_POST['Malla_Traslapo'])) {
        $Malla_Traslapo = $_POST['Malla_Traslapo'];
    }

    if ($Malla_Tipo != 0 and $Malla_Hueco != 0 and $Malla_Calibre != 0) {
        if ($Malla_Ancho != 0 and $Malla_Gancho != 0 and $Malla_TipoGancho != "" and $Malla_Largo != 0 and $Malla_Traslapo != 0) {
            $Id_Malla = obtener_Id_Malla($Malla_Tipo, $Malla_Hueco, $Malla_Calibre);
            $Datos_Malla = datos_Malla($Id_Malla);
            $Producto = $Id_Malla;
        }
    }

    //ACCESORIOS

    $Lista_Accesorios = lista_accesorios();
    $Id_Accesorio = 0;
    if (isset($_POST['Accesorio'])) {
        if (esta_accesorio_Id($_POST['Accesorio'])) {
            $Id_Accesorio = $_POST['Accesorio'];
            $Datos_Accesorio = datos_accesorio($Id_Accesorio);
            $Producto = $Id_Accesorio;
        } else {
            echo '<script>alert("El accesorio seleccionado no se encuentra registrado en la base de datos")</script>';
        }
    }

    $Producto_Otro = "";
    if (isset($_POST['Otro'])) {
        $Producto = 1;
        $Producto_Otro = $_POST['Otro'];
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
            <img class="img_logo_section" src="../../Images/logo.png"/>
            <p class="txt_Normal">Usuario: <?php echo $datosUsuario['usuario_Nombre'];?> <?php echo $datosUsuario['usuario_Apellido'];?></p>
            <div class="div_Style"></div>
            
            <?php
            if ($CantItems>=0 and $CantItems<=12) {
                if ($Tercero == 0) {?>
                    <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&PTercero=<?php echo $PlantaTercero; ?>">
                        <p class="txt_Titulo">Registro cotización</p>
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
                            <button type="submit" id="button_form">Continuar</button>
                        </div>
                    </form>
                    <?php
                } else if ($TiempoEntrega == 0) {?>
                    <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&PTercero=<?php echo $PlantaTercero; ?>">
                        <p class="txt_Titulo">Registro cotización</p>
                        <div>
                            <label>Planta:</label>
                            <select name="PTercero" id="PTercero" required/>
                                <option></option>
                                <?php
                                for ($k = 0; $k < count($PlantasTerceros); $k += 4) {?>
                                    <option value="<?php echo $PlantasTerceros[$k] ;?>"><?php echo nombreDepartamento($PlantasTerceros[$k+2]) ;?>, <?php echo nombreCiudad($PlantasTerceros[$k+1]) ;?>, <?php echo $PlantasTerceros[$k+3] ;?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label>T. entrega:</label>
                            <input type="number" name="TEntrega" id="TEntrega" placeholder="Días de tiempo de entrega" min="1" autocomplete="off" value="8" required/>
                        </div>
                        <div>
                            <label>% Descuento:</label>
                            <input type="number" name="Descuento" id="Descuento" placeholder="Porcentaje de descuento" value="<?php echo $DatosTercero['tercero_PorcentajeDescuento'] ;?>" min="0" autocomplete="off" required/>
                        </div>
                        <div class="Boton_Style">
                            <button type="submit">Continuar</button>
                        </div>
                    </form>
                <?php
                } else if ($TipoProducto==0) {?>
                    <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>">
                        <p class="txt_Titulo">Registro cotización</p>
                        <div>
                            <label>Tipo producto:</label>
                            <select name="TProducto" id="TProducto" required>
                                <option></option>
                                <option value="1">MALLA</option>
                                <option value="2">ACCESORIO</option>
                                <option value="3">OTRO</option>
                            </select>
                        </div>
                        <div class="Boton_Style">
                            <button type="submit">Continuar</button>
                        </div>
                    </form>
                <?php
                } else if ($Producto=="") {
                    if ($TipoProducto == 1) {
                        if ($Malla_Tipo == 0) {?>
                            <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                                <p class="txt_Titulo">Registro cotización</p>
                                <div>
                                    <label>Tipo malla:</label>
                                    <input list="listaTiposMallas" name="Malla_Tipo" id="Malla_Tipo" autocomplete="off" required/>
                                    <datalist id="listaTiposMallas">
                                        <?php
                                        for ($i = 0; $i < count($Lista_Malla_Tipos); $i += 2) {?>
                                            <option value="<?php echo $Lista_Malla_Tipos[$i] ;?>"><?php echo $Lista_Malla_Tipos[$i+1] ;?></option>
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
                        } elseif ($Malla_Hueco == 0) {?>
                            <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                                <p class="txt_Titulo">Registro cotización</p>
                                <div>
                                    <label>Hueco:</label>
                                    <input list="listaHuecos" name="Malla_Hueco" id="Malla_Hueco" autocomplete="off" required/>
                                    <datalist id="listaHuecos">
                                        <?php
                                        for ($i = 0; $i < count($Lista_Malla_Huecos); $i += 3) {?>
                                            <option value="<?php echo $Lista_Malla_Huecos[$i] ;?>"><?php echo $Lista_Malla_Huecos[$i+1] ;?> - <?php echo $Lista_Malla_Huecos[$i+2] ;?></option>
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
                        } elseif ($Malla_Calibre == 0) {?>
                            <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                                <p class="txt_Titulo">Registro cotización</p>
                                <div>
                                    <label>Calibre:</label>
                                    <input list="listaCalibres" name="Malla_Calibre" id="Malla_Calibre" autocomplete="off" required/>
                                    <datalist id="listaCalibres">
                                        <?php
                                        for ($i = 0; $i < count($Lista_Malla_Calibres); $i += 3) {?>
                                            <option value="<?php echo $Lista_Malla_Calibres[$i] ;?>"><?php echo $Lista_Malla_Calibres[$i+1] ;?> - <?php echo $Lista_Malla_Calibres[$i+2] ;?></option>
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
                            <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                                <p class="txt_Titulo">Registro cotización</p>
                                <div>
                                    <input type="hidden" name="Id_Item" id="Id_Item" readonly=»readonly» value="<?php echo $Producto ;?>"/>
                                </div>
                                <div>
                                    <label>Ancho (mts):</label>
                                    <input type="number" name="Malla_Ancho" id="Malla_Ancho" placeholder="Medida ancho" min="0" step="any" autocomplete="off" required/>
                                </div>
                                <div>
                                    <table class="tabla_TPG">
                                        <tr>
                                            <th colspan="5">Tipos de gancho</th>
                                        </tr>
                                        <tr>
                                            <th>Tipo A</th>
                                            <th>Tipo B</th>
                                            <th>Tipo C</th>
                                            <th>Tipo D</th>
                                            <th>Tipo E</th>
                                        </tr>
                                        <tr>
                                            <td><img src="../../Images/Tipos_Gancho/Gancho_A.jpg"/></td>
                                            <td><img src="../../Images/Tipos_Gancho/Gancho_B.jpg"/></td>
                                            <td><img src="../../Images/Tipos_Gancho/Gancho_C.jpg"/></td>
                                            <td><img src="../../Images/Tipos_Gancho/Gancho_D.jpg"/></td>
                                            <td><img src="../../Images/Tipos_Gancho/Gancho_E.jpg"/></td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <label>T. de gancho:</label>
                                    <select name="Malla_TipoGancho" id="Malla_TipoGancho" required>
                                        <option></option>
                                        <option value="TIPO A">Tipo A</option>
                                        <option value="TIPO B">Tipo B</option>
                                        <option value="TIPO C">Tipo C</option>
                                        <option value="TIPO D">Tipo D</option>
                                        <option value="TIPO E">Tipo E</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Gancho (mts):</label>
                                    <input type="number" name="Malla_Gancho" id="Malla_Gancho" placeholder="Medida gancho" min="0" step="any" value="0.05" autocomplete="off" required/>
                                </div>
                                <div>
                                    <label>Largo (mts):</label>
                                    <input type="number" name="Malla_Largo" id="Malla_Largo" placeholder="Medida largo" min="0" step="any" autocomplete="off" required/>
                                </div>
                                <div>
                                    <label>Traslapo (mts):</label>
                                    <input type="number" name="Malla_Traslapo" id="Malla_Traslapo" placeholder="Medida traslapo" min="0" step="any" value="0.05" autocomplete="off" required/>
                                </div>
                                <div class="Boton_Style">
                                    <button type="submit">Continuar</button>
                                </div>
                            </form>
                        <?php
                        }?>
                    <?php
                    } else if ($TipoProducto==2) {?>
                        <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>">
                            <p class="txt_Titulo">Registro cotización</p>
                            <div>
                                <label>Accesorio:</label>
                                <input list="listaAccesorios" name="Accesorio" id="Accesorio" autocomplete="off" required/>
                                <datalist id="listaAccesorios">
                                    <?php
                                    for ($i = 0; $i < count($Lista_Accesorios); $i += 2) {?>
                                        <option value="<?php echo $Lista_Accesorios[$i] ;?>"><?php echo $Lista_Accesorios[$i+1] ;?></option>
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
                    } else if ($TipoProducto==3) {?>
                        <form class="form_Style" method="post" action="IngresarCotizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>">
                            <p class="txt_Titulo">Registro cotización</p>
                            <div>
                                <label>Producto:</label>
                                <textarea type="text" name="Otro" id="Otro" autocomplete="off" required></textarea>
                            </div>
                            <div class="Boton_Style">
                            <button type="submit">Continuar</button>
                            </div>
                        </form>
                    <?php
                    }?>
                <?php
                } else if ($CantItems>=0) {?>
                    <form class="form_Style" method="post" action="AgregarItemProvCotizacionDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>&PROD=<?php echo $Producto; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
                        <p class="txt_Titulo">Registro cotización</p>
                        <div>
                            <input type="hidden" name="Id_Item" id="Id_Item" readonly=»readonly» value="<?php echo $Producto ;?>"/>
                        </div>
                        <?php 
                        if ($TipoProducto == 1) {?>
                            <div>
                                <label>Tipo:</label>
                                <input type="text" readonly=»readonly» value="<?php echo $Datos_Malla[0] ;?>"/>
                            </div>
                            <div>
                                <label>Hueco:</label>
                                <input type="text" readonly=»readonly» value="<?php echo $Datos_Malla[1] ;?>"/>
                            </div>
                            <div>
                                <label>Calibre:</label>
                                <input type="text" readonly=»readonly» value="<?php echo $Datos_Malla[2] ;?>"/>
                            </div>
                            <div>
                                <label>Ancho (mts):</label>
                                <input type="number" name="Malla_Ancho" id="Malla_Ancho" readonly=»readonly» value="<?php echo $Malla_Ancho ;?>"/>
                            </div>
                            <div>
                                <label>Gancho (mts):</label>
                                <input type="number" name="Malla_Gancho" id="Malla_Gancho" readonly=»readonly» value="<?php echo $Malla_Gancho ;?>"/>
                            </div>
                            <div>
                                <label>Tipo de gancho:</label>
                                <input type="text" name="Malla_TipoGancho" id="Malla_TipoGancho" readonly=»readonly» value="<?php echo $Malla_TipoGancho ;?>"/>
                            </div>
                            <div>
                                <label>Largo (mts):</label>
                                <input type="number" name="Malla_Largo" id="Malla_Largo" readonly=»readonly» value="<?php echo $Malla_Largo ;?>"/>
                            </div>
                            <div>
                                <label>Traslapo (mts):</label>
                                <input type="number" name="Malla_Traslapo" id="Malla_Traslapo" readonly=»readonly» value="<?php echo $Malla_Traslapo ;?>"/>
                            </div>
                        <?php 
                        } elseif ($TipoProducto == 2) {?>
                            <div>
                                <label>Accesorio:</label>
                                <textarea type="text" name="DetItem" readonly=»readonly» value="<?php echo $Datos_Accesorio[0];?>"><?php echo $Datos_Accesorio[0];?></textarea>
                            </div>
                        <?php 
                        } elseif ($TipoProducto == 3) {?>
                            <div>
                                <label>Producto:</label>
                                <textarea type="text" name="DetItem" readonly=»readonly» value="<?php echo $Producto_Otro;?>"><?php echo $Producto_Otro;?></textarea>
                            </div>
                        <?php 
                        }?>
                        <div>
                            <label>Cantidad:</label>
                            <input type="text" name="CantItem" id="CantItem" placeholder="Cantidad item" min="1" autocomplete="off" required/>
                        </div>
                        <?php 
                        if ($TipoProducto == 1) {?>
                            <div>
                                <label>Precio:</label>
                                <input type="text" name="PreItem" id="PreItem" placeholder="Precio item" value="<?php echo round($Datos_Malla[5]*($Malla_Ancho+($Malla_Gancho*$Malla_Gancho)));?>" min="1" autocomplete="off" required/>
                            </div>
                        <?php 
                        } elseif ($TipoProducto == 2) {?>
                            <div>
                                <label>Precio:</label>
                                <input type="text" name="PreItem" id="PreItem" placeholder="Precio item" value="<?php echo $Datos_Accesorio[1] ;?>" min="1" autocomplete="off" required/>
                            </div>
                        <?php 
                        } elseif ($TipoProducto == 3) {?>
                            <div>
                                <label>Precio:</label>
                                <input type="text" name="PreItem" id="PreItem" placeholder="Precio item" min="1" autocomplete="off" required/>
                            </div>
                        <?php 
                        }?>
                        <div>
                            <button type="submit">Agregar item</button>
                        </div>
                    </form>
                <?php
                }
            }?>
            <?php
            if ($CantItems>0) {?>
                <div class="div_Style"></div>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_items">
                        <p class="txt_Titulo">Items añadidos</p>
                        <tr>
                            <th>Detalle</th>
                            <th>Cantidad</th>
                            <th>Precio unidad</th>
                            <th>Precio total</th>
                            <th>Eliminar</th>
                        </tr>
                        <?php
                        $ValorTotalItems = 0;
                        while ($aux_cant_ItemsProvCotizacion < $cant_ItemsProvCotizacion) { ?>
                            <tr>
                                <td><?php echo $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];?></td>
                                <td><?php echo $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];?></td>
                                <td>$ <?php echo number_format($ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2]);?></td>
                                <td>$ <?php echo number_format($ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3]);?></td>
                                <td>
                                    <a class="delete_item" href="EliminarItemProvCotizacion? cc=<?php echo $Documento;?>&cs=<?php echo $CS;?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>&COIT=<?php echo $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+4];?>"><img class="img_delete_item" src="../../Images/Iconos/Icon-delete.png"></a>                                
                                </td>
                                <?php $ValorTotalItems += $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];?>
                            </tr>
                            <?php
                            $aux_cant_ItemsProvCotizacion = $aux_cant_ItemsProvCotizacion+5;
                        }?>
                        <tr>
                            <th colspan="2">Valor total items</th>
                            <td colspan="3">$ <?php echo number_format($ValorTotalItems);?></td>
                        </tr>
                    </table>
                </div>
                <div id="lista_WR">
                    <p class="txt_Titulo">Items añadidos</p>
                    <?php
                    $ValorTotalItems = 0;
                    $aux_cant_ItemsProvCotizacion = 0;
                    $cont = 1;
                    while ($aux_cant_ItemsProvCotizacion < $cant_ItemsProvCotizacion) { ?>
                        <ul>
                            <div class="div_Style"></div>
                            <li>Item #<?php echo $cont; ?></li>
                            <ul>
                                <li>Detalle: <?php echo $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion];?></li>
                                <li>Cantidad: <?php echo $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+1];?></li>
                                <li>Valor unitario: $ <?php echo number_format($ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+2]);?></li>
                                <li>Valor total: $ <?php echo number_format($ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3]);?></li>
                                <a class="delete_item" href="EliminarItemProvCotizacion? cc=<?php echo $Documento;?>&cs=<?php echo $CS;?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>&TP=<?php echo $TipoProducto; ?>&COIT=<?php echo $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+4];?>"><img class="img_delete_item" src="../../Images/Iconos/Icon-delete.png"></a>                                
                            </ul>
                            <?php $ValorTotalItems += $ItemsProvCotizacion[$aux_cant_ItemsProvCotizacion+3];?>
                        </ul>
                    <?php
                        $cont = $cont + 1;
                        $aux_cant_ItemsProvCotizacion = $aux_cant_ItemsProvCotizacion+5;
                    }
                    ?>
                    <div class="div_Style"></div>
                    <ul>
                        <li colspan="2">Valor total items</li>
                        <ul>
                            <li colspan="3">$ <?php echo number_format($ValorTotalItems);?></li>
                        </ul>
                    </ul>
                </div>
                
                <form name="form" class="form_Style" method="post" action="IngresarCotizacionDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPC=<?php echo $IdProvCotizacion; ?>&NT=<?php echo $Tercero; ?>&TE=<?php echo $TiempoEntrega; ?>&DCTO=<?php echo $Descuento; ?>&PTercero=<?php echo $PlantaTercero; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
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