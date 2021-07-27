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

    $Lista_Accesorios = lista_accesorios();
    $Id_Accesorio = 0;
    if (isset($_POST['Accesorio'])) {
        if (esta_accesorio_Id($_POST['Accesorio'])) {
            $Id_Accesorio = $_POST['Accesorio'];
            $Datos_Accesorio = datos_accesorio($Id_Accesorio);
        } else {
            echo '<script>alert("El accesorio seleccionado no se encuentra registrado en la base de datos")</script>';
        }
    }

    if (isset($_POST['Accesorio_Precio'])) {
        $Id_Accesorio = $_GET['idacc'];
        $Accesorio_Precio = $_POST['Accesorio_Precio'];
        if (actualizar_accesorio($Id_Accesorio, $Accesorio_Precio, $Documento)) {
            header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OAACC");
            exit();
        } else {
            echo '<script>alert("El accesorio no se pudo actualizar, intentelo nuevamente")</script>';
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
            if ($Id_Accesorio == 0) {
            ?>
                <form name="form" class="form_Style" method="post" action="ActualizarAccesorio? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Actualizar accesorio</p>
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
            } else { ?>
                <form name="form" class="form_Style" method="post" action="ActualizarAccesorio? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&idacc=<?php echo $Id_Accesorio; ?>">
                    <p class="txt_Titulo">Actualizar accesorio</p>
                    <div>
                        <label>Detalle:</label>
                        <textarea readonly=»readonly»><?php echo $Datos_Accesorio[0] ?></textarea>
                    </div>
                    <div>
                        <label>Precio:</label>
                        <input type="number" name="Accesorio_Precio" id="Accesorio_Precio" placeholder="0000000" min="1" value="<?php echo $Datos_Accesorio[1] ?>" autocomplete="off" required/>
                    </div>
                    <div class="Boton_Style">
                        <button type=button onclick="pregunta()" value="Enviar">Actualizar</button>
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