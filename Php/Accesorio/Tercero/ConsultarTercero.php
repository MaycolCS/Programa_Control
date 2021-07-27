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
    if (!validarPermisosUsuario($Documento,array(12,15,16,22,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }  

    if($Mensaje=="EST") {
        echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
    }

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    $Terceros = listaTerceros();
    $cant_Terceros = count($Terceros);
    $aux_cant_Terceros = 0;

    $Tercero=0;
    if (isset($_POST['nitTercero'])) {
        $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        if (!estaTercero($Tercero)) {
            header("Location: ConsultarTercero? cc=$Documento&cs=$CS&msj=EST");
            exit();
        } else {
            $DatosTercero = datosTercero($Tercero);
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
            if ($Tercero==0) {?>
                <form class="form_Style" method="post" action="ConsultarTercero.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Consultar tercero</p>
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
                        <button type="submit">Consultar</button>
                    </div>
                </form>
            <?php
            } else {?>
                <form class="form_Style" method="post" action="ActualizarTercero.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&tr=<?php echo $Tercero ;?>">
                    <p class="txt_Titulo">Consultar tercero</p>
                    <div>
                        <label>Nit:</label>
                        <input readonly=»readonly» value="<?php echo number_format($DatosTercero['tercero_Nit']) ;?>"/>
                    </div>
                    <div>
                        <label>DV:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Dv'] ;?>"/>
                    </div>
                    <div>
                        <label>Nombre:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_RazonSocial'] ;?>"/>
                    </div>
                    <div>
                        <label>Contacto:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Contacto'] ;?>"/>
                    </div>
                    <div>
                        <label>Direccón:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Direccion'] ;?>"/>
                    </div>
                    <div>
                        <label>Departamento:</label>
                        <input readonly=»readonly» value="<?php echo nombreDepartamento($DatosTercero['tercero_Departamento']) ;?>"/>
                    </div>
                    <div>
                        <label>Ciudad:</label>
                        <input readonly=»readonly» value="<?php echo nombreCiudad($DatosTercero['tercero_Ciudad']) ;?>"/>
                    </div>
                    <div>
                        <label>Telefono:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Telefono1'] ;?>"/>
                    </div>
                    <div>
                        <label>Telefono:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Telefono2'] ;?>"/>
                    </div>
                    <div>
                        <label>Correo:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Email'] ;?>"/>
                    </div>
                    <div>
                        <label>Pago:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_FormaPago'] ;?>"/>
                    </div>
                    <div>
                        <label>D. pago:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_DiasPago'] ;?>"/>
                    </div>
                    <div>
                        <label>Retefuente:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_PorcentajeRetefuente'] ;?> %"/>
                    </div>
                    <div>
                        <label>Descuento:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_PorcentajeDescuento'] ;?> %"/>
                    </div>
                    <div>
                        <label>T. Tercero:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Tipo'] ;?>"/>
                    </div>
                    <div>
                        <label>Ubicación:</label>
                        <a href="<?php echo $DatosTercero['tercero_Ubicacion'] ;?>"><input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Ubicacion'] ;?>"/></a>
                    </div>
                    <div class="Boton_Style">
                        <button type="submit">Actualizar</button>
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