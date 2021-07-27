<?php
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
    }

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }  

    if($Mensaje=="ESE") {
        echo '<script>alert("Recuerde que debe seleccionar al usuario")</script>';
    }

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $ListadoFacturas = listaFacturasClientes();
    $ValorTotalFacturas = valorTotalFacturasVenta();
    if (count($ListadoFacturas) == 0) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=ECFV&#moduloInformes");
        exit();
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
                
            <div>
                <p class="txt_Titulo">Facturas de venta</p>
                <p class="txt_Normal">Valor total facturas: $ <?php echo number_format($ValorTotalFacturas);?></p>
            </div>
            <div id="tabla_vistaEscritorio">
                <table class="tabla_encabezado">
                    <tr>
                        <td class="datos_fijos">Fecha</td>
                        <td class="datos_fijos">FV</td>
                        <td class="datos_fijos">NIT</td>
                        <td class="datos_fijos">Razón social</td>
                        <td class="datos_fijos">Valor</td>
                    </tr>
                    <?php
                    for ($i = 0; $i < count($ListadoFacturas); $i += 5) {?>
                        <tr>
                            <td class="datos_variables"><?php echo $ListadoFacturas[$i];?></td>
                            <td class="datos_variables"><?php echo $ListadoFacturas[$i+1];?></td>
                            <td class="datos_variables"><?php echo number_format($ListadoFacturas[$i+2]);?></td>
                            <td class="datos_variables"><?php echo $ListadoFacturas[$i+3];?></td>
                            <td class="datos_variables">$ <?php echo number_format($ListadoFacturas[$i+4]);?></td>
                        </tr>
                    <?php
                    }?>
                </table>
            </div>
            <div id="lista_WR">
                <ul>
                    <?php
                    for ($i = 0; $i < count($ListadoFacturas); $i += 5) {?>
                        <li class="datos_variables">FV: <?php echo $ListadoFacturas[$i+1];?></li>
                        <ul>
                            <li class="datos_variables">Fecha: <?php echo $ListadoFacturas[$i];?></li>
                            <li class="datos_variables">NIT: <?php echo number_format($ListadoFacturas[$i+2]);?></li>
                            <li class="datos_variables">Razón social: <?php echo $ListadoFacturas[$i+3];?></li>
                            <li class="datos_variables">Valor: $ <?php echo number_format($ListadoFacturas[$i+4]);?></li>
                        </ul>
                    <?php
                    }?>
                </ul>
            </div>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>