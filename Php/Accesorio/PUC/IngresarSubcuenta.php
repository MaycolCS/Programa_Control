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
        if($Mensaje=="ESCE") {
            echo '<script>alert(La subcuenta ya se encuentra registrada en la base de datos")</script>';
        } else if($Mensaje=="ERSC") {
            echo '<script>alert("La subcuenta no se registro, intentelo nuevamente")</script>';
        } else if($Mensaje=="ECNE") {
            echo '<script>alert("La cuenta no se encuentra registrada")</script>';
        }
    }
    
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $listaCuentasPUC = listaPucCuentas();

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
            <form class="form_Style" method="post" action="IngresarSubcuentaDB.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Registro subcuenta</p>
                <div>
                    <label>Cuenta:</label>
                    <input list="listaCuentasPUC" name="cuentaPUC" id="cuentaPUC" pattern="[0-9]+" title="Solo se permiten números" autocomplete="off" required/>
                    <datalist id="listaCuentasPUC">
                        <?php
                        for ($i = 0; $i < count($listaCuentasPUC); $i += 2) {?>
                            <option value="<?php echo $listaCuentasPUC[$i] ;?>"><?php echo $listaCuentasPUC[$i+1] ;?></option>
                        <?php
                        }
                        ?>
                    </datalist>                
                </div>
                <div>
                    <label>Detalle subcuenta:</label>
                    <input type="text" name="subcuentaPUC" id="subcuentaPUC" placeholder="Detalle subcuenta" autocomplete="off" required/>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Guardar</button>
                </div>
            </form>

            <?php
            if (count(listaPucSubcuentas()) > 0) {
                $Subcuentas = listaPucSubcuentas();?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <tr>
                            <td class="datos_fijos"># cuenta</td>
                            <td class="datos_fijos">Detalle cuenta</td>
                            <td class="datos_fijos"># subcuenta</td>
                            <td class="datos_fijos">Detalle subcuenta</td>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($Subcuentas); $i += 3) {?>
                            <tr>
                                <td class="datos_variables"><?php echo $Subcuentas[$i+2];?></td>
                                <td class="datos_variables"><?php echo nombrePucCuenta($Subcuentas[$i+2]);?></td>
                                <td class="datos_variables"><?php echo $Subcuentas[$i];?></td>
                                <td class="datos_variables"><?php echo $Subcuentas[$i+1];?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <div id="lista_WR">
                    <ul>
                        <?php
                        for ($i = 0; $i < count($Subcuentas); $i += 3) {?>
                            <li># subcuenta: <?php echo $Subcuentas[$i];?></li>
                            <ul>
                                <li># cuenta: <?php echo $Subcuentas[$i+2];?></li>
                                <li>Detalle cuenta: <?php echo nombrePucCuenta($Subcuentas[$i+2]);?></li>
                                <li>Detalle subcuenta: <?php echo $Subcuentas[$i+1];?></li>
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