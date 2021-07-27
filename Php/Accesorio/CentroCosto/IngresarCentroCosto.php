<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(15,16,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if($Mensaje=="ECC") {
            echo '<script>alert("El centro de costo ya se encuentra registrado en la base de datos")</script>';
        } else if($Mensaje=="ERCC") {
            echo '<script>alert("El centro de costo no se registro, intentelo nuevamente")</script>';
        }
    }
    
    /* Aqui empieza el código */

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
            <form class="form_Style" method="post" action="IngresarCentroCostoDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Registro centro de costo</p>
                <div>
                    <label>Detalle:</label>
                    <input type="text" name="CentroCosto" id="CentroCosto" placeholder="Detalle centro de costo" autocomplete="off" required/>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Guardar</button>
                </div>
            </form>
            <?php
            if (count(listaCentrosCosto()) > 0) {
                $CentrosCosto = listaCentrosCosto();?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <tr>
                            <td class="datos_fijos"># C.C.</td>
                            <td class="datos_fijos">Detalle C.C.</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($CentrosCosto); $i += 2) {?>
                            <tr>
                                <td class="datos_variables"><?php echo ($i/2+1);?></td>
                                <td class="datos_variables"><?php echo $CentrosCosto[$i+1];?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div id="lista_WR">
                    <ul>
                        <?php
                        for ($i = 0; $i < count($CentrosCosto); $i += 2) {?>
                            <li>C.C. # <?php echo ($i/2+1);?></li>
                            <ul>
                                <li>C.C. Detalle: <?php echo $CentrosCosto[$i+1];?></li>
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