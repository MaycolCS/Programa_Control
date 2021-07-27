<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(13,16,23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    /* Aqui empieza el código */

    $departamentos = listaDepartamentos();

    $Terceros = listaTerceros();
    $Tercero="";
    if (isset($_POST['nitTercero'])) {
        $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        if (!estaTercero($Tercero)) {
            header("Location: IngresarPlantaT? cc=$Documento&cs=$CS&msj=EST");
            exit();
        } else {
            $DatosTercero = datosTercero($Tercero);
        }  
    }

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "ERPT") {
            $Departamento = 0;
            echo '<script>alert("¡La planta ya se encuentra registrada!")</script>';
        }
        if($Mensaje=="EST") {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
        }
    }

    $datosUsuario = datosUsuario($Documento);

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
                <form class="form_Style" method="post" action="IngresarPlantaT? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Registro de planta</p>
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
                <form class="form_Style" method="post" action="IngresarPlantaTDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
                    <p class="txt_Titulo">Registro de planta</p>
                    <div>
                        <label>Nit:</label>
                        <input type="number" name="nitTercero" id="nitTercero" readonly=»readonly» value="<?php echo $DatosTercero['tercero_Nit'] ;?>" autocomplete="off" required/>
                    </div>   
                    <div>
                        <label>Tercero:</label>
                        <input type="text" name="nombreTercero" id="nombreTercero" readonly=»readonly» value="<?php echo $DatosTercero['tercero_RazonSocial'] ;?>" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Contacto:</label>
                        <input type="text" name="contactoPlantaTercero" id="contactoPlantaTercero" placeholder="Contacto planta" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Departamento:</label>
                        <select name="Departamento" id="Departamento" required>
                            <option></option>
                            <?php
                            for ($i = 0; $i < count($departamentos); $i += 2) {?>
                                <option value="<?php echo $departamentos[$i] ;?>"><?php echo $departamentos[$i+1] ;?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label>Ciudad:</label>
                        <select name="ciudadPlantaTercero" id="ciudadPlantaTercero" required></select>
                    </div>
                    <div>
                        <label>Dirección:</label>
                        <input type="text" name="direcciónPlantaTercero" id="direcciónPlantaTercero" placeholder="Dirección planta" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Telefono:</label>
                        <input type="number" name="telefono1PlantaTercero" id="telefono1PlantaTercero" placeholder="Telefono 1" autocomplete="off" required/>
                    </div>  
                    <div>
                        <label>Telefono:</label>
                        <input type="number" name="telefono2PlantaTercero" id="telefono2PlantaTercero" placeholder="Telefono 2" autocomplete="off"/>
                    </div>
                    <div>
                        <label>Correo:</label>
                        <input type="email" name="emailPlantaTercero" id="emailPlantaTercero" placeholder="Correo electrónico"/>
                    </div>
                    <div>
                        <label>Ubicación:</label>
                        <input type="url" name="ubicacionPlantaTercero" id="ubicacionPlantaTercero" placeholder="https://example.com" pattern="https://.*"/>
                    </div>

                    <div>
                        <button type="submit">Guardar</button>
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