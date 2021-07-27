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
        if ($Mensaje == "EBSC") {
            ?><script>alert("Error al eliminar la subcuenta, intentelo nuevamente.")</script><?php
        }
    }
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    $listaSubcuentasPUC = listaPucSubcuentas($Cuenta);
    if (count($listaSubcuentasPUC) == 0) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPLSCPUC");
        exit();
    }
    $SubcuentaPUC = 0;
    if (isset($_POST['subcuentaPUC'])) {
        if (!estaPucSubcuenta($_POST['subcuentaPUC'])) {
            ?><script>alert("La subcuenta no se encuentra registrada")</script><?php
            $SubcuentaPUC = 0;
        } else {
            $SubcuentaPUC = $_POST['subcuentaPUC'];
            header("Location: EliminarSubcuentaDB? cc=$Documento&cs=$CS&SCPUC=$SubcuentaPUC");
            exit();
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
            <?php
            if ($SubcuentaPUC == 0) {?>
                <form name="form" class="form_Style" method="post" action="EliminarSubcuenta.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Eliminar subcuenta</p>
                    <div>
                        <label>Subcuenta:</label>
                        <input list="listaSubcuentasPUC" name="subcuentaPUC" id="subcuentaPUC" pattern="[0-9]+" title="Solo se permiten números" autocomplete="off" required/>
                        <datalist id="listaSubcuentasPUC">
                            <?php
                            for ($i = 0; $i < count($listaSubcuentasPUC); $i += 2) {?>
                                <option value="<?php echo $listaSubcuentasPUC[$i] ;?>"><?php echo $listaSubcuentasPUC[$i+1] ;?></option>
                            <?php
                            }
                            ?>
                        </datalist>                
                    </div>
                    <div class="Boton_Style">
                        <button type=button onclick="pregunta()" value="Enviar">Eliminar</button>
                    </div>
                </form>
            <?php
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>