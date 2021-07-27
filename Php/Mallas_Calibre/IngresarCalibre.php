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

    if (isset($_POST['Calibre_Detalle']) and isset($_POST['Calibre_Medida'])) {
        $Calibre_Detalle = strtoupper($_POST['Calibre_Detalle']);
        $Calibre_Medida = $_POST['Calibre_Medida'];
        if (!esta_Malla_Calibre($Calibre_Detalle, $Calibre_Medida)) {
            if (insertar_Malla_Calibre($Calibre_Detalle, $Calibre_Medida)) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OGMC");
                exit();
            } else {
                echo '<script>alert("El calibre de malla no se pudo registrar, intentelo nuevamente")</script>';
            }
        } else {
            echo '<script>alert("El calibre de malla ya se encuentra registrado en la base de datos")</script>';
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
            <form class="form_Style" method="post" action="IngresarCalibre? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Registro calibre</p>
                <div>
                    <label>Detalle:</label>
                    <textarea type="text" name="Calibre_Detalle" id="Calibre_Detalle" placeholder="Detalle calibre" autocomplete="off" required></textarea>
                </div>
                <div>
                    <label>Medida (mm):</label>
                    <input type="number" name="Calibre_Medida" id="Calibre_Medida" placeholder="0.00000" min="0" step="any" autocomplete="off" required/>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Guardar</button>
                </div>
            </form>

            <?php
            if (count(lista_Mallas_Calibre()) > 0) {
                $Mallas_Calibre = lista_Mallas_Calibre();?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <tr>
                            <td class="datos_fijos"># calibre</td>
                            <td class="datos_fijos">Detalle calibre</td>
                            <td class="datos_fijos">Medida calibre</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($Mallas_Calibre); $i += 3) {?>
                            <tr>
                                <td class="datos_variables"><?php echo ($i/3+1);?></td>
                                <td class="datos_variables"><?php echo $Mallas_Calibre[$i+1];?></td>
                                <td class="datos_variables"><?php echo $Mallas_Calibre[$i+2];?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div id="lista_WR">
                    <ul>
                        <?php
                        for ($i = 0; $i < count($Mallas_Calibre); $i += 3) {?>
                            <li># calibre: <?php echo ($i/3+1);?></li>
                            <ul>
                                <li>Detalle calibre: <?php echo $Mallas_Calibre[$i+1];?></li>
                                <li>Medida calibre: <?php echo $Mallas_Calibre[$i+2];?></li>
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