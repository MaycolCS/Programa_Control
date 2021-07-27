<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(22,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    $Lista_Malla_Huecos = lista_Mallas_Hueco();

    if (isset($_POST['Malla_Hueco'])) {
        $Id_Malla_Hueco = $_POST['Malla_Hueco'];
        if (esta_Malla_Hueco_Id($Id_Malla_Hueco)) {
            if (eliminar_Malla_Hueco($Id_Malla_Hueco) ) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OBMH");
                exit();
            } else {
                echo '<script>alert("El hueco de malla seleccionado no se pudo eliminar, intentelo nuevamente")</script>';
            }
        } else {
            echo '<script>alert("El hueco de malla seleccionado no se encuentra registrado en la base de datos")</script>';
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
            <form name="form" class="form_Style" method="post" action="EliminarHueco? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Eliminar hueco</p>
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
                    <button type=button onclick="pregunta()" value="Enviar">Eliminar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>