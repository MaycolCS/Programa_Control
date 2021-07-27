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
    if (!validarPermisosUsuario($Documento,array(14,16,24,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   

    /* Aqui empieza el código */

    $datosUsuario = datosUsuario($Documento);

    $FacturasVenta = listaFacturasVenta();
    $cant_FacturasVenta = count($FacturasVenta);
    $aux_cant_FacturasVenta = 0;

    $IdFacturaVenta = "";
    if (isset($_POST['FV'])) {
        $IdFacturaVenta = $_POST['FV'];
        if (!estaFacturaVenta($IdFacturaVenta)) {
            ?><script>alert("La factura de venta no se encuentra registrada")</script><?php
            $IdFacturaVenta = "";
        }
    } elseif ($Mensaje == "ORFV") {
        ?><script>alert("Factura de venta <?php echo $_GET['FV'];?> guardada correctamente")</script><?php
        $IdFacturaVenta = $_GET['FV'];
    }

    if ($IdFacturaVenta != "") {

        $DatosFV = datosFacturaVenta($IdFacturaVenta);
        $contItems = 0;
        $auxContItems = 1;
        
        $DatosRemisiones = array();

        if ($DatosFV['facturaventa_Remision1'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision1']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision1']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision2'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision2']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision2']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision3'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision3']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision3']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision4'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision4']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision4']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision5'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision5']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision5']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision6'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision6']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision6']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision7'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision7']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision7']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision8'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision8']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision8']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision9'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision9']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision9']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision10'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision10']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision10']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision11'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision11']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision11']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision12'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision12']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision12']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision13'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision13']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision13']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision14'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision14']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision14']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision15'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision15']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision15']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision16'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision16']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision16']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision17'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision17']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision17']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision18'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision18']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision18']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision19'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision19']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision19']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision20'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision20']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision20']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision21'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision21']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision21']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision22'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision22']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision22']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision23'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision23']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision23']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
        }
        if ($DatosFV['facturaventa_Remision24'] != NULL) {
            $contItems = $contItems + contItemsRemision($DatosFV['facturaventa_Remision24']);
            $DatosRemision = itemsRemision($DatosFV['facturaventa_Remision24']);
            $cont_DatosRemision = count($DatosRemision);
            $aux_cont_DatosRemision = 0;
            while ($aux_cont_DatosRemision < $cont_DatosRemision) {
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+1]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+2]);
                array_push($DatosRemisiones, $DatosRemision[$aux_cont_DatosRemision+3]);
                $aux_cont_DatosRemision = $aux_cont_DatosRemision + 4;
            }
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
            if ($IdFacturaVenta=="") {?>
                <form class="form_Style" method="post" action="ConsultarFV.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>">
                    <p class="txt_Titulo">Consultar factura</p>
                    <div>
                        <label>Factura:</label>
                        <input list="listaFacturasVenta" name="FV" id="FV" autocomplete="off" required/>
                        <datalist id="listaFacturasVenta">
                            <?php
                            for ($i = 0; $i < count($FacturasVenta); $i += 2) {?>
                                <option value="<?php echo $FacturasVenta[$i] ;?>"><?php echo $FacturasVenta[$i+1] ;?></option>
                            <?php
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="Boton_Style">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
            <?php
            } else {?>
                <div id="tabla_vistaEscritorio">
                    <table class="tabla_encabezado">
                        <?php
                            include '../Static/encabezadoTablas.html';
                        ?>
                        <tr>
                            <td class="espacio" colspan="7">
                                <?php
                                    if ($DatosFV['facturaventa_Anulada'] == "SI") {
                                        echo "FACTURA DE VENTA ANULADA";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php
                        if ($DatosFV['facturaventa_Anulada'] == "SI") {?>
                            <tr>
                                <td class="datos_fijos">MOTIVO ANULACIÓN</td>
                                <td class="datos_variables" colspan="6"><?php echo $DatosFV['facturaventa_MotivoAnulacion']; ?></td>
                            </tr>
                        <?php
                        }?>
                    </table>
                    <table class="tabla_encabezado">
                    <tr>
                            <td class="datos_fijos" rowspan="2">FECHA</td>
                            <td class="datos_fijos">AÑO</td>
                            <td class="datos_fijos">MES</td>
                            <td class="datos_fijos">DÍA</td>
                            <td class="datos_empresa" rowspan="2"></td>
                            <td class="datos_fijos" rowspan="2">FACTURA DE VENTA</td>
                            <td class="datos_fijos" rowspan="2"><?php echo $DatosFV['facturaventa_Id']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables"><?php echo $DatosFV['facturaventa_Año']; ?></td>
                            <td class="datos_variables"><?php echo $DatosFV['facturaventa_Mes']; ?></td>
                            <td class="datos_variables"><?php echo $DatosFV['facturaventa_Dia']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">NIT</td>
                            <td class="datos_variables" colspan="2"><?php echo $DatosFV['facturaventa_NitTercero']; ?></td>
                            <td class="datos_fijos">DV</td>
                            <td class="datos_variables"><?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Dv']; ?></td>
                            <td class="datos_fijos">FECHA VENCIMIENTO</td>
                            <td class="datos_variables"><?php echo date("Y-m-d",strtotime(date($DatosFV['facturaventa_Fecha'])."+".datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_DiasPago']."days")); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
                            <td class="datos_variables" rowspan="2" colspan="4"><?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_RazonSocial']; ?></td>
                            <td class="datos_fijos">REMISION</td>
                            <td class="datos_variables"><?php echo $DatosFV['facturaventa_Remision']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">TELEFONO</td>
                            <td class="datos_variables"><?php if (datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono2'] != 0) { echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono2'];} ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">TELEFONO</td>
                            <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono1']; ?></td>
                            <td class="datos_fijos">FORMA DE PAGO</td>
                            <td class="datos_variables"><?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_FormaPago']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">CIUDAD</td>
                            <td class="datos_variables" colspan="4"><?php echo nombreDepartamento(datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Ciudad']); ?></td>
                            <td class="datos_fijos">EMAIL</td>
                            <td class="datos_variables"><?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Email']; ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">DIRECCIÓN</td>
                            <td class="datos_variables" colspan="4"><?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Direccion']; ?></td>
                            <td class="datos_fijos">VENDEDOR</td>
                            <td class="datos_variables">ING. <?php echo datosUsuario($DatosFV['facturaventa_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosFV['facturaventa_Vendedor'])['usuario_Apellido']; ?></td>
                        </tr>
                        
                    </table>

                    <table class="tabla_items">
                        <tr>
                            <th>Item</th>
                            <th colspan="3">Detalle</th>
                            <th>Cantidad</th>
                            <th colspan="2">Precio unidad</th>
                            <th colspan="2">Precio total</th>
                        </tr>
                        <?php 
                        $cont_Remisiones = 0;
                        while ($auxContItems <= $contItems) {?>
                            <tr>
                                <td><?php echo $auxContItems; ?></td>
                                <td colspan="3"><?php echo $DatosRemisiones[$cont_Remisiones]; ?></td>
                                <td><?php echo $DatosRemisiones[$cont_Remisiones+1]; ?></td>
                                <td colspan="2">$ <?php echo number_format($DatosRemisiones[$cont_Remisiones+2]); ?></td>
                                <td colspan="2">$ <?php echo number_format($DatosRemisiones[$cont_Remisiones+3]); ?></td>
                            </tr>
                            <?php
                            $cont_Remisiones = $cont_Remisiones + 4;
                            $auxContItems = $auxContItems + 1;
                        }?>
                    </table>

                    <table class="tabla_footer">
                        <tr>
                            <td class="datos_fijos">VALOR EN LETRAS</td>
                            <td class="datos_variables"><?php echo convertirNumeroLetra(round($DatosFV['facturaventa_ValorTotal'])); ?> PESOS M/CTE.</td>
                            <td class="datos_fijos" colspan="2">SUBTOTAL</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format($DatosFV['facturaventa_Subtotal']); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables" colspan="2">
                                Esta factura de venta constituye titulo valor según lo establecido en la ley 1231 de 2008 según art. 772 al 774 del codigo de comercio.
                            </td>
                            <td class="datos_fijos">DESCUENTO</td>
                            <td class="datos_fijos"><?php echo $DatosFV['facturaventa_PorcentajeDescuento']; ?>%</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format($DatosFV['facturaventa_ValorDescuento']); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables" rowspan="2"></td>
                            <td class="datos_variables" rowspan="3">
                                El valor debe ser consignado en la cuenta de ahorros a nombre de 
                                Grupo Tecnico Empresarial sas del banco caja social No 24 098 446 818. 
                                <?php echo $DatosFV['facturaventa_Observaciones']; ?>
                            </td>
                            <td class="datos_fijos">IVA</td>
                            <td class="datos_fijos">19%</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format($DatosFV['facturaventa_ValorIVA_24081001']); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_fijos">RETEFUENTE</td>
                            <td class="datos_fijos"><?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_PorcentajeRetefuente']; ?>%</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format($DatosFV['facturaventa_ValorRetefuente']); ?></td>
                        </tr>
                        <tr>
                            <td class="datos_variables">ACEPTO DE CONFORMIDAD</td>
                            <td class="datos_fijos" colspan="2">TOTAL A PAGAR</td>
                            <td class="datos_variables" colspan="2">$ <?php echo number_format($DatosFV['facturaventa_ValorTotal']); ?></td>
                        </tr>
                        
                    </table>
                </div>

                <div id="lista_WR">
                    <ul>
                        <p class="txt_Subtitulo">FACTURA DE VENTA <?php echo $DatosFV['facturaventa_Id']; ?></p>
                        <?php
                            if ($DatosFV['facturaventa_Anulada'] == "SI") {?>
                                <li>
                                    <?php echo "FACTURA ANULADA";?>
                                </li>
                            <?php
                            }
                        ?>
                        <?php
                        if ($DatosFV['facturaventa_Anulada'] == "SI") {?>
                            <ul>
                                <li>
                                    <td class="datos_fijos">MOTIVO ANULACIÓN: <?php echo $DatosFV['facturaventa_MotivoAnulacion']; ?></td>
                                </li>
                            </ul>
                        <?php
                        }?>
                        <li>FECHA EXPEDICIÓN: <?php echo $DatosFV['facturaventa_Fecha']; ?></li>
                        <li>FECHA VENCIMIENTO: <?php echo date("Y-m-d",strtotime(date($DatosFV['facturaventa_Fecha'])."+ 15 days")); ?></li>
                        <li>REMISIÓN: <?php echo $DatosFV['facturaventa_Remision']; ?></li>
                        <li>VENDEDOR: ING. <?php echo datosUsuario($DatosFV['facturaventa_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosFV['facturaventa_Vendedor'])['usuario_Apellido']; ?></li>
                        <li>OBSERVACIONES: <?php echo $DatosFV['facturaventa_Observaciones']; ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Datos del cliente</p>
                        <li>NIT: <?php echo $DatosFV['facturaventa_NitTercero']; ?></li>
                        <li>DV: <?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Dv']; ?></li>
                        <li>RAZON SOCIAL: <?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_RazonSocial']; ?></li>
                        <li>TELEFONO: <?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono1']; ?></li>
                        <li>TELEFONO: <?php if (datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono2'] != 0) { echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono2'];} ?></li>
                        <li>EMAIL: <?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Email']; ?></li>
                        <li>CIUDAD: <?php echo nombreDepartamento(datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Ciudad']); ?></li>
                        <li>DIRECCIÓN: <?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Direccion']; ?></li>
                        <li>FORMA DE PAGO: <?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_FormaPago']; ?></li>
                    </ul>
                    <div class="div_Style"></div>
                    <ul>
                        <p class="txt_Normal">Productos</p>
                        <?php 
                        $cont_Remisiones = 0;
                        $auxContItems = 1;
                        while ($auxContItems <= $contItems) {?>
                            <li>Item #<?php echo $auxContItems; ?></li>
                            <ul>
                                <li>Detalle: <?php echo $DatosRemisiones[$cont_Remisiones]; ?></li>
                                <li>Cantidad: <?php echo $DatosRemisiones[$cont_Remisiones+1]; ?></li>
                                <li>Valor unidad: $ <?php echo number_format($DatosRemisiones[$cont_Remisiones+2]); ?></li>
                                <li>Valor total: $ <?php echo number_format($DatosRemisiones[$cont_Remisiones+3]); ?></li>
                            </ul>
                            <?php
                            $cont_Remisiones = $cont_Remisiones + 4;
                            $auxContItems = $auxContItems + 1;
                        }?>
                    </ul>
                    <div class="div_Style"></div>
                    <p class="txt_Normal">Datos facturación</p>
                    <ul>
                        <li>Subtotal: $ <?php echo number_format($DatosFV['facturaventa_Subtotal']); ?></li>
                        <li>Descuento: <?php echo $DatosFV['facturaventa_PorcentajeDescuento']; ?>%</li>
                        <li>Valor descuento: $ <?php echo number_format($DatosFV['facturaventa_ValorDescuento']); ?></li>
                        <li>IVA 19%: $ <?php echo number_format($DatosFV['facturaventa_ValorIVA_24081001']); ?></li>
                        <li>Retefuente: <?php echo datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_PorcentajeRetefuente']; ?>%</li>
                        <li>Valor retuente: $ <?php echo number_format($DatosFV['facturaventa_ValorRetefuente']); ?></li>
                        <li>Total a pagar: $ <?php echo number_format($DatosFV['facturaventa_ValorTotal']); ?></li>
                    </ul>
                </div>
                <?php
                    if ($DatosFV['facturaventa_Anulada'] != "SI") {?>
                        <form name="form" class="form_Style" method="post" action="../GenerarPDF/factura.php? cc=<?php echo $Documento; ?>&cs=<?php echo $CS; ?>&FV=<?php echo $DatosFV['facturaventa_Id']; ?>">
                            <div>
                                <button type="submit">Generar PDF</button>
                            </div>
                        </form>
                    <?php
                    }
                ?>
            <?php    
            }?>

        </section>

        <?php
            include '../Static/Footer.html';
        ?>

    </body>

</html>