<?php
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if($Mensaje=="ESU") {
            ?><script>alert("El usuario no se encuentra registrado")</script><?php
        }
    }

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    
    $usuarios = listaUsuarios();

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
            <form name="form" class="form_Style" method="post" action="EliminarUsuarioDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Eliminar usuario</p>
                <div>
                    <label>Usuario:</label>
                    <input list="listaUsuarios" name="usuario" id="usuario" pattern="[0-9]+" title="Solo se permiten números" autocomplete="off" required/>
                    <datalist id="listaUsuarios">
                        <?php
                        for ($i = 0; $i < count($usuarios); $i += 3) {?>
                            <option value="<?php echo $usuarios[$i] ;?>"><?php echo $usuarios[$i+1] ;?></option>
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