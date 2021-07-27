<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(15,16,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "IALG") {
            echo '<script>alert("¡El item se añadio a la legalización!")</script>';
        } elseif ($Mensaje == "EIALG") {
            echo '<script>alert("¡El item no se añadio a la legalización. Intentelo nuevamente!")</script>';
        } elseif ($Mensaje == "ERLEG") {
            echo '<script>alert("¡La legalización no se pudo registrar correctamente. Intentelo nuevamente!")</script>';
        } elseif ($Mensaje == "EST") {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
        } elseif ($Mensaje == "ESCLT") {
            echo '<script>alert("¡El cliente no se encuentra registrado!")</script>';
        } elseif ($Mensaje == "ESCOT") {
            echo '<script>alert("¡La cotización no se encuentra registrada!")</script>';
        } elseif ($Mensaje == "IELEG") {
            echo '<script>alert("¡Item eliminado de la legalización!")</script>';
        } elseif ($Mensaje == "EEILEG") {
            echo '<script>alert("¡Error eliminando item de la legalización!")</script>';
        } elseif ($Mensaje == "ESSC") {
            echo '<script>alert("¡La cuenta no tiene subcuentas!")</script>';
        } elseif ($Mensaje == "ECNE") {
            echo '<script>alert("¡La cuenta ingresada no existe!")</script>';
        } elseif ($Mensaje == "ESCNE") {
            echo '<script>alert("¡La subcuenta ingresada no existe!")</script>';
        }
    }

    $datosUsuario = datosUsuario($Documento);

    $Terceros = listaTerceros();

    $IdProvLegalizacion = 0;
    if (isset($_GET['IPLEG'])) {
        $IdProvLegalizacion = $_GET['IPLEG'];
    }
    $CantItems = cantidadItemsProvLegalizacionCXP($IdProvLegalizacion);
    if ($CantItems == 20) {
        echo '<script>alert("¡Ha llegado al máximo de productos por legalización, continue el proceso dando al boton de finalizar.!")</script>';
    }
    $ItemsProvLegalizacion = listaItemsProvLegalizacionCXP($IdProvLegalizacion);
    $cant_ItemsProvLegalizacion = count($ItemsProvLegalizacion);

    $CentrosCosto = listaCentrosCosto();

    $Cotizaciones = listaCotizacionesSinAnular();

    $Tercero=0;
    if (isset($_POST['nitTercero'])) {
        $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        if (!estaTercero($Tercero)) {
            header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&msj=EST");
            exit();
        }
    } elseif (isset($_GET['NT'])) {
        $Tercero = $_GET['NT'];
        if (!estaTercero($Tercero)) {
            header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&msj=EST");
            exit();
        }
    }

    $CentroCosto="";
    if (isset($_POST['CentroCosto'])) {
        $CentroCosto = $_POST['CentroCosto'];
    } elseif (isset($_GET['CCosto'])) {
        $CentroCosto = $_GET['CCosto'];
    }

    $FacturaCompra="";
    if (isset($_POST['FacturaCompra'])) {
        $FacturaCompra = $_POST['FacturaCompra'];
    } elseif (isset($_GET['FC'])) {
        $FacturaCompra = $_GET['FC'];
    }

    $listaSubcuentasPUC = listaPucSubcuentas();
    if (count($listaSubcuentasPUC) == 0) {
        header("Location: IngresarLegalizacion? cc=$Documento&cs=$CS&IPLEG$IdProvLegalizacion&NT=$Tercero&COT=$Cotizacion&CCosto=$CentroCosto&NC=$Cliente&FC=$FacturaCompra&msj=ESSC");
        exit();
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
            if ($CantItems>=0 and $CantItems<=12) {
                if ($Tercero==0) {?>
                    <form class="form_Style" method="post" action="IngresarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&CCosto=<?php echo $CentroCosto; ?>&FC=<?php echo $FacturaCompra; ?>">
                        <p class="txt_Titulo">Registro legalización CXP</p>
                        <div>
                            <label>Tercero:</label>
                            <input list="listaTerceros" name="nitTercero" id="nitTercero" autocomplete="off" required/>
                            <datalist id="listaTerceros">
                                <?php
                                for ($i = 0; $i < count($Terceros); $i += 2) {?>
                                    <option value="<?php echo $Terceros[$i] ;?>"><?php echo $Terceros[$i+1] ;?></option>
                                <?php
                                }
                                ?>
                            </datalist>
                        </div>
                        <div>
                            <label>C. Costo:</label>
                            <input list="listaCentroCosto" name="CentroCosto" id="CentroCosto" autocomplete="off" required/>
                            <datalist id="listaCentroCosto">
                                <?php/*
                                for ($k = 0; $k < count($CentrosCosto); $k += 2) {?>
                                    <option value="<?php echo $CentrosCosto[$k] ;?>"><?php echo $CentrosCosto[$k+1] ;?></option>
                                <?php
                                }*/?>
                                <?php
                                for ($l = 0; $l < count($Cotizaciones); $l += 2) {?>
                                    <option value="<?php echo $Cotizaciones[$l] ;?>"><?php echo $Cotizaciones[$l+1] ;?></option>
                                <?php
                                }
                                ?>
                            </datalist>
                        </div>
                        <div>
                            <label>F. Compra:</label>
                            <input type="text" name="FacturaCompra" id="FacturaCompra" placeholder="Número factura compra" autocomplete="off" required/>
                        </div>
                        
                        <div class="Boton_Style">
                            <button type="submit">Continuar</button>
                        </div>
                    </form>
                    <?php
                } else {?>
                    <form class="form_Style" method="post" action="ProvLegalizacionDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&CCosto=<?php echo $CentroCosto; ?>&FC=<?php echo $FacturaCompra; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
                        <p class="txt_Titulo">Registro legalización CXP</p>                          
                        <div>
                            <label>Subcuenta:</label>
                            <input list="listaSubcuentasPUC" name="subcuentaPUC" id="subcuentaPUC" pattern="[0-9]+" title="Solo se permiten números" autocomplete="off" required/>
                            <datalist id="listaSubcuentasPUC">
                                <?php
                                for ($j = 0; $j < count($listaSubcuentasPUC); $j += 3) {?>
                                    <option value="<?php echo $listaSubcuentasPUC[$j] ;?>"><?php echo $listaSubcuentasPUC[$j+1] ;?></option>
                                <?php
                                }
                                ?>
                            </datalist>                
                        </div>
                        <div>
                            <label>Detalle:</label>
                            <textarea type="text" name="DetItem" autocomplete="off" required></textarea>
                        </div>
                        <div>
                            <label>Cantidad:</label>
                            <input type="text" name="CantItem" id="CantItem" placeholder="Cantidad item" min="1" autocomplete="off" required/>
                        </div>
                        <div>
                            <label>Precio:</label>
                            <input type="text" name="PreItem" id="PreItem" placeholder="Precio item" autocomplete="off" required/>
                        </div>
                        <div>
                            <label>IVA:</label>
                            <input type="text" name="IvaItem" id="IvaItem" placeholder="IVA item" autocomplete="off" required/>
                        </div>

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
                            <th>Valor unidad</th>
                            <th>Valor total</th>
                            <th>Valor IVA</th>
                            <th>Eliminar</th>
                        </tr>
                        <?php
                        for ($m = 0; $m < count($ItemsProvLegalizacion); $m += 7) { ?>
                            <tr>
                                <td><?php echo $ItemsProvLegalizacion[$m];?></td>
                                <td><?php echo $ItemsProvLegalizacion[$m+1];?></td>
                                <td>$<?php echo number_format($ItemsProvLegalizacion[$m+2]);?></td>
                                <td>$<?php echo number_format($ItemsProvLegalizacion[$m+3]);?></td>
                                <td>$<?php echo number_format($ItemsProvLegalizacion[$m+4]);?></td>
                                <td>
                                    <a class="delete_item" href="EliminarItemProvLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&CCosto=<?php echo $CentroCosto; ?>&FC=<?php echo $FacturaCompra; ?>&COIT=<?php echo $ItemsProvLegalizacion[$m+5]; ?>">
                                        <img class="img_delete_item" src="../../Images/Iconos/Icon-delete.png">
                                    </a>                                
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div id="lista_WR">
                    <p class="txt_Titulo">Items añadidos</p>
                    <ul>
                        <?php
                        for ($n = 0; $n < count($ItemsProvLegalizacion); $n += 7) { ?>
                            <div class="div_Style"></div>
                            <li>Item #<?php echo ($n+1); ?></li>
                            <ul>
                                <li>Detalle: <?php echo $ItemsProvLegalizacion[$n];?></li>
                                <li>Cantidad: <?php echo $ItemsProvLegalizacion[$n+1];?></li>
                                <li>Valor unitario: $<?php echo number_format($ItemsProvLegalizacion[$n+2]);?></li>
                                <li>Valor total: $<?php echo number_format($ItemsProvLegalizacion[$n+3]);?></li>
                                <li>Valor IVA: $<?php echo number_format($ItemsProvLegalizacion[$n+4]);?></li>
                                <a class="delete_item" href="EliminarItemProvLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&CCosto=<?php echo $CentroCosto; ?>&FC=<?php echo $FacturaCompra; ?>&COIT=<?php echo $ItemsProvLegalizacion[$n+5]; ?>"><img class="img_delete_item" src="../../Images/Iconos/Icon-delete.png"></a>                                
                            </ul>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                
                <form name="form" class="form_Style" method="post" action="IngresarLegalizacionDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&CCosto=<?php echo $CentroCosto; ?>&FC=<?php echo $FacturaCompra; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
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