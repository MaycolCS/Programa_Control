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
    if (!validarPermisosUsuario($Documento,array(26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    
    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);
    
    $UsuarioConsulta=$_GET['uc'];
    $DatosUsuarioConsulta = datosUsuario($UsuarioConsulta);

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
            <form class="form_Style" method="post" action="ActualizarUsuarioDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&uc=<?php echo $UsuarioConsulta ;?>">
                <p class="txt_Titulo">Actualizar usuario</p>
                <div>
                    <label>Cédula:</label>
                    <input readonly=»readonly» value="<?php echo $UsuarioConsulta ;?>"/>
                </div>
                <div>
                    <label>Nombre:</label>
                    <input type="text" name="Nombre" id="Nombre" placeholder="Nombre" value="<?php echo $DatosUsuarioConsulta['usuario_Nombre'] ;?>" autocomplete="off" required/>
                </div>
                <div>
                    <label>Apellido:</label>
                    <input type="text" name="Apellido" id="Apellido" placeholder="Apellido" value="<?php echo $DatosUsuarioConsulta['usuario_Apellido'] ;?>" autocomplete="off" required/>
                </div>
                <div>
                    <label>Celular:</label>
                    <input type="number" name="Celular" id="Celular" placeholder="Número de celular" value="<?php echo $DatosUsuarioConsulta['usuario_Celular'] ;?>" autocomplete="off" required/>
                </div>
                <div>
                    <label>Correo:</label>
                    <input type="text" name="email" id="email" placeholder="Correo electrónico" value="<?php echo $DatosUsuarioConsulta['usuario_Correo'] ;?>" autocomplete="off" required/>
                </div>
                <div>
                    <label>Permiso 1:</label>
                    <select name="Permiso1" id="Permiso1" required>
                        <?php if (($DatosUsuarioConsulta['usuario_Permiso_1'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_1'] != 0)) { ?>
                            <option value="<?php echo $DatosUsuarioConsulta['usuario_Permiso_1'] ;?>"><?php echo $DatosUsuarioConsulta['usuario_Permiso_1'] ;?></option>
                        <?php
                        }?>                        
                        <option value="0"></option>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 12) {?>
                            <option value="12">12</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 13) {?>
                            <option value="13">13</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 14) {?>
                            <option value="14">14</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 15) {?>
                            <option value="15">15</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 16) {?>
                            <option value="16">16</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 22) {?>
                            <option value="22">22</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 23) {?>
                            <option value="23">23</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 24) {?>
                            <option value="24">24</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 25) {?>
                            <option value="25">25</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_1'] != 26) {?>
                            <option value="26">26</option>
                        <?php
                        }?>
                    </select> 
                </div>
                <div>
                    <label>Permiso 2:</label>
                    <select name="Permiso2" id="Permiso2">
                        <?php if (($DatosUsuarioConsulta['usuario_Permiso_2'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_2'] != 0)) { ?>
                            <option value="<?php echo $DatosUsuarioConsulta['usuario_Permiso_2'] ;?>"><?php echo $DatosUsuarioConsulta['usuario_Permiso_2'] ;?></option>
                        <?php
                        }?>
                        <option value="0"></option>
                        <?php            
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 12) {?>
                            <option value="12">12</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 13) {?>
                            <option value="13">13</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 14) {?>
                            <option value="14">14</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 15) {?>
                            <option value="15">15</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 16) {?>
                            <option value="16">16</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 22) {?>
                            <option value="22">22</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 23) {?>
                            <option value="23">23</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 24) {?>
                            <option value="24">24</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 25) {?>
                            <option value="25">25</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_2'] != 26) {?>
                            <option value="26">26</option>
                        <?php
                        }?>
                    </select> 
                </div>
                <div>
                    <label>Permiso 3:</label>
                    <select name="Permiso3" id="Permiso3">
                        <?php if (($DatosUsuarioConsulta['usuario_Permiso_3'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_3'] != 0)) { ?>
                            <option value="<?php echo $DatosUsuarioConsulta['usuario_Permiso_3'] ;?>"><?php echo $DatosUsuarioConsulta['usuario_Permiso_3'] ;?></option>
                        <?php
                        }?>
                        <option value="0"></option>
                        <?php   
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 12) {?>
                            <option value="12">12</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 13) {?>
                            <option value="13">13</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 14) {?>
                            <option value="14">14</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 15) {?>
                            <option value="15">15</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 16) {?>
                            <option value="16">16</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 22) {?>
                            <option value="22">22</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 23) {?>
                            <option value="23">23</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 24) {?>
                            <option value="24">24</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 25) {?>
                            <option value="25">25</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_3'] != 26) {?>
                            <option value="26">26</option>
                        <?php
                        }?>
                    </select> 
                </div>
                <div>
                    <label>Permiso 4:</label>
                    <select name="Permiso4" id="Permiso4">
                        <?php if (($DatosUsuarioConsulta['usuario_Permiso_4'] != NULL) and ($DatosUsuarioConsulta['usuario_Permiso_4'] != 0)) { ?>
                            <option value="<?php echo $DatosUsuarioConsulta['usuario_Permiso_4'] ;?>"><?php echo $DatosUsuarioConsulta['usuario_Permiso_4'] ;?></option>
                        <?php
                        }?>
                        <option value="0"></option>
                        <?php   
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 12) {?>
                            <option value="12">12</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 13) {?>
                            <option value="13">13</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 14) {?>
                            <option value="14">14</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 15) {?>
                            <option value="15">15</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 16) {?>
                            <option value="16">16</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 22) {?>
                            <option value="22">22</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 23) {?>
                            <option value="23">23</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 24) {?>
                            <option value="24">24</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 25) {?>
                            <option value="25">25</option>
                        <?php
                        }?>
                        <?php
                        if ($DatosUsuarioConsulta['usuario_Permiso_4'] != 26) {?>
                            <option value="26">26</option>
                        <?php
                        }?>
                    </select> 
                </div>
                <div>
                    <ul>
                        <li>TIPOS DE PERMISOS</li>
                        <ul>
                            <li>Permisos: Consultar - Ingresar</li>
                            <ul>
                                <li>12: Cotizaciones - Mallas - Accesorios - Terceros - Planillas de producción</li>
                                <li>13: Remisiones - Planta terceros</li>
                                <li>14: Factura de venta</li>
                                <li>15: CM - CXP - Centro de costo - Terceros</li>
                                <li>16: Todas las opciones + usuarios + data</li>
                            </ul>
                        </ul>
                        <ul>
                            <li>Permisos: Consultar - Ingresar - Anular - Eliminar - Actualizar</li>
                            <ul>
                                <li>22: Cotizaciones - Mallas - Accesorios - Terceros - Planillas de producción</li>
                                <li>23: Remisiones - Planta terceros</li>
                                <li>24: Factura de venta</li>
                                <li>25: CM - CXP - Centro de costo - Terceros</li>
                                <li>26: Todas las opciones + usuarios + data</li>
                            </ul>
                        </ul>
                    </ul>
                </div>
                <div class="Boton_Style">
                    <button type="submit">Guardar</button>
                </div>
            </form>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>