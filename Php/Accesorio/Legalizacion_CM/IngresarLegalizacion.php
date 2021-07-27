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
        } elseif ($Mensaje == "ORT") {
            echo '<script>alert("¡El tercero se agrego correctamente!")</script>';
        }
    }

    $datosUsuario = datosUsuario($Documento);

    $Terceros = listaTerceros();
    $Tercero=0;
    if (isset($_POST['nitTercero']) and $Tercero != 0) {
        $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        if (!estaTercero($Tercero)) {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
	    $Tercero=0;
        }
    } elseif (isset($_GET['NT']) and $Tercero != 0) {
        $Tercero = $_GET['NT'];
        if (!estaTercero($Tercero)) {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
	    $Tercero=0;
        }
    }

    $IdProvLegalizacion = 0;
    if (isset($_GET['IPLEG'])) {
        $IdProvLegalizacion = $_GET['IPLEG'];
    }
    $CantItems = cantidadItemsProvLegalizacionCM($IdProvLegalizacion);
    if ($CantItems == 20) {
        echo '<script>alert("¡Ha llegado al máximo de productos por legalización, continue el proceso dando al boton de finalizar.!")</script>';
    }
    $ItemsProvLegalizacion = listaItemsProvLegalizacionCM($IdProvLegalizacion);
    $cant_ItemsProvLegalizacion = count($ItemsProvLegalizacion);

    $CentroCosto = listaCentrosCosto();
    $listaCotizaciones = listaCotizacionesSinAnular_Tercero($Tercero);

    $listaSubcuentasPUC = listaPucSubcuentas();
    if (count($listaSubcuentasPUC) == 0) {
        echo '<script>alert("¡No hay subcuentas del PUC registradas!")</script>';
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
                    <form class="form_Style" method="post" action="IngresarLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>">
                        <p class="txt_Titulo">Registro legalización C.M.</p>
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
                        
                        <div class="Boton_Style">
                            <button type="submit">Continuar</button>
                        </div>
                    </form>
                <?php
                } else {?>
                    <form class="form_Style" method="post" action="ProvLegalizacionDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
                        <p class="txt_Titulo">Registro legalización C.M.</p>
                        <div>
                            <label>Nit:</label>
                            <input list="listaTerceros" name="nitCliente" id="nitCliente" autocomplete="off" required/>
                            <datalist id="listaTerceros">
                                <?php
                                for ($i = 0; $i < count($Terceros); $i += 2) {?>
                                    <option value="<?php echo $Terceros[$i] ;?>"><?php echo $Terceros[$i+1] ;?></option>
                                <?php
                                }
                                ?>
                            </datalist>
                            <a class="add_person" href="../Tercero/IngresarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&Leg=CM">
                                <img class="add_person" src="../../Images/Iconos/add-person.png">
                            </a>
                        </div>
                        <div>
                            <label>C. Costo:</label>
                            <select name="CentroCosto" id="CentroCosto" autocomplete="off" required/>
                                <option></option>
                                <?php
                                for ($i = 0; $i < count($CentroCosto); $i += 2) {?>
                                    <option value="<?php echo $CentroCosto[$i]." ".$CentroCosto[$i+1] ;?>"><?php echo $CentroCosto[$i] ;?> - <?php echo $CentroCosto[$i+1] ;?></option>
                                <?php
                                }
                                ?>
                                <?php
                                for ($i = 0; $i < count($listaCotizaciones); $i += 2) {?>
                                    <option value="<?php echo $listaCotizaciones[$i]." ".$listaCotizaciones[$i+1] ;?>"><?php echo $listaCotizaciones[$i] ;?> - <?php echo $listaCotizaciones[$i+1] ;?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
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
                            <input type="text" name="IvaItem" id="IvaItem" placeholder="Valor IVA" autocomplete="off" required/>
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
                            <th>Nit</th>
                            <th>Razon social</th>
                            <th>C. Costo</th>
                            <th>Detalle</th>
                            <th>Cantidad</th>
                            <th>Valor unidad</th>
                            <th>Valor total</th>
                            <th>Valor IVA</th>
                            <th>Eliminar</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($ItemsProvLegalizacion); $i += 10) { ?>
                            <tr>
                                <td><?php echo number_format($ItemsProvLegalizacion[$i]);?></td>
                                <td><?php echo $ItemsProvLegalizacion[$i+1];?></td>
                                <td><?php echo $ItemsProvLegalizacion[$i+2];?></td>
                                <td><?php echo $ItemsProvLegalizacion[$i+3];?></td>
                                <td><?php echo $ItemsProvLegalizacion[$i+4];?></td>
                                <td>$<?php echo number_format($ItemsProvLegalizacion[$i+5]);?></td>
                                <td>$<?php echo number_format($ItemsProvLegalizacion[$i+6]);?></td>
                                <td>$<?php echo number_format($ItemsProvLegalizacion[$i+7]);?></td>
                                <td>
                                    <a class="delete_item" href="EliminarItemProvLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&COIT=<?php echo $ItemsProvLegalizacion[$i+8]; ?>"><img class="img_delete_item" src="../../Images/Iconos/Icon-delete.png"></a>                                
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
                        for ($j = 0; $j < count($ItemsProvLegalizacion); $j += 10) { ?>
                            <li>Item #<?php echo ($j+1); ?></li>
                            <ul>
                                <li>Nit: <?php echo number_format($ItemsProvLegalizacion[$j]);?></li>
                                <li>Detalle: <?php echo $ItemsProvLegalizacion[$j+1];?></li>
                                <li>Detalle: <?php echo $ItemsProvLegalizacion[$j+2];?></li>
                                <li>Detalle: <?php echo $ItemsProvLegalizacion[$j+3];?></li>
                                <li>Cantidad: <?php echo $ItemsProvLegalizacion[$j+4];?></li>
                                <li>Valor unitario: $<?php echo number_format($ItemsProvLegalizacion[$j+5]);?></li>
                                <li>Valor total: $<?php echo number_format($ItemsProvLegalizacion[$j+6]);?></li>
                                <li>Valor IVA: $<?php echo number_format($ItemsProvLegalizacion[$j+7]);?></li>
                                <a class="delete_item" href="EliminarItemProvLegalizacion? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>&COIT=<?php echo $ItemsProvLegalizacion[$j+8]; ?>"><img class="img_delete_item" src="../../Images/Iconos/Icon-delete.png"></a>
                            </ul>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                
                <form name="form" class="form_Style" method="post" action="IngresarLegalizacionDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&IPLEG=<?php echo $IdProvLegalizacion; ?>&NT=<?php echo $Tercero; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
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