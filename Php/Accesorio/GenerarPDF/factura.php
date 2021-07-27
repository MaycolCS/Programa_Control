<?php

    include '../Funciones.php';
    include 'encabezadoTablas.php';

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

    $IdFacturaVenta = "";
    if (isset($_GET['FV'])) {
        $IdFacturaVenta = $_GET['FV'];

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

    $celdasRelleno = 0;
    if ($contItems == 1) {
        $celdasRelleno = 4;
    } elseif ($contItems == 2) {
        $celdasRelleno = 3;
    } elseif ($contItems == 3) {
        $celdasRelleno = 2;
    } elseif ($contItems == 4) {
        $celdasRelleno = 1;
    } elseif ($contItems == 6 or $contItems == 13 or $contItems == 20 or $contItems == 27 or $contItems == 34 or $contItems == 41 or $contItems == 48 or $contItems == 55 or $contItems == 62 or $contItems == 69 or $contItems == 76 or $contItems == 83 or $contItems == 90 or $contItems == 97 or $contItems == 104 or $contItems == 111 or $contItems == 118 or $contItems == 125 or $contItems == 132 or $contItems == 139 or $contItems == 146 or $contItems == 153 or $contItems == 160 or $contItems == 167 or $contItems == 174 or $contItems == 181 or $contItems == 188 or $contItems == 195 or $contItems == 202 or $contItems == 209 or $contItems == 216 or $contItems == 223 or $contItems == 230 or $contItems == 237 or $contItems == 244 or $contItems == 251 or $contItems == 258 or $contItems == 265 or $contItems == 272 or $contItems == 279 or $contItems == 286) {
        $celdasRelleno = 6;
    } elseif ($contItems == 7 or $contItems == 14 or $contItems == 21 or $contItems == 28 or $contItems == 35 or $contItems == 42 or $contItems == 49 or $contItems == 56 or $contItems == 63 or $contItems == 70 or $contItems == 77 or $contItems == 84 or $contItems == 91 or $contItems == 98 or $contItems == 105 or $contItems == 112 or $contItems == 119 or $contItems == 126 or $contItems == 133 or $contItems == 140 or $contItems == 147 or $contItems == 154 or $contItems == 161 or $contItems == 168 or $contItems == 175 or $contItems == 182 or $contItems == 189 or $contItems == 196 or $contItems == 203 or $contItems == 210 or $contItems == 217 or $contItems == 224 or $contItems == 231 or $contItems == 238 or $contItems == 245 or $contItems == 252 or $contItems == 259 or $contItems == 266 or $contItems == 273 or $contItems == 280 or $contItems == 287) {
        $celdasRelleno = 5;
    } elseif ($contItems == 8 or $contItems == 15 or $contItems == 22 or $contItems == 29 or $contItems == 36 or $contItems == 43 or $contItems == 50 or $contItems == 57 or $contItems == 64 or $contItems == 71 or $contItems == 78 or $contItems == 85 or $contItems == 92 or $contItems == 99 or $contItems == 106 or $contItems == 113 or $contItems == 120 or $contItems == 127 or $contItems == 134 or $contItems == 141 or $contItems == 148 or $contItems == 155 or $contItems == 162 or $contItems == 169 or $contItems == 176 or $contItems == 183 or $contItems == 190 or $contItems == 197 or $contItems == 204 or $contItems == 211 or $contItems == 218 or $contItems == 225 or $contItems == 232 or $contItems == 239 or $contItems == 246 or $contItems == 253 or $contItems == 260 or $contItems == 267 or $contItems == 274 or $contItems == 281 or $contItems == 288) {
        $celdasRelleno = 4;
    } elseif ($contItems == 9 or $contItems == 16 or $contItems == 23 or $contItems == 30 or $contItems == 37 or $contItems == 44 or $contItems == 51 or $contItems == 58 or $contItems == 65 or $contItems == 72 or $contItems == 79 or $contItems == 86 or $contItems == 93 or $contItems == 100 or $contItems == 107 or $contItems == 114 or $contItems == 121 or $contItems == 128 or $contItems == 135 or $contItems == 142 or $contItems == 149 or $contItems == 156 or $contItems == 163 or $contItems == 170 or $contItems == 177 or $contItems == 184 or $contItems == 191 or $contItems == 198 or $contItems == 205 or $contItems == 212 or $contItems == 219 or $contItems == 226 or $contItems == 233 or $contItems == 240 or $contItems == 247 or $contItems == 254 or $contItems == 261 or $contItems == 268 or $contItems == 275 or $contItems == 282) {
        $celdasRelleno = 3;
    } elseif ($contItems == 10 or $contItems == 17 or $contItems == 24 or $contItems == 31 or $contItems == 38 or $contItems == 45 or $contItems == 52 or $contItems == 59 or $contItems == 66 or $contItems == 73 or $contItems == 80 or $contItems == 87 or $contItems == 94 or $contItems == 101 or $contItems == 108 or $contItems == 115 or $contItems == 122 or $contItems == 129 or $contItems == 136 or $contItems == 143 or $contItems == 150 or $contItems == 157 or $contItems == 164 or $contItems == 171 or $contItems == 178 or $contItems == 185 or $contItems == 192 or $contItems == 199 or $contItems == 206 or $contItems == 213 or $contItems == 220 or $contItems == 227 or $contItems == 234 or $contItems == 241 or $contItems == 248 or $contItems == 255 or $contItems == 262 or $contItems == 269 or $contItems == 276 or $contItems == 283) {
        $celdasRelleno = 2;
    } elseif ($contItems == 11 or $contItems == 18 or $contItems == 25 or $contItems == 32 or $contItems == 39 or $contItems == 46 or $contItems == 53 or $contItems == 60 or $contItems == 67 or $contItems == 74 or $contItems == 81 or $contItems == 88 or $contItems == 95 or $contItems == 102 or $contItems == 109 or $contItems == 116 or $contItems == 123 or $contItems == 130 or $contItems == 137 or $contItems == 144 or $contItems == 151 or $contItems == 158 or $contItems == 165 or $contItems == 172 or $contItems == 179 or $contItems == 186 or $contItems == 193 or $contItems == 200 or $contItems == 207 or $contItems == 214 or $contItems == 221 or $contItems == 228 or $contItems == 235 or $contItems == 242 or $contItems == 249 or $contItems == 256 or $contItems == 263 or $contItems == 270 or $contItems == 277 or $contItems == 284) {
        $celdasRelleno = 1;
    }

    $Encabezado = '<table class="tabla_encabezado">
        <tr>
            <td class="datos_empresa_imagen" rowspan="5"><img src="../../Images/cubo.png" width="50px"></td>
            <th class="datos_empresa" colspan="5">'.$nombreEmpresa.'</th>
            <td class="datos_empresa_imagen" rowspan="5"><img src="../../Images/cubo.png" width="50px"></td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$nitEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$emailEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$direccionEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="5">'.$telefonoEmpresa.'</td>
        </tr>
        <tr>
            <td class="datos_empresa" colspan="7">'.$ciudadEmpresa.'</td>
        </tr>
        <tr>
            <td class="espacio_texto" colspan="7">'.$actividadEconomicaEmpresa.'</td>
        </tr>
        <tr>
            <td class="espacio_texto" colspan="7">'.$retencionEmpresa.'</td>
        </tr>
        <tr>
            <td class="espacio_texto" colspan="7">'.$facturacionEmpresa.'</td>
        </tr>
    </table>
    <table class="tabla_encabezado">
        <tr>
            <td class="datos_fijos" rowspan="2">FECHA</td>
            <td class="datos_fijos">AÑO</td>
            <td class="datos_fijos">MES</td>
            <td class="datos_fijos">DÍA</td>
            <td class="datos_empresa" rowspan="2"></td>
            <td class="datos_fijos" rowspan="2">FACTURA DE VENTA</td>
            <td class="datos_variables" rowspan="2">'.$DatosFV['facturaventa_Id'].'</td>
        </tr>
        <tr>
            <td class="datos_variables">'.$DatosFV['facturaventa_Año'].'</td>
            <td class="datos_variables">'.$DatosFV['facturaventa_Mes'].'</td>
            <td class="datos_variables">'.$DatosFV['facturaventa_Dia'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">NIT</td>
            <td class="datos_variables" colspan="2">'.number_format($DatosFV['facturaventa_NitTercero']).'</td>
            <td class="datos_fijos">DV</td>
            <td class="datos_variables">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Dv'].'</td>
            <td class="datos_fijos">FECHA VENCIMIENTO</td>
            <td class="datos_variables">'.date("Y-m-d",strtotime(date($DatosFV['facturaventa_Fecha'])."+".datosTercero($DatosFV['facturaventa_NitTercero'])[9]."days")).'</td>
        </tr>
        <tr>
            <td class="datos_fijos" rowspan="2">RAZON SOCIAL</td>
            <td class="datos_variables" rowspan="2" colspan="4">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_RazonSocial'].'</td>
            <td class="datos_fijos">REMISION</td>
            <td class="datos_variables">'.$DatosFV['facturaventa_Remision'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">TELEFONO</td>
            <td class="datos_variables">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono2'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">TELEFONO</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Telefono1'].'</td>
            <td class="datos_fijos">FORMA DE PAGO</td>
            <td class="datos_variables">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_FormaPago'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">CIUDAD</td>
            <td class="datos_variables" colspan="4">'.nombreDepartamento(datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Ciudad']).'</td>
            <td class="datos_fijos">EMAIL</td>
            <td class="datos_variables">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Email'].'</td>
        </tr>
        <tr>
            <td class="datos_fijos">DIRECCIÓN</td>
            <td class="datos_variables" colspan="4">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_Direccion'].'</td>
            <td class="datos_fijos">VENDEDOR</td>
            <td class="datos_variables">ING. '.datosUsuario($DatosFV['facturaventa_Vendedor'])['usuario_Nombre']." ".datosUsuario($DatosFV['facturaventa_Vendedor'])['usuario_Apellido'].'</td>
        </tr>
        
    </table>';

    $Datos = '
        <table class="tabla_items">
            <tr>
                <th>Item</th>
                <th colspan="3">Detalle</th>
                <th>Cantidad</th>
                <th colspan="2">Precio unidad</th>
                <th colspan="2">Precio total</th>
            </tr>';
            $cont_Remisiones = 0;
            while ($auxContItems <= $contItems) {
                $Datos .= '<tr>
                    <td>'.$auxContItems.'</td>
                    <td colspan="3">'.$DatosRemisiones[$cont_Remisiones].'</td>
                    <td>'.$DatosRemisiones[$cont_Remisiones+1].'</td>
                    <td colspan="2">$ '.number_format($DatosRemisiones[$cont_Remisiones+2]).'</td>
                    <td colspan="2">$ '.number_format($DatosRemisiones[$cont_Remisiones+3]).'</td>
                </tr>';
                $cont_Remisiones = $cont_Remisiones + 4;
                $auxContItems = $auxContItems + 1;
            }
            while ($celdasRelleno > 0) {
                $Datos .= '<tr>
                    <td></td>
                    <td colspan="3"></td>
                    <td></td>
                    <td colspan="2"></td>
                    <td colspan="2"></td>
                </tr>';
                $celdasRelleno = $celdasRelleno-1;
            }
        $Datos .= '</table>

        <table class="tabla_footer">
            <tr>
                <td class="datos_fijos" rowspan="2" colspan="2">VALOR EN LETRAS</td>
                <td class="datos_variables" rowspan="2" colspan="4">'.convertirNumeroLetra(round($DatosFV['facturaventa_ValorTotal'])).' PESOS M/CTE.</td>
                <td class="datos_fijos" colspan="2">SUBTOTAL</td>
                <td class="datos_variables" colspan="2">$ '.number_format($DatosFV['facturaventa_Subtotal']).'</td>
            </tr>
            <tr>
                <td class="datos_fijos">DESCUENTO</td>
                <td class="datos_fijos">'.number_format(round($DatosFV['facturaventa_PorcentajeDescuento'])).'%</td>
                <td class="datos_variables" colspan="2">$ '.number_format($DatosFV['facturaventa_ValorDescuento']).'</td>
            </tr>
            <tr>
                <td class="info" colspan="6">
                    Esta factura de venta constituye titulo valor según lo establecido en la ley 1231 de 2008 según art. 772 al 774 del codigo de comercio.
                </td>
                <td class="datos_fijos">IVA</td>
                <td class="datos_fijos">19%</td>
                <td class="datos_variables" colspan="2">$ '.number_format($DatosFV['facturaventa_ValorIVA_24081001']).'</td>
            </tr>
            <tr>
                <td class="datos_variables" colspan="3" rowspan="2"></td>
                <td class="info" rowspan="3" colspan="3">
                    El valor debe ser consignado en la cuenta de ahorros a nombre de 
                    Grupo Tecnico Empresarial sas del banco caja social No 24 098 446 818. 
                    '.$DatosFV['facturaventa_Observaciones'].'
                </td>
                <td class="datos_fijos">RETEFUENTE</td>
                <td class="datos_fijos">'.datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_PorcentajeRetefuente'].'%</td>
                <td class="datos_variables" colspan="2">$ '.number_format($DatosFV['facturaventa_ValorRetefuente'],1).'</td>
            </tr>
            <tr>
                <td class="datos_fijos" colspan="2" rowspan="2">TOTAL A PAGAR</td>
                <td class="datos_variables" colspan="2" rowspan="2">$ '.number_format($DatosFV['facturaventa_ValorTotal']).'</td>
            </tr>
            <tr>
                <td class="datos_variables" colspan="3">ACEPTO DE CONFORMIDAD</td>
            </tr>
            
        </table>
    ';

    require_once __DIR__ . '../../../PDF/vendor/autoload.php';

    $css = file_get_contents('Style_PDF.css');

    $mpdf = new \Mpdf\Mpdf([
        "format" => "Letter",
        'margin_left' => 10,
        'margin_right' => 10,
        'pagenumPrefix' => 'Página ',
        'nbpgPrefix' => ' de '
    ]);

    $mpdf->SetFooter('{PAGENO}{nbpg}');

    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->setAutoTopMargin = 'stretch';
    $mpdf->SetHTMLHeader($Encabezado);
    $mpdf->AddPage('P');
    $mpdf->WriteHTML($Datos, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output("$IdFacturaVenta ".datosTercero($DatosFV['facturaventa_NitTercero'])['tercero_RazonSocial'].".pdf", "D");
    
?>