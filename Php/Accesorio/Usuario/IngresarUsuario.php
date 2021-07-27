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

    if ($Mensaje=="EUR") {
        echo '<script>alert("El documento ya se encuentra registrado")</script>';
    } elseif ($Mensaje=="ECR") {
        echo '<script>alert("El correo ya se encuentra registrado")</script>';
    }
    
    /* Aqui empieza el código */

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
            <form class="form_Style" method="post" action="IngresarUsuarioDB? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                <p class="txt_Titulo">Registro usuario</p>
                <div>
                    <label>Cédula:</label>
                    <input type="number" name="Cedula" id="Cedula" placeholder="Documento de identidad" required/>
                </div>
                <div>
                    <label>Nombre:</label>
                    <input type="text" name="Nombre" id="Nombre" placeholder="Nombre" required/>
                </div>
                <div>
                    <label>Apellido:</label>
                    <input type="text" name="Apellido" id="Apellido" placeholder="Apellido" required/>
                </div>
                <div>
                    <label>Celular:</label>
                    <input type="number" name="Celular" id="Celular" placeholder="Número de celular" required/>
                </div>
                <div>
                    <label>Correo:</label>
                    <input type="text" name="email" id="email" placeholder="Correo electrónico" required/>
                </div>
                <div>
                    <label>Permiso 1:</label>
                    <select name="Permiso1" id="Permiso1" required>
                        <option></option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                    </select>
                </div>
                <div>
                    <label>Permiso 2:</label>
                    <select name="Permiso2" id="Permiso2">
                        <option></option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                    </select>
                </div>
                <div>
                    <label>Permiso 3:</label>
                    <select name="Permiso3" id="Permiso3">
                        <option></option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                    </select>
                </div>
                <div>
                    <label>Permiso 4:</label>
                    <select name="Permiso4" id="Permiso4">
                        <option></option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
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