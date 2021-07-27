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
    
    $Lista_Malla_Tipos = lista_Mallas_Tipo();

    if (isset($_POST['Malla_Tipo'])) {
        $Id_Malla_Tipo = $_POST['Malla_Tipo'];
        if (esta_Malla_Tipo_Id($Id_Malla_Tipo)) {
            if (eliminar_Malla_Tipo($Id_Malla_Tipo) ) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OBMT");
                exit();
            } else {
                echo '<script>alert("El tipo de malla seleccionado no se pudo eliminar, intentelo nuevamente")</script>';
            }
        } else {
            echo '<script>alert("El tipo de malla seleccionado no se encuentra registrado en la base de datos")</script>';
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
            <form name="form" class="form_Style" method="post" action="EliminarTipoMalla? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Eliminar tipo de malla</p>
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
                    <button type=button onclick="pregunta()" value="Enviar">Eliminar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>