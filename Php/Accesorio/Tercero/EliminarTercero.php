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
    
    $Terceros = listaTerceros();
    $Tercero="";
    if (isset($_POST['nitTercero'])) {
        $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        if (!estaTercero($Tercero)) {
            ?><script>alert("¡El tercero no se encuentra registrado!")</script><?php
            $Tercero="";
        } elseif(!tienePlantasTercero($Tercero)) {
            ?><script>alert("El tercero <?php echo (nombreTercero($Tercero));?> tiene plantas asociadas, por este motivo no puede ser eliminado.")</script><?php
            $Tercero="";
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
            if ($Tercero=="") {?>
                <form class="form_Style" method="post" action="EliminarTercero? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Eliminar Tercero</p>
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
                    <button type="submit">Continuar</button>
                </div>
            </form>
            <?php
            } else {?>
                <form name="form" class="form_Style" method="post" action="EliminarTerceroDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&tr=<?php echo $Tercero ;?>">
                    <p class="txt_Titulo">Eliminar tercero</p>
                    <div>
                        <label>Nit:</label>
                        <input readonly=»readonly» value="<?php echo $DatosTercero['tercero_Nit'] ;?>"/>
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

                    <div class="Boton_Style">
                        <button type=button onclick="pregunta()" value="Enviar">Eliminar</button>
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