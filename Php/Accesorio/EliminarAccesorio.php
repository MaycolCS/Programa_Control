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
    
    $Lista_Accesorios = lista_accesorios();

    if (isset($_POST['Accesorio'])) {
        $Id_Accesorio = $_POST['Accesorio'];
        if (esta_accesorio_Id($Id_Accesorio)) {
            if (eliminar_accesorio($Id_Accesorio) ) {
                header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=OBACC");
                exit();
            } else {
                echo '<script>alert("El accesorio seleccionado no se pudo eliminar, intentelo nuevamente")</script>';
            }
        } else {
            echo '<script>alert("El accesorio seleccionado no se encuentra registrado en la base de datos")</script>';
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
            <form name="form" class="form_Style" method="post" action="EliminarAccesorio? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Eliminar accesorio</p>
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
                    <button type=button onclick="pregunta()" value="Enviar">Eliminar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>