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

    if (isset($_POST['Accesorio_Detalle']) and isset($_POST['Accesorio_Precio'])) {
        $Accesorio_Detalle = strtoupper($_POST['Accesorio_Detalle']);
        $Accesorio_Precio = $_POST['Accesorio_Precio'];
        if (!esta_accesorio($Accesorio_Detalle)) {
            if (insertar_accesorio($Accesorio_Detalle, $Accesorio_Precio, $Documento)) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OGACC");
                exit();
            } else {
                echo '<script>alert("El accesorio no se pudo registrar, intentelo nuevamente")</script>';
            }
        } else {
            echo '<script>alert("El accesorio ya se encuentra registrado en la base de datos")</script>';
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
            <form class="form_Style" method="post" action="IngresarAccesorio? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Registro accesorio</p>
                <div>
                    <label>Detalle:</label>
                    <textarea type="text" name="Accesorio_Detalle" id="Accesorio_Detalle" placeholder="Detalle Accesorio" autocomplete="off" required/></textarea>
                </div>
                <div>
                    <label>Precio:</label>
                    <input type="number" name="Accesorio_Precio" id="Accesorio_Precio" placeholder="0000000" min="1" autocomplete="off" required/>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Guardar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>