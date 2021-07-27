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

    if (isset($_POST['Tipo_Malla_Detalle'])) {
        $Tipo_Malla_Detalle = strtoupper($_POST['Tipo_Malla_Detalle']);
        if (!esta_Malla_Tipo($Tipo_Malla_Detalle)) {
            if (insertar_Malla_Tipo($Tipo_Malla_Detalle)) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OGMT");
                exit();
            } else {
                echo '<script>alert("El tipo malla de malla no se pudo registrar, intentelo nuevamente")</script>';
            }
        } else {
            echo '<script>alert("El tipo malla de malla ya se encuentra registrado en la base de datos")</script>';
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
            <form class="form_Style" method="post" action="IngresarTipoMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Registro tipo malla malla</p>
                <div>
                    <label>Detalle:</label>
                    <textarea type="text" name="Tipo_Malla_Detalle" id="Tipo_Malla_Detalle" placeholder="Detalle tipo malla malla" autocomplete="off" required></textarea>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Guardar</button>
                </div>
            </form>

            <?php
            if (count(lista_Mallas_Tipo()) > 0) {
                $Mallas_tipo = lista_Mallas_Tipo();?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <tr>
                            <td class="datos_fijos"># tipo malla</td>
                            <td class="datos_fijos">Detalle tipo malla</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($Mallas_tipo); $i += 2) {?>
                            <tr>
                                <td class="datos_variables"><?php echo ($i/2+1);?></td>
                                <td class="datos_variables"><?php echo $Mallas_tipo[$i+1];?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div id="lista_WR">
                    <ul>
                        <?php
                        for ($i = 0; $i < count($Mallas_tipo); $i += 2) {?>
                            <li># tipo malla: <?php echo ($i/2+1);?></li>
                            <ul>
                                <li>Detalle tipo malla: <?php echo $Mallas_tipo[$i+1];?></li>
                            </ul>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            <?php
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>