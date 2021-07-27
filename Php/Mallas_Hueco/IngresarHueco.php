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

    if (isset($_POST['Hueco_Detalle']) and isset($_POST['Hueco_Medida'])) {
        $Hueco_Detalle = strtoupper($_POST['Hueco_Detalle']); 
        $Hueco_Medida = $_POST['Hueco_Medida'];
        if (!esta_Malla_Hueco($Hueco_Detalle, $Hueco_Medida)) {
            if (insertar_Malla_Hueco($Hueco_Detalle, $Hueco_Medida)) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OGMH");
                exit();
            } else {
                echo '<script>alert("El Hueco de malla no se pudo registrar, intentelo nuevamente")</script>';
            }
        } else {
            echo '<script>alert("El Hueco de malla ya se encuentra registrado en la base de datos")</script>';
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
            <form class="form_Style" method="post" action="IngresarHueco? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Registro hueco</p>
                <div>
                    <label>Detalle:</label>
                    <textarea type="text" name="Hueco_Detalle" id="Hueco_Detalle" placeholder="Detalle Hueco" autocomplete="off" required></textarea>
                </div>
                <div>
                    <label>Medida (mm):</label>
                    <input type="number" name="Hueco_Medida" id="Hueco_Medida" placeholder="0.00000" min="0" step="any" autocomplete="off" required/>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Guardar</button>
                </div>
            </form>

            <?php
            if (count(lista_Mallas_Hueco()) > 0) {
                $Mallas_hueco = lista_Mallas_Hueco();?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <tr>
                            <td class="datos_fijos"># hueco</td>
                            <td class="datos_fijos">Detalle hueco</td>
                            <td class="datos_fijos">Medida hueco</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($Mallas_hueco); $i += 3) {?>
                            <tr>
                                <td class="datos_variables"><?php echo ($i/3+1);?></td>
                                <td class="datos_variables"><?php echo $Mallas_hueco[$i+1];?></td>
                                <td class="datos_variables"><?php echo $Mallas_hueco[$i+2];?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div id="lista_WR">
                    <ul>
                        <?php
                        for ($i = 0; $i < count($Mallas_hueco); $i += 3) {?>
                            <li># hueco: <?php echo ($i/3+1);?></li>
                            <ul>
                                <li>Detalle hueco: <?php echo $Mallas_hueco[$i+1];?></li>
                                <li>Medida hueco: <?php echo $Mallas_hueco[$i+2];?></li>
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