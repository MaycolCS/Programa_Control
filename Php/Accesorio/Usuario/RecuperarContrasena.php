<?php

    include '../Funciones.php';

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
    }
    $Usuario=0;
    if (isset($_POST['usuario'])) {
        $Usuario=$_POST['usuario'];
        if (validacionUsuario_RC($Usuario)==TRUE){
            echo '<script>alert("Hemos enviado a su correo electronico el código de autenticación.")</script>';
        } else {
            echo '<script>alert("Usted no se encuentra registrado en el sistema, contactese con el administrador del sistema.")</script>';
        }
        
    }

    if ($Mensaje=="UNR") {
        echo '<script>alert("Usted no se encuentra registrado en el sistema")</script>';
    } else if ($Mensaje=="EVC") {
        echo '<script>alert("La contraseña ingresada no coincide con la del sistema")</script>';
    } else if ($Mensaje=="ECR") {
        echo '<script>alert("El código de verificación no era el correcto")</script>';
    } else if ($Mensaje=="EDR") {
        echo '<script>alert("El documento no coincidio con el del sistema")</script>';
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

        <section>

            <?php
                if (!validacionUsuario_RC($Usuario)) {?>
                    <form class="form_Style" method="post" action="RecuperarContrasena">
                        <img class="img_logo_login" src="../../Images/logo.png">
                        <p class="txt_Titulo">Cambiar contraseña</p>
                        </br><p class="txt_Normal">Ingrese su documento y le enviaremos a su correo electónico un código para confirmar que es usted</p></br>
                        <div>
                            <label>Documento:</label>
                            <input type="number" name="usuario" id="usuario" placeholder="Documento usuario" autocomplete="off" required/>
                        </div>
                        <div class="Boton_Style">
                            <button type="submit">Enviar</button>
                        </div>
                    </form>
                <?php
                } else {?>
                    <form class="form_Style" method="post" action="RecuperarContrasenaDB" accept-charset="utf-8">
                    <p class="txt_Titulo">Cambiar contraseña</p>
                    <div>
                        <label>Código:</label>
                        <input type="number" name="codeVer" id="codeVer" placeholder="Código de verificación" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Documento:</label>
                        <input type="number" name="usuario" id="usuario" placeholder="Documento usuario" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Nueva contraseña:</label>
                        <input type="password" name="contraseña" id="contraseña" placeholder="Nueva contraseña usuario" autocomplete="off" required/>
                    </div>
                    <div>
                        <label>Repetir contraseña:</label>
                        <input type="password" name="contraseña" id="contraseña_validacion" placeholder="Repetir nueva contraseña usuario" autocomplete="off" required/>
                    </div>
                    <div class="Boton_Style">
                        <button type="submit" id="button_Change">Cambiar</button>
                    </div>
                    </form>
                <?php
                }?>

        </section>

    </body>

</html>