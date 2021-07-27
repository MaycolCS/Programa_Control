<?php
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if($Mensaje=="EST") {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
        } else if($Mensaje=="ESPT") {
            echo '<script>alert("¡La planta del tercero no se encuentra registrada!")</script>';
        }
    }

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

    $datosUsuario = datosUsuario($Documento);
    
    $Terceros = listaTerceros();
    $Tercero=0;
    $PlantasTerceros = 0;
    if (isset($_POST['nitTercero']) or isset($_GET['Tercero'])) {
        if (isset($_POST['nitTercero'])) {
            $Tercero = intval(str_replace(",","",($_POST['nitTercero'])));
        } else if (isset($_GET['Tercero'])) {
            $Tercero = $_GET['Tercero'];
        }
        if (!estaTercero($Tercero)) {
            echo '<script>alert("¡El tercero no se encuentra registrado!")</script>';
            $Tercero=0;
        }
    }

    $PlantaTercero=0;
    if (isset($_POST['PTercero'])) {
        $PlantaTercero = $_POST['PTercero'];
        $DatosPlantaTercero = datosPlantaTercero($PlantaTercero);
        if (count($DatosPlantaTercero) == 0) {
            echo '<script>alert("¡La planta del tercero no se encuentra registrada!")</script>';
            $Tercero=0;
            $PlantaTercero=0;
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
                <form class="form_Style" method="post" action="ConsultarPlantaT.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Consultar planta</p>
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
                    <div>
                        <label>Planta:</label>
                        <select name="PTercero" id="PTercero" required></select>
                    </div>
                    <div class="Boton_Style">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
            <?php
            } else {?>
                <form class="form_Style" method="post" action="ActualizarPlantaT.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&PTercero=<?php echo $PlantaTercero ;?>">
                    <p class="txt_Titulo">Consulta de planta</p>
                    <div>
                        <label>Nit:</label>
                        <input readonly=»readonly» value="<?php echo number_format($DatosPlantaTercero['planta_tercero_NitTercero']) ;?>"/>
                    </div>   
                    <div>
                        <label>Tercero:</label>
                        <input readonly=»readonly» value="<?php echo nombreTercero($DatosPlantaTercero['planta_tercero_NitTercero']) ;?>"/>
                    </div>
                    <div>
                        <label>Contacto:</label>
                        <input readonly=»readonly» value="<?php echo $DatosPlantaTercero['planta_tercero_Contacto'] ;?>"/>
                    </div>
                    <div>
                        <label>Departamento:</label>
                        <input readonly=»readonly» value="<?php echo nombreDepartamento($DatosPlantaTercero['planta_tercero_Departamento']) ;?>"/>
                    </div>
                    <div>
                        <label>Ciudad:</label>
                        <input readonly=»readonly» value="<?php echo nombreCiudad($DatosPlantaTercero['planta_tercero_Ciudad']) ;?>"/>
                    </div>
                    <div>
                        <label>Dirección:</label>
                        <input readonly=»readonly» value="<?php echo $DatosPlantaTercero['planta_tercero_Direccion'] ;?>"/>
                    </div>
                    <div>
                        <label>Telefono:</label>
                        <input readonly=»readonly» value="<?php echo $DatosPlantaTercero['planta_tercero_Telefono1'] ;?>"/>
                    </div>  
                    <div>
                        <label>Telefono:</label>
                        <input readonly=»readonly» value="<?php echo $DatosPlantaTercero['planta_tercero_Telefono2'] ;?>"/>
                    </div>
                    <div>
                        <label>Correo:</label>
                        <input readonly=»readonly» value="<?php echo $DatosPlantaTercero['planta_tercero_Email'] ;?>"/>
                    </div>
                    <div>
                        <label>Ubicación:</label>
                        <a href="<?php echo $DatosPlantaTercero['planta_tercero_Ubicacion'] ;?>"><input readonly=»readonly» value="<?php echo $DatosPlantaTercero['planta_tercero_Ubicacion'] ;?>"/></a>
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