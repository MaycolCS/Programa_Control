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
    if (!validarPermisosUsuario($Documento,array(23,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $departamentos = conexionBDDepartamento();

    $PlantaTercero = 0;
    if (isset($_GET['PTercero'])) {
        $PlantaTercero=$_GET['PTercero'];
    }
    $DatosPlantaTercero = datosPlantaTercero($PlantaTercero);

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
            <form class="form_Style" method="post"  action="ActualizarPlantaTDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&PTercero=<?php echo $PlantaTercero; ?>">
                <p class="txt_Titulo">Actualizar planta</p>
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
                    <input type="text" name="contactoPlantaTercero" id="contactoPlantaTercero" placeholder="Contacto planta" value="<?php echo $DatosPlantaTercero['planta_tercero_Contacto'] ;?>" autocomplete="off" required/>
                </div>
                <div>
                    <label>Departamento:</label>
                    <select name="Departamento" id="Departamento" required>
                        <option value="<?php echo $DatosPlantaTercero['planta_tercero_Departamento'] ;?>" selected><?php echo nombreDepartamento($DatosPlantaTercero['planta_tercero_Departamento']) ;?></option>
                        <?php
                        while($fila = mysqli_fetch_array($departamentos)) { 
                            if ($DatosTercero['planta_tercero_Departamento'] != $fila['departamento_Id']) {?>
                                <option value="<?php echo $fila['departamento_Id'] ;?>"><?php echo $fila['departamento_Nombre'] ;?></option>
                            <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Ciudad:</label>
                    <select name="ciudadPlantaTercero" id="ciudadPlantaTercero" required>
                        <option value="<?php echo $DatosPlantaTercero['planta_tercero_Ciudad'] ;?>" selected><?php echo nombreCiudad($DatosPlantaTercero['planta_tercero_Ciudad']) ;?></option>
                    </select>
                </div>
                <div>
                    <label>Dirección:</label>
                    <input type="text" name="direcciónPlantaTercero" id="direcciónPlantaTercero" placeholder="Dirección planta" value="<?php echo $DatosPlantaTercero['planta_tercero_Direccion'] ;?>" autocomplete="off" required/>
                </div>
                <div>
                    <label>Telefono:</label>
                    <input type="number" name="telefono1PlantaTercero" id="telefono1PlantaTercero" placeholder="Telefono 1" value="<?php echo $DatosPlantaTercero['planta_tercero_Telefono1'] ;?>" autocomplete="off" required/>
                </div>  
                <div>
                    <label>Telefono:</label>
                    <input type="number" name="telefono2PlantaTercero" id="telefono2PlantaTercero" placeholder="Telefono 2" value="<?php echo $DatosPlantaTercero['planta_tercero_Telefono2'] ;?>" autocomplete="off"/>
                </div>
                <div>
                    <label>Correo:</label>
                    <input type="email" name="emailPlantaTercero" id="emailPlantaTercero" value="<?php echo $DatosPlantaTercero['planta_tercero_Email'] ;?>" placeholder="Correo electrónico"/>
                </div>
                <div>
                    <label>Ubicación:</label>
                    <input type="url" name="ubicacionPlantaTercero" id="ubicacionPlantaTercero" placeholder="https://example.com" pattern="https://.*" value="<?php echo $DatosPlantaTercero['planta_tercero_Ubicacion'] ;?>"/>
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