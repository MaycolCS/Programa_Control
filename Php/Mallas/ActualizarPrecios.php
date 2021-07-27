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

    if (isset($_POST['PorcentajeAumento'])) {
        $PorcentajeAumento = $_POST['PorcentajeAumento'];
        if (actualizar_Precio_Mallas($PorcentajeAumento, $Documento)) {
            header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OAPM");
            exit();
        } else {
            echo '<script>alert("El precio de las mallas no se pudo actualizar, intentelo nuevamente")</script>';
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
            <form class="form_Style" method="post" action="ActualizarPrecios? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Actualizar precios mallas</p>
                <div>
                    <label>% Aumento:</label>
                    <input type="number" name="PorcentajeAumento" id="PorcentajeAumento" min="-100" step="any" placeholder="0 - 100" autocomplete="off" required/>
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