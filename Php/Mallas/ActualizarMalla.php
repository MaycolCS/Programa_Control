<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(12,16,22,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

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
    if (($Malla_Tipo != 0) and ($Malla_Hueco != 0) and ($Malla_Calibre != 0)) {
        $Id_Malla = obtener_Id_Malla($Malla_Tipo, $Malla_Hueco, $Malla_Calibre);
        $Datos_Malla = datos_Malla($Id_Malla);
    }

    if (isset($_POST['Malla_Peso'])) {
        $Malla_Peso = $_POST['Malla_Peso'];
        $Malla_Horas = $_POST['Malla_Horas'];
        $Malla_Precio = $_POST['Malla_Precio'];
        if (esta_Malla($Malla_Tipo, $Malla_Hueco, $Malla_Calibre)) {
            if (actualizar_Precio_Malla($Id_Malla, $Malla_Peso, $Malla_Horas, $Malla_Precio, $Documento)) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OAM");
                exit();
            } else {
                echo '<script>alert("La malla no se pudo registrar, intentelo nuevamente")</script>';
            }
        } else {
            $Malla_Tipo = 0;
            $Malla_Hueco = 0;
            $Malla_Calibre = 0;
            echo '<script>alert("La malla no se encuentra registrada en la base de datos")</script>';
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
            if ($Malla_Tipo == 0) {?>
                <form class="form_Style" method="post" action="ActualizarMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                    <p class="txt_Titulo">Actualizar malla</p>
                    <div>
                        <label>Tipo:</label>
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
                <form class="form_Style" method="post" action="ActualizarMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                    <p class="txt_Titulo">Actualizar malla</p>
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
                <form class="form_Style" method="post" action="ActualizarMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                    <p class="txt_Titulo">Actualizar malla</p>
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
                <form class="form_Style" method="post" action="ActualizarMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&MALTIP=<?php echo $Malla_Tipo; ?>&MALHUE=<?php echo $Malla_Hueco; ?>&MALCAL=<?php echo $Malla_Calibre; ?>">
                    <p class="txt_Titulo">Actualizar malla</p>
                    <div>
                        <label>Peso (Kg/M<sup>2</sup>):</label>
                        <input type="number" name="Malla_Peso" id="Malla_Peso" min="0" step="any" placeholder="Total de peso" value="<?php echo $Datos_Malla[3]; ?>" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Horas (hrs/M<sup>2</sup>):</label>
                        <input type="number" name="Malla_Horas" id="Malla_Horas" min="0" step="any" placeholder="Cantidad de horas" value="<?php echo $Datos_Malla[4]; ?>" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Precio:</label>
                        <input type="number" name="Malla_Precio" id="Malla_Precio" min="1" placeholder="Precio actual" value="<?php echo $Datos_Malla[5]; ?>" autocomplete="off" required/>
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