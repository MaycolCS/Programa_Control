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
    if (!validarPermisosUsuario($Documento,array(22,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $departamentos = conexionBDDepartamento();

    $DatosTercero = array();
    $Tercero="";
    if (isset($_GET['tr'])) {
        $Tercero = $_GET['tr'];
        $DatosTercero = datosTercero($Tercero);
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
            <form class="form_Style" method="post"  action="ActualizarTerceroDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Actualizar tercero</p>
                <div>
                    <label>Nit:</label>
                    <input readonly=»readonly» name="nitTercero" id="nitTercero" value="<?php echo $Tercero ;?>"/>
                </div>
                <div>
                    <label>DV:</label>
                    <input readonly=»readonly» name="dvTercero" id="dvTercero" value="<?php echo $DatosTercero['tercero_Dv'] ;?>" required/>
                </div>
                <div>
                    <label>Nombre:</label>
                    <input readonly=»readonly» name="nombreTercero" id="nombreTercero" value="<?php echo $DatosTercero['tercero_RazonSocial'] ;?>" autocomplete="off" required/>
                </div>
                <div>
                    <label>Contacto:</label>
                    <input type="text" name="contactoTercero" id="contactoTercero" placeholder="Contacto Tercero" value="<?php echo $DatosTercero['tercero_Contacto'] ;?>"/>
                </div>
                <div>
                    <label>Departamento:</label>
                    <select name="Departamento" id="Departamento" required>
                        <option value="<?php echo $DatosTercero['tercero_Departamento'] ;?>" selected><?php echo nombreDepartamento($DatosTercero['tercero_Departamento']) ;?></option>
                        <?php
                        while($fila = mysqli_fetch_array($departamentos)) { 
                            if ($DatosTercero['tercero_Departamento'] != $fila['departamento_Id']) {?>
                                <option value="<?php echo $fila['departamento_Id'] ;?>"><?php echo $fila['departamento_Nombre'] ;?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Ciudad:</label>
                    <select name="ciudadTercero" id="ciudadTercero" required>
                        <option value="<?php echo $DatosTercero['tercero_Ciudad'] ;?>" selected><?php echo nombreCiudad($DatosTercero['tercero_Ciudad']) ;?></option>
                    </select>
                </div>
                <div>
                    <label>Direccón:</label>
                    <input type="text" name="direcciónTercero" id="direcciónTercero" placeholder="Dirección Tercero" value="<?php echo $DatosTercero['tercero_Direccion'] ;?>"/>
                </div>
                <div>
                    <label>Telefono:</label>
                    <input type="number" name="telefono1Tercero" id="telefono1Tercero" placeholder="Telefono 1" value="<?php echo $DatosTercero['tercero_Telefono1'] ;?>"/>
                </div>
                <div>
                    <label>Telefono:</label>
                    <input type="number" name="telefono2Tercero" id="telefono2Tercero" placeholder="Telefono 2" value="<?php echo $DatosTercero['tercero_Telefono2'] ;?>"/>
                </div>
                <div>
                    <label>Correo:</label>
                    <input type="email" name="emailTercero" id="emailTercero" placeholder="Correo electrónico" value="<?php echo $DatosTercero['tercero_Email'] ;?>"/>
                </div>
                <div>
                    <label>Pago:</label>
                    <select name="formaPagoTercero" id="formaPagoTercero" required>
                        <option value="<?php echo $DatosTercero['tercero_FormaPago'] ;?>"><?php echo $DatosTercero['tercero_FormaPago'] ;?></option>
                        <?php
                        if ($DatosTercero['tercero_FormaPago'] == "CONTADO") {?>
                            <option value="CRÉDITO">CRÉDITO</option>
                            <option value="ANTICIPADO">ANTICIPADO</option>
                        <?php
                        } elseif ($DatosTercero['tercero_FormaPago'] == "CRÉDITO") {?>
                            <option value="CONTADO">CONTADO</option>
                            <option value="ANTICIPADO">ANTICIPADO</option>
                        <?php
                        } elseif ($DatosTercero['tercero_FormaPago'] == "ANTICIPADO") {?>
                        ?>
                            <option value="CRÉDITO">CRÉDITO</option>
                            <option value="CONTADO">CONTADO</option>
                        <?php
                        } ?>
                    </select>
                </div>
                <div>
                    <label id="label_diasPago">D. pago:</label>
                    <input type="number" name="diasPago" id="diasPago" placeholder="Días de pago" value="<?php echo $DatosTercero['tercero_DiasPago'] ;?>" required/>
                </div>
                <div>
                    <label>Retefuente:</label>
                    <input type="number" name="RetefuenteTercero" id="RetefuenteTercero" placeholder="Porcentaje de retefuente" value="<?php echo $DatosTercero['tercero_PorcentajeRetefuente'] ;?>" min="0" max="100" step="any" required/>
                </div>
                <div>
                    <label>Descuento:</label>
                    <input type="number" name="DescuentoTercero" id="DescuentoTercero" placeholder="Porcentaje de descuento" value="<?php echo $DatosTercero['tercero_PorcentajeDescuento'] ;?>" min="0" required/>
                </div>
                <div>
                    <label>T. Tercero:</label>
                    <select name="tipoTercero" id="tipoTercero" required>
                        <option value="<?php echo $DatosTercero['tercero_Tipo'] ;?>" selected><?php echo $DatosTercero['tercero_Tipo'] ;?></option>
                        <?php
                        if ($DatosTercero['tercero_Tipo'] == "CLIENTE") {?>
                            <option value="PROVEEDOR">PROVEEDOR</option>
                        <?php
                        } elseif ($DatosTercero['tercero_Tipo'] == "PROVEEDOR") {?>
                            <option value="CLIENTE">CLIENTE</option>
                        <?php
                        }?>
                    </select>
                </div>
                <div>
                    <label>Ubicación:</label>
                    <input type="url" name="ubicacionTercero" id="ubicacionTercero" placeholder="https://example.com" pattern="https://.*" value="<?php echo $DatosTercero['tercero_Ubicacion'] ;?>"/>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Actualizar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>