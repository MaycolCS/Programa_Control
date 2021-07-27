<?php

    include '../Funciones.php';

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    if (!validarPermisosUsuario($Documento,array(12,15,16,22,25,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    } 

    /* Aqui empieza el código */

    $departamentos = listaDepartamentos();

    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if ($Mensaje == "ERT") {
            echo '<script>alert("¡El tercero ya se encuentra registrado!")</script>';
        }
    }

    $Leg = "";
    if (isset($_GET['Leg'])) {
        $Leg=$_GET['Leg'];
    }

    $action = "";
    if ($Leg != "") {
        if ($Departamento != 0) {
            if ($Leg == "CM") {
                $Tercero = $_GET['NT'];
                $IdProvLegalizacion = $_GET['IPLEG'];
                $action = "IngresarTerceroDB? cc=$Documento&cs=$CS&Leg=$Leg&IPLEG=$IdProvLegalizacion&NT=$Tercero";
            }
        } else {
            if ($Leg == "CM") {
                $Tercero = $_GET['NT'];
                $IdProvLegalizacion = $_GET['IPLEG'];
                $action = "IngresarTercero? cc=$Documento&cs=$CS&Leg=$Leg&IPLEG=$IdProvLegalizacion&NT=$Tercero";
            }
        }
    } else {
        $action = "IngresarTercero? cc=$Documento&cs=$CS";
    }

    $FormasPago = lista_FormaPago();

    $datosUsuario = datosUsuario($Documento);

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
            <form class="form_Style" method="post" action="<?php echo $action; ?>" accept-charset="utf-8" onKeypress="if(event.keyCode == 13) event.returnValue = false;">
                <p class="txt_Titulo">Registro de terceros</p>
                <div>
                    <label>Nit:</label>
                    <input type="text" name="nitTercero" id="nitTercero" placeholder="Número de nit" maxlength="20" required>
                </div>
                <div>
                    <label>DV:</label>
                    <input type="text" name="dvTercero" id="dvTercero" placeholder="Dígito de verificación" maxlength="2" required>
                </div>    
                <div>
                    <label>Nombre:</label>
                    <input type="text" name="nombreTercero" id="nombreTercero" placeholder="Razón social tercero" required/>
                </div>
                <div>
                    <label>Contacto:</label>
                    <input type="text" name="contactoTercero" id="contactoTercero" placeholder="Contacto tercero"/>
                </div>
                <div>
                    <label>Departamento:</label>
                    <select name="Departamento" id="Departamento" required>
                        <option></option>
                        <?php
                        for ($j = 0; $j < count($departamentos); $j += 2) {?>
                            <option value="<?php echo $departamentos[$j] ;?>"><?php echo $departamentos[$j+1] ;?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Ciudad:</label>
                    <select name="ciudadTercero" id="ciudadTercero" required></select>
                </div>
                <div>
                    <label>Dirección:</label>
                    <input type="text" name="direcciónTercero" id="direcciónTercero" placeholder="Dirección Tercero" required/>
                </div>
                <div>
                    <label>Telefono:</label>
                    <input type="number" name="telefono1Tercero" id="telefono1Tercero" minlength="8" placeholder="Telefono 1" required/>
                </div>  
                <div>
                    <label>Telefono:</label>
                    <input type="number" name="telefono2Tercero" id="telefono2Tercero" minlength="8" placeholder="Telefono 2"/>
                </div>
                <div>
                    <label>Correo:</label>
                    <input type="email" name="emailTercero" id="emailTercero" placeholder="Correo electrónico"/>
                </div>
                <div>
                    <label>Pago:</label>
                    <select name="formaPagoTercero" id="formaPagoTercero" autocomplete="off" required/>
                        <option></option>
                        <?php
                        for ($i = 0; $i < count($FormasPago); $i += 2) {?>
                            <option value="<?php echo $FormasPago[$i];?>"><?php echo $FormasPago[$i+1];?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label id="label_diasPago">D. pago:</label>
                    <input type="number" name="diasPago" id="diasPago" placeholder="Días de pago" required/>
                </div>
                <div>
                    <label>Retefuente:</label>
                    <input type="number" name="RetefuenteTercero" id="RetefuenteTercero" min="0" max="100" step="0.1" title="Recuerde separar los decimales con punto" placeholder="Porcentaje (0.0 - 99.9)" required/>
                </div>
                <div>
                    <label>Descuento:</label>
                    <input type="number" name="DescuentoTercero" id="DescuentoTercero" min="0" placeholder="Porcentaje (0 - 100)"/>
                </div>
                <div>
                    <label>T. Tercero:</label>
                    <select name="tipoTercero" id="tipoTercero" required>
                        <option value="" selected></option>
                        <option value="CLIENTE">CLIENTE</option>
                        <option value="PROVEEDOR">PROVEEDOR</option>
                    </select>
                </div>
                <div>
                    <label>Ubicación:</label>
                    <input type="url" name="ubicacionTercero" id="ubicacionTercero" placeholder="https://example.com" pattern="https://.*"/>
                </div>
                <div>
                    <button type="submit">Guardar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>