<?php
    
    $Mensaje="";
    if (isset($_GET['msj'])) {
        $Mensaje=$_GET['msj'];
        if($Mensaje=="EUNE") {
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
    if (!validarPermisosUsuario($Documento,array(16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    $usuarios = listaUsuarios();

    $UsuarioConsulta="";
    if (isset($_POST['usuario'])) {
        $UsuarioConsulta = $_POST['usuario'];
        if (!estaDocumento($UsuarioConsulta)) {
            header("Location: ConsultarUsuario? cc=$Documento&cs=$CS&msj=EUNE");
            exit();
        } else {
            $DatosUsuarioConsulta = datosUsuario($UsuarioConsulta);
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
            if ($UsuarioConsulta=="") {?>
                <form class="form_Style" method="post" action="ConsultarUsuario.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Consultar usuario</p>
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
                        <button type="submit">Consultar</button>
                    </div>
                </form>
            <?php
            } else {?>
                <form class="form_Style" method="post" action="ActualizarUsuario.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&uc=<?php echo $UsuarioConsulta ;?>">
                    <p class="txt_Titulo">Consultar usuario</p>
                    <div>
                        <label>Nombre:</label>
                        <input readonly=»readonly» value="<?php echo $DatosUsuarioConsulta['usuario_Nombre'] ;?>"/>
                    </div>
                    <div>
                        <label>Apellido:</label>
                        <input readonly=»readonly» value="<?php echo $DatosUsuarioConsulta['usuario_Apellido'] ;?>"/>
                    </div>
                    <div>
                        <label>Celular:</label>
                        <input readonly=»readonly» value="<?php echo $DatosUsuarioConsulta['usuario_Celular'] ;?>"/>
                    </div>
                    <div>
                        <label>Correo:</label>
                        <input readonly=»readonly» value="<?php echo $DatosUsuarioConsulta['usuario_Correo'] ;?>"/>
                    </div>
                    <div>
                        <label>Permiso 1:</label>
                        <input readonly=»readonly» value="<?php if (($DatosUsuarioConsulta['usuario_Permiso_1'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_1'] != 0)) { echo $DatosUsuarioConsulta['usuario_Permiso_1']; }?>"/>
                    </div>
                    <div>
                        <label>Permiso 2:</label>
                        <input readonly=»readonly» value="<?php if (($DatosUsuarioConsulta['usuario_Permiso_2'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_2'] != 0)) { echo $DatosUsuarioConsulta['usuario_Permiso_2']; }?>"/>
                    </div>
                    <div>
                        <label>Permiso 3:</label>
                        <input readonly=»readonly» value="<?php if (($DatosUsuarioConsulta['usuario_Permiso_3'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_3'] != 0)) { echo $DatosUsuarioConsulta['usuario_Permiso_3']; }?>"/>
                    </div>
                    <div>
                        <label>Permiso 4:</label>
                        <input readonly=»readonly» value="<?php if (($DatosUsuarioConsulta['usuario_Permiso_4'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_4'] != 0)) { echo $DatosUsuarioConsulta['usuario_Permiso_4']; }?>"/>
                    </div>
                    <div>
                        <ul>
                            <li>TIPOS DE PERMISOS</li>
                            <ul>
                                <li>Permisos: Consultar - Ingresar</li>
                                <ul>
                                    <li>12: Cotizaciones - Productos - Terceros - Planillas de producción</li>
                                    <li>13: Remisiones - Planta terceros</li>
                                    <li>14: Factura de venta</li>
                                    <li>15: CM - CXP - Centro de costo - Terceros</li>
                                    <li>16: Todas las opciones + usuarios + data</li>
                                </ul>
                            </ul>
                            <ul>
                                <li>Permisos: Consultar - Ingresar - Anular - Eliminar - Actualizar</li>
                                <ul>
                                    <li>22: Cotizaciones - Productos - Terceros - Planillas de producción</li>
                                    <li>23: Remisiones - Planta terceros</li>
                                    <li>24: Factura de venta</li>
                                    <li>25: CM - CXP - Centro de costo - Terceros</li>
                                    <li>26: Todas las opciones + usuarios + data</li>
                                </ul>
                            </ul>
                        </ul>
                    </div>
                    <?php
                    if (validarPermisosUsuario($Documento,array(26))) {?>
                        <div class="Boton_Style">
                            <button type="submit">Actualizar</button>
                        </div>
                    <?php
                    }?>
                </form>
            <?php    
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>