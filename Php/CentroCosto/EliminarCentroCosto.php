<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "EBCC") {
            ?><script>alert("Error al eliminar el centro de costo, intentelo nuevamente.")</script><?php
        }
    }
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    $CentroCosto = listaCentrosCosto();
    $cant_CentroCosto = count($CentroCosto);
    $aux_cant_CentroCosto = 0;

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
            <form name="form" class="form_Style" method="post" action="EliminarCentroCostoDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Eliminar centro de costo</p>
                <div>
                    <label>C. Costo:</label>
                    <select name="CentroCosto" id="CentroCosto" required>
                        <option></option>
                        <?php
                        while ($aux_cant_CentroCosto < $cant_CentroCosto) {?>
                            <option value="<?php echo $CentroCosto[$aux_cant_CentroCosto] ;?>"><?php echo $CentroCosto[$aux_cant_CentroCosto] ;?>, <?php echo $CentroCosto[$aux_cant_CentroCosto+1] ;?></option>
                            <?php
                            $aux_cant_CentroCosto = $aux_cant_CentroCosto+2;
                        }
                        ?>
                    </select>
                </div>
                <div class="Boton_Style">
                    <button type=button onclick="pregunta()" value="Enviar">Eliminar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>