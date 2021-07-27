<?php

    header ('Content-type: text/html; charset=utf-8');
    //header("Cache-Control: no-cache, must-revalidate");
        
    function conexionBD() {
        $mysqli = new mysqli();
        $mysqli->set_charset("utf8");
        return $mysqli;
    }

    //*************************************************************************************************************
    //CONSECUTIVOS

    function conexionBDConsecutivos() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM consecutivo";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function datosConsecutivo($TipoConsecutivo) {
        $datos = conexionBDConsecutivos();
        $datosConsecutivo = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($TipoConsecutivo == $fila['consecutivo_Tipo']) {
                $datosConsecutivo = $fila['consecutivo_Sintaxis'].$fila['consecutivo_Numero'];
            }
        }
        return $datosConsecutivo;
    }

    function numeroConsecutivo($TipoConsecutivo) {
        $datos = conexionBDConsecutivos();
        $datosConsecutivo = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if ($TipoConsecutivo == $fila['consecutivo_Tipo']) {
                $datosConsecutivo = $fila['consecutivo_Numero'];
            }
        }
        return $datosConsecutivo;
    }

    function sintaxisConsecutivo($TipoConsecutivo) {
        $datos = conexionBDConsecutivos();
        $datosConsecutivo = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($TipoConsecutivo == $fila['consecutivo_Tipo']) {
                $datosConsecutivo = $fila['consecutivo_Sintaxis'];
            }
        }
        return $datosConsecutivo;
    }

    //*************************************************************************************************************
    //DEPARTAMENTO

    function conexionBDDepartamento() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM departamento";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaDepartamentos() {
        $conexion = conexionBD();
        $listaDepartamentos = array();
        $consulta = "SELECT departamento_Id, departamento_Nombre FROM departamento ORDER BY departamento_Nombre ASC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaDepartamentos, $fila['departamento_Id']);
            array_push($listaDepartamentos, $fila['departamento_Nombre']);
        }
        mysqli_close($conexion);
        return $listaDepartamentos;
    }

    function nombreDepartamento($idDepartamento) {
        $datos = conexionBDDepartamento();
        $nombreDepartamento = "";
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($idDepartamento) == number_format($fila['departamento_Id'])) {
                $nombreDepartamento = $fila['departamento_Nombre'];
            }
        }
        return $nombreDepartamento;
    }

    function IdDepartamento($nombreDepartamento) {
        $datos = conexionBDDepartamento();
        $idDepartamento = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($nombreDepartamento == $fila['departamento_Nombre']) {
                $idDepartamento = $fila['departamento_Id'];
            }
        }
        return $idDepartamento;
    }

    //*********************************************************************************
    //CIUDAD

    function conexionBDCiudad() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM ciudad";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaCiudades($idDepartamento) {
        $conexion = conexionBD();
        $listaCiudades = array();
        $consulta = "SELECT ciudad_Id, ciudad_Nombre FROM ciudad WHERE ciudad_Departamento='$idDepartamento' ORDER BY ciudad_Nombre ASC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaCiudades, $fila['ciudad_Id']);
            array_push($listaCiudades, $fila['ciudad_Nombre']);
        }
        mysqli_close($conexion);
        return $listaCiudades;
    }

    function nombreCiudad($idCiudad) {
        $datos = conexionBDCiudad();
        $nombreCiudad = "";
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($idCiudad) == number_format($fila['ciudad_Id'])) {
                $nombreCiudad = $fila['ciudad_Nombre'];
            }
        }
        return $nombreCiudad;
    }

    function departamentoCiudad($idCiudad) {
        $datos = conexionBDCiudad();
        $nombreDepartamento = "";
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($idCiudad) == number_format($fila['ciudad_Id'])) {
                $nombreDepartamento = $fila['ciudad_Departamento'];
            }
        }
        return $nombreDepartamento;
    }

    function IdCiudad($nombreCiudad) {
        $datos = conexionBDCiudad();
        $idCiudad = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($nombreCiudad == $fila['ciudad_Nombre']) {
                $idCiudad = $fila['ciudad_Id'];
            }
        }
        return $idCiudad;
    }

    //*************************************************************************************************************
    //USUARIO

    function conexionBDUsuario() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM usuario";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaUsuarios() {
        $datos = conexionBDUsuario();
        $listaUsuarios = array();
        while($fila = mysqli_fetch_array($datos)) {
            array_push($listaUsuarios, $fila['usuario_Documento']);
            array_push($listaUsuarios, $fila['usuario_Nombre']);
            array_push($listaUsuarios, $fila['usuario_Apellido']);
        }
        return $listaUsuarios;
    }

    function estaDocumento($Documento) {
        $datos = conexionBDUsuario();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['usuario_Documento']) == number_format($Documento)) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function usuario_TieneAcceso($Documento) {
        $datos = conexionBDUsuario();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['usuario_Documento']) == number_format($Documento)) {
                if ($fila['usuario_Acceso'] == TRUE) {
                    return TRUE;
                    break;
                }
            }
        }
        return FALSE;
    }

    function estaCorreo($Correo) {
        $datos = conexionBDUsuario();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['usuario_Correo'] == $Correo) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function SesionUsuario($Documento,$CS) {
        $datos = conexionBDUsuario();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['usuario_Documento'] == $Documento) {
                if ($fila['usuario_Sesion'] == TRUE) {
                    session_start();
                    if ($fila['usuario_IP'] == session_id()) {
                        session_write_close();
                        if ($fila['usuario_MDSafety'] != NULL) {
                            $MDSafety = md5(($Documento*$CS+$CS/$CS), FALSE);
                            if ($fila['usuario_MDSafety'] == $MDSafety) {
                                return TRUE;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return FALSE;
    }

    function validarPermisosUsuario($Documento,$Permisos) {
        $datos = conexionBDUsuario();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['usuario_Documento']) == number_format($Documento)) {
                for ($i = 0; $i < count($Permisos); $i++) {
                    if ($Permisos[$i] == $fila['usuario_Permiso_1']) {
                        return TRUE;
                        break;
                    } elseif ($Permisos[$i] == $fila['usuario_Permiso_2']) {
                        return TRUE;
                        break;
                    } elseif ($Permisos[$i] == $fila['usuario_Permiso_3']) {
                        return TRUE;
                        break;
                    } elseif ($Permisos[$i] == $fila['usuario_Permiso_4']) {
                        return TRUE;
                        break;
                    }
                }
                return FALSE;
                break;
            }
        }
    }

    function datosUsuario($Documento) {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM usuario WHERE usuario_Documento='$Documento'";
        $datos = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_array($datos);
        mysqli_close($conexion);
        return $fila;
    }

    //*********************************************************************************************************
    //CENTRO DE COSTO

    function conexionBDCentroCosto() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM centro_costo";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaCentrosCosto() {
        $conexion = conexionBD();
        $listaCentrosCosto = array();
        $consulta = "SELECT centro_costo_Id, centro_costo_Consecutivo, centro_costo_Detalle FROM centro_costo ORDER BY centro_costo_Id DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaCentrosCosto, $fila['centro_costo_Consecutivo']);
            array_push($listaCentrosCosto, $fila['centro_costo_Detalle']);
        }
        mysqli_close($conexion);
        return $listaCentrosCosto;
    }

    function nombreCentroCosto($CentroCosto) {
        $datos = conexionBDCentroCosto();
        $nombreArea = "";
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['centro_costo_Id']) == $CentroCosto) {
                $nombreArea = $fila['centro_costo_Consecutivo']." ".$fila['centro_costo_Detalle'];
            }
        }
        return $nombreArea;
    }

    function ConsecutivoCentroCosto() {
        $datos = conexionBDCentroCosto();
        $number = 0;
        while($fila = mysqli_fetch_array($datos)) {
            $number = $number + 1;
        }
        return $number;
    }

    function estaCentroCosto($CentroCosto) {
        $datos = conexionBDCentroCosto();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['centro_costo_Detalle'] == $CentroCosto) {
                return true;
            }
        }
        return false;
    }

    //*********************************************************************************************************
    //FORMA DE PAGO

    function conexionBD_FormaPago() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM formaPago";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function lista_FormaPago() {
        $listaCentrosCosto = array();
        $datos = conexionBD_FormaPago();
        while($fila = mysqli_fetch_array($datos)) {
            array_push($listaCentrosCosto, $fila['formaPago_Id']);
            array_push($listaCentrosCosto, $fila['formaPago_Detalle']);
        }
        mysqli_close($conexion);
        return $listaCentrosCosto;
    }

    function nombre_FormaPago($IdFormaPago) {
        $datos = conexionBD_FormaPago();
        $nombre_FormaPago = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['formaPago_Id'] == $IdFormaPago) {
                $nombre_FormaPago = $fila['formaPago_Detalle'];
            }
        }
        return $nombre_FormaPago;
    }

    //*********************************************************************************************************
    //PUC CUENTA

    function conexionBDPucCuenta() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM puc_cuenta";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaPucCuentas() {
        $conexion = conexionBD();
        $listaCuentas = array();
        $consulta = "SELECT puc_cuenta_Id, puc_cuenta_Detalle FROM puc_cuenta ORDER BY puc_cuenta_Id ASC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaCuentas, $fila['puc_cuenta_Id']);
            array_push($listaCuentas, $fila['puc_cuenta_Detalle']);
        }
        mysqli_close($conexion);
        return $listaCuentas;
    }

    function nombrePucCuenta($IdPucCuenta) {
        $datos = conexionBDPucCuenta();
        $nombreCuenta = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['puc_cuenta_Id'] == $IdPucCuenta) {
                $nombreCuenta = $fila['puc_cuenta_Detalle'];
            }
        }
        return $nombreCuenta;
    }

    function consecutivoPucCuenta($IdPucCuenta) {
        $datos = conexionBDPucCuenta();
        $ConsecutivoSubcuenta = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['puc_cuenta_Id'] == $IdPucCuenta) {
                if ($fila['puc_cuenta_Consecutivo'] != NULL) {
                    $ConsecutivoSubcuenta = ($fila['puc_cuenta_Consecutivo']+5);
                } else {
                    $ConsecutivoSubcuenta = 5;
                }
            }
        }
        return $ConsecutivoSubcuenta;
    }

    function nuevoConsecutivoSubcuenta_PucCuenta($IdPucCuenta) {
        $datos = conexionBDPucCuenta();
        $newConsecutivo = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['puc_cuenta_Id'] == $IdPucCuenta) {
                $ConsecutivoCuenta = $fila['puc_cuenta_Id'];
                settype($ConsecutivoCuenta, 'string');
                if ($fila['puc_cuenta_Consecutivo'] != NULL) {
                    $ConsecutivoSubcuenta = ($fila['puc_cuenta_Consecutivo']+1);
                    settype($ConsecutivoSubcuenta, 'string');
                    $newConsecutivo = $ConsecutivoCuenta.$ConsecutivoSubcuenta;
                } else {
                    $ConsecutivoSubcuenta = 1;
                    settype($ConsecutivoSubcuenta, 'string');
                    $newConsecutivo = $ConsecutivoCuenta."0".$ConsecutivoSubcuenta;
                }
            }
        }
        settype($newConsecutivo, 'int');
        return $newConsecutivo;
    }

    function estaPucCuenta($IdPucCuenta) {
        $datos = conexionBDPucCuenta();
        $validacionSubcuenta = FALSE;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['puc_cuenta_Id'] == $IdPucCuenta) {
                $validacionSubcuenta = TRUE;
            }
        }
        return $validacionSubcuenta;
    }

    //*********************************************************************************************************
    //PUC SUBCUENTA

    function conexionBDPucSubcuenta() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM puc_subcuenta";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaPucSubcuentas() {
        $conexion = conexionBD();
        $listaSubcuentas = array();
        $consulta = "SELECT puc_subcuenta_Id, puc_subcuenta_Detalle, puc_subcuenta_Cuenta FROM puc_subcuenta ORDER BY puc_subcuenta_Id ASC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaSubcuentas, $fila['puc_subcuenta_Id']);
            array_push($listaSubcuentas, $fila['puc_subcuenta_Detalle']);
            array_push($listaSubcuentas, $fila['puc_subcuenta_Cuenta']);
        }
        mysqli_close($conexion);
        return $listaSubcuentas;
    }

    function nombrePucSubcuenta($IdPucSubcuenta) {
        $datos = conexionBDPucSubcuenta();
        $nombresubcuenta = "";
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['puc_subcuenta_Id'] == $IdPucSubcuenta) {
                $nombresubcuenta = $fila['puc_subcuenta_Detalle'];
            }
        }
        return $nombresubcuenta;
    }

    function estaPucSubcuenta($IdPucSubcuenta) {
        $datos = conexionBDPucSubcuenta();
        $validacionSubcuenta = FALSE;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['puc_subcuenta_Id'] == $IdPucSubcuenta) {
                $validacionSubcuenta = TRUE;
            }
        }
        return $validacionSubcuenta;
    }

    //-----------------------------------------------------------------------------------------------------------
    // TERCEROS

    function conexionBDTerceros() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM tercero";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaTerceros() {
        $conexion = conexionBD();
        $datosTercero = array();
        $consulta = "SELECT tercero_Nit, tercero_RazonSocial FROM tercero ORDER BY tercero_RazonSocial ASC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($datosTercero, $fila['tercero_Nit']);
            array_push($datosTercero, $fila['tercero_RazonSocial']);
        }
        mysqli_close($conexion);
        return $datosTercero;
    }

    function nombreTercero($Nit) {
        $datos = conexionBDTerceros();
        $nombreTercero = "";
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($Nit) == number_format($fila['tercero_Nit'])) {
                $nombreTercero = $fila['tercero_RazonSocial'];
                break;
            }
        }
        return $nombreTercero;
    }

    function estaTercero($Nit) {
        $datos = conexionBDTerceros();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['tercero_Nit'] == $Nit) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function datosTercero($Nit) {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM tercero WHERE tercero_Nit='$Nit'";
        $datos = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_array($datos);
        mysqli_close($conexion);
        return $fila;
    }

    function conexionBDPlantaTercero() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM planta_tercero";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaPlantaTerceros($NitTercero) {
        $datos = conexionBDPlantaTercero();
        $datosPlantaTercero = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['planta_tercero_NitTercero']) == number_format($NitTercero)) {
                array_push($datosPlantaTercero, $fila['planta_tercero_Id']);
                array_push($datosPlantaTercero, $fila['planta_tercero_Ciudad']);
                array_push($datosPlantaTercero, $fila['planta_tercero_Departamento']);
                array_push($datosPlantaTercero, $fila['planta_tercero_Direccion']);
            }
        }
        return $datosPlantaTercero;
    }

    function estaPlantaTercero($NitTercero,$ContactoPlanta,$Departamento,$Ciudad,$Direccion) {
        $datos = conexionBDPlantaTercero();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['planta_tercero_NitTercero']) == number_format($NitTercero)) {
                if ($fila['planta_tercero_Contacto'] == $ContactoPlanta) {
                    if (number_format($fila['planta_tercero_Departamento']) == number_format($Departamento)) {
                        if (number_format($fila['planta_tercero_Ciudad']) == number_format($Ciudad)) {
                            if ($fila['planta_tercero_Direccion'] == $Direccion) {
                                return TRUE;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return FALSE;
    }

    function tienePlantasTercero($NitTercero) {
        $datos = conexionBDPlantaTercero();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['planta_tercero_NitTercero']) == number_format($NitTercero)) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function datosPlantaTercero($IdPlantaTercero) {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM planta_tercero WHERE planta_tercero_Id='$IdPlantaTercero'";
        $datos = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_array($datos);
        mysqli_close($conexion);
        return $fila;
    }

    //-----------------------------------------------------------------------------------------------------------
    // PRODUCTOS - MALLAS - TIPO

    function conexionBD_Mallas_Tipo() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM malla_Tipo ORDER BY malla_Tipo_Detalle ASC";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function lista_Mallas_Tipo() {
        $datos = conexionBD_Mallas_Tipo();
        $Lista_Mallas_Tipo = array();
        while($fila = mysqli_fetch_array($datos)) {
            array_push($Lista_Mallas_Tipo, $fila['malla_Tipo_Id']);
            array_push($Lista_Mallas_Tipo, $fila['malla_Tipo_Detalle']);
        }
        return $Lista_Mallas_Tipo;
    }

    function esta_Malla_Tipo($Detalle_Malla_Tipo) {
        $datos = conexionBD_Mallas_Tipo();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Tipo_Detalle'] == $Detalle_Malla_Tipo) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function esta_Malla_Tipo_Id($Id_Malla_Tipo) {
        $datos = conexionBD_Mallas_Tipo();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Tipo_Id'] == $Id_Malla_Tipo) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function detalle_Malla_Tipo($Id_Malla_Tipo) {
        $datos = conexionBD_Mallas_Tipo();
        $detalle_Malla_Tipo = "";
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['malla_Tipo_Id']) == number_format($Id_Malla_Tipo)) {
                $detalle_Malla_Tipo = $fila['malla_Tipo_Detalle'];
            }
        }
        return $detalle_Malla_Tipo;
    }

    function insertar_Malla_Tipo($Detalle_Malla_Tipo) {
        $conn = conexionBD();
        $sql = "INSERT INTO malla_Tipo (malla_Tipo_Detalle) VALUES ('$Detalle_Malla_Tipo')";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function eliminar_Malla_Tipo($Id_Malla_Tipo) {
        $conn = conexionBD();
        $sql = "DELETE FROM malla_Tipo WHERE malla_Tipo_Id='$Id_Malla_Tipo'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------------------------------------------------------------
    // PRODUCTOS - MALLAS - HUECO

    function conexionBD_Mallas_Hueco() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM malla_Hueco ORDER BY malla_Hueco_Detalle ASC";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function lista_Mallas_Hueco() {
        $datos = conexionBD_Mallas_Hueco();
        $Lista_Mallas_Hueco = array();
        while($fila = mysqli_fetch_array($datos)) {
            array_push($Lista_Mallas_Hueco, $fila['malla_Hueco_Id']);
            array_push($Lista_Mallas_Hueco, $fila['malla_Hueco_Detalle']);
            array_push($Lista_Mallas_Hueco, $fila['malla_Hueco_Medida']);
        }
        return $Lista_Mallas_Hueco;
    }

    function esta_Malla_Hueco($Detalle_Malla_Hueco, $Medida_Malla_Hueco) {
        $datos = conexionBD_Mallas_Hueco();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Hueco_Detalle'] == $Detalle_Malla_Hueco) {
                if ($fila['malla_Hueco_Medida'] == $Medida_Malla_Hueco) {
                    return TRUE;
                    break;
                }
            }
        }
        return FALSE;
    }

    function esta_Malla_Hueco_Id($Id_Malla_Hueco) {
        $datos = conexionBD_Mallas_Hueco();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Hueco_Id'] == $Id_Malla_Hueco) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function datos_Malla_Hueco($Id_Malla_Hueco) {
        $datos = conexionBD_Mallas_Hueco();
        $datos_Malla_Hueco = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['malla_Hueco_Id']) == number_format($Id_Malla_Hueco)) {
                array_push($datos_Malla_Hueco, $fila['malla_Hueco_Detalle']);
                array_push($datos_Malla_Hueco, $fila['malla_Hueco_Medida']);
            }
        }
        return $datos_Malla_Hueco;
    }

    function insertar_Malla_Hueco($Detalle_Malla_Hueco, $Medida_Malla_Hueco) {
        $conn = conexionBD();
        $sql = "INSERT INTO malla_Hueco (malla_Hueco_Detalle, malla_Hueco_Medida) VALUES ('$Detalle_Malla_Hueco','$Medida_Malla_Hueco')";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function eliminar_Malla_Hueco($Id_Malla_Hueco) {
        $conn = conexionBD();
        $sql = "DELETE FROM malla_Hueco WHERE malla_Hueco_Id='$Id_Malla_Hueco'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------------------------------------------------------------
    // PRODUCTOS - MALLAS - CALIBRE

    function conexionBD_Mallas_Calibre() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM malla_Calibre ORDER BY malla_Calibre_Detalle ASC";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function lista_Mallas_Calibre() {
        $datos = conexionBD_Mallas_Calibre();
        $Lista_Mallas_Calibre = array();
        while($fila = mysqli_fetch_array($datos)) {
            array_push($Lista_Mallas_Calibre, $fila['malla_Calibre_Id']);
            array_push($Lista_Mallas_Calibre, $fila['malla_Calibre_Detalle']);
            array_push($Lista_Mallas_Calibre, $fila['malla_Calibre_Medida']);
        }
        return $Lista_Mallas_Calibre;
    }

    function esta_Malla_Calibre($Detalle_Malla_Calibre, $Medida_Malla_Calibre) {
        $datos = conexionBD_Mallas_Calibre();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Calibre_Detalle'] == $Detalle_Malla_Calibre) {
                if ($fila['malla_Calibre_Medida'] == $Medida_Malla_Calibre) {
                    return TRUE;
                    break;
                }
            }
        }
        return FALSE;
    }

    function esta_Malla_Calibre_Id($Id_Malla_Calibre) {
        $datos = conexionBD_Mallas_Calibre();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Calibre_Id'] == $Id_Malla_Calibre) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function datos_Malla_Calibre($Id_Malla_Calibre) {
        $datos = conexionBD_Mallas_Calibre();
        $datos_Malla_Calibre = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['malla_Calibre_Id']) == number_format($Id_Malla_Calibre)) {
                array_push($datos_Malla_Calibre, $fila['malla_Calibre_Detalle']);
                array_push($datos_Malla_Calibre, $fila['malla_Calibre_Medida']);
            }
        }
        return $datos_Malla_Calibre;
    }

    function insertar_Malla_Calibre($Detalle_Malla_Calibre, $Medida_Malla_Calibre) {
        $conn = conexionBD();
        $sql = "INSERT INTO malla_Calibre (malla_Calibre_Detalle, malla_Calibre_Medida) VALUES ('$Detalle_Malla_Calibre','$Medida_Malla_Calibre')";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function eliminar_Malla_Calibre($Id_Malla_Calibre) {
        $conn = conexionBD();
        $sql = "DELETE FROM malla_Calibre WHERE malla_Calibre_Id='$Id_Malla_Calibre'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------------------------------------------------------------
    // PRODUCTOS - MALLAS

    function conexionBD_Mallas() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM malla ORDER BY malla_Tipo ASC";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function lista_Mallas() {
        $datos = conexionBD_Mallas();
        $Lista_Mallas = array();
        while($fila = mysqli_fetch_array($datos)) {
            array_push($Lista_Mallas, $fila['malla_Id']);
            array_push($Lista_Mallas, detalle_Malla_Tipo($fila['malla_Tipo']));
            array_push($Lista_Mallas, (datos_Malla_Hueco($fila['malla_Hueco'])[0]." - ".datos_Malla_Hueco($fila['malla_Hueco'])[1])); //Detalle - Medida
            array_push($Lista_Mallas, (datos_Malla_Calibre($fila['malla_Calibre'])[0]." - ".datos_Malla_Calibre($fila['malla_Calibre'])[1])); //Detalle - Medida
        }
        return $Lista_Mallas;
    }

    function lista_Mallas_Hueco_Filtro_Tipo($Malla_Tipo) {
        $datos = conexionBD_Mallas();
        $Lista_Mallas = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Tipo'] == $Malla_Tipo) {
                $Validacion = FALSE;
                if (count($Lista_Mallas) > 0) {
                    for ($i = 0; $i < count($Lista_Mallas); $i += 3) {
                        if ($Lista_Mallas[$i] == $fila['malla_Hueco']) {
                            $Validacion = TRUE;
                        }
                    }
                }
                if ($Validacion == FALSE) {
                    array_push($Lista_Mallas, $fila['malla_Hueco']);
                    array_push($Lista_Mallas, datos_Malla_Hueco($fila['malla_Hueco'])[0]);
                    array_push($Lista_Mallas, datos_Malla_Hueco($fila['malla_Hueco'])[1]);
                }
            }
        }
        return $Lista_Mallas;
    }

    function lista_Mallas_Calibre_Filtro_Tipo_Hueco($Malla_Tipo, $Malla_Hueco) {
        $datos = conexionBD_Mallas();
        $Lista_Mallas = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Tipo'] == $Malla_Tipo) {
                if ($fila['malla_Hueco'] == $Malla_Hueco) {
                    $Validacion = FALSE;
                    if (count($Lista_Mallas) > 0) {
                        for ($i = 0; $i < count($Lista_Mallas); $i += 3) {
                            if ($Lista_Mallas[$i] == $fila['malla_Calibre']) {
                                $Validacion = TRUE;
                            }
                        }
                    }
                    if ($Validacion == FALSE) {
                        array_push($Lista_Mallas, $fila['malla_Calibre']);
                        array_push($Lista_Mallas, datos_Malla_Calibre($fila['malla_Calibre'])[0]);
                        array_push($Lista_Mallas, datos_Malla_Calibre($fila['malla_Calibre'])[1]);
                    }
                }
            }
        }
        return $Lista_Mallas;
    }

    function esta_Malla($Malla_Tipo, $Malla_Hueco, $Malla_Calibre) {
        $datos = conexionBD_Mallas();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Tipo'] == $Malla_Tipo) {
                if ($fila['malla_Hueco'] == $Malla_Hueco) {
                    if ($fila['malla_Calibre'] == $Malla_Calibre) {
                        return TRUE;
                        break;
                    }
                }
            }
        }
        return FALSE;
    }

    function obtener_Id_Malla($Malla_Tipo, $Malla_Hueco, $Malla_Calibre) {
        $datos = conexionBD_Mallas();
        $Id_Malla = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['malla_Tipo'] == $Malla_Tipo) {
                if ($fila['malla_Hueco'] == $Malla_Hueco) {
                    if ($fila['malla_Calibre'] == $Malla_Calibre) {
                        $Id_Malla = $fila['malla_Id'];
                        break;
                    }
                }
            }
        }
        return $Id_Malla;
    }

    function datos_Malla($Id_Malla) {
        $datos = conexionBD_Mallas();
        $datos_Malla = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['malla_Id']) == number_format($Id_Malla)) {
                array_push($datos_Malla, detalle_Malla_Tipo($fila['malla_Tipo']));
                array_push($datos_Malla, (datos_Malla_Hueco($fila['malla_Hueco'])[0]." - ".datos_Malla_Hueco($fila['malla_Hueco'])[1])); //Detalle - Medida
                array_push($datos_Malla, (datos_Malla_Calibre($fila['malla_Calibre'])[0]." - ".datos_Malla_Calibre($fila['malla_Calibre'])[1])); //Detalle - Medida
                array_push($datos_Malla, $fila['malla_Peso']);
                array_push($datos_Malla, $fila['malla_Horas']);
                array_push($datos_Malla, $fila['malla_PrecioActual']);
                array_push($datos_Malla, $fila['malla_PrecioAnterior']);
                array_push($datos_Malla, $fila['malla_Usuario']);
            }
        }
        return $datos_Malla;
    }

    function insertar_Malla($Malla_Tipo, $Malla_Hueco, $Malla_Calibre, $Malla_Peso, $Malla_Horas, $Malla_PrecioActual, $Malla_Usuario) {
        $conn = conexionBD();
        $sql = "INSERT INTO malla (malla_Tipo, malla_Hueco, malla_Calibre, malla_Peso, malla_Horas, malla_PrecioActual, malla_Usuario) VALUES ('$Malla_Tipo','$Malla_Hueco','$Malla_Calibre','$Malla_Peso','$Malla_Horas','$Malla_PrecioActual','$Malla_Usuario')";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function actualizar_Precio_Malla($Id_Malla, $Malla_Peso, $Malla_Horas, $Malla_PrecioActual, $Malla_Usuario) {
        $conn = conexionBD();
        $Malla_PrecioAnterior = datos_Malla($Id_Malla)[5];
        $sql = "UPDATE malla Set malla_Peso='$Malla_Peso', malla_Horas='$Malla_Horas', malla_PrecioActual='$Malla_PrecioActual', malla_PrecioAnterior='$Malla_PrecioAnterior', malla_Usuario='$Malla_Usuario' WHERE malla_Id='$Id_Malla'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function actualizar_Precio_Mallas($PorcentajeAumento, $Malla_Usuario) {
        $Lista_Mallas = lista_Mallas();
        $conn = conexionBD();
        $Validacion = FALSE;
        for ($i = 0; $i < count($Lista_Mallas); $i += 4) {
            $Id_Malla = $Lista_Mallas[$i];
            $Datos_Malla = datos_Malla($Id_Malla);
            $Malla_PrecioActual = $Datos_Malla[5]+($Datos_Malla[5]*($PorcentajeAumento/100));
            $Malla_PrecioAnterior = $Datos_Malla[5];
            $sql = "UPDATE malla Set malla_PrecioActual='$Malla_PrecioActual', malla_PrecioAnterior='$Malla_PrecioAnterior', malla_Usuario='$Malla_Usuario' WHERE malla_Id='$Id_Malla'";
            if (mysqli_query($conn, $sql)) {
                $Validacion = TRUE;
            } else {
                $Validacion = FALSE;
            }
        }
        mysqli_close($conn);
        return $Validacion;
    }

    function eliminar_Malla($Id_Malla) {
        $conn = conexionBD();
        $sql = "DELETE FROM malla WHERE malla_Id='$Id_Malla'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------------------------------------------------------------
    // PRODUCTOS - ACCESORIOS

    function conexionBD_Accesorio() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM accesorio";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function lista_accesorios() {
        $datos = conexionBD_Accesorio();
        $Lista_accesorio = array();
        while($fila = mysqli_fetch_array($datos)) {
            array_push($Lista_accesorio, $fila['accesorio_Id']);
            array_push($Lista_accesorio, $fila['accesorio_Detalle']);
        }
        return $Lista_accesorio;
    }

    function esta_accesorio($Detalle_accesorio) {
        $datos = conexionBD_Accesorio();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['accesorio_Detalle'] == $Detalle_accesorio) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function esta_accesorio_Id($Id_accesorio) {
        $datos = conexionBD_Accesorio();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['accesorio_Id'] == $Id_accesorio) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function datos_accesorio($Id_accesorio) {
        $datos = conexionBD_Accesorio();
        $datos_accesorio = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['accesorio_Id']) == number_format($Id_accesorio)) {
                array_push($datos_accesorio, $fila['accesorio_Detalle']);
                array_push($datos_accesorio, $fila['accesorio_Precio']);
                array_push($datos_accesorio, $fila['accesorio_Usuario']);
            }
        }
        return $datos_accesorio;
    }

    function insertar_accesorio($Detalle_accesorio, $Precio_accesorio, $Usuario) {
        $conn = conexionBD();
        $sql = "INSERT INTO accesorio (accesorio_Detalle, accesorio_Precio, accesorio_Usuario) VALUES ('$Detalle_accesorio','$Precio_accesorio','$Usuario')";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function actualizar_accesorio($Id_accesorio, $Precio_accesorio, $Usuario) {
        $conn = conexionBD();
        $sql = "UPDATE accesorio Set accesorio_Precio='$Precio_accesorio', accesorio_Usuario='$Usuario' WHERE accesorio_Id='$Id_accesorio'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function eliminar_accesorio($Id_accesorio) {
        $conn = conexionBD();
        $sql = "DELETE FROM accesorio WHERE accesorio_Id='$Id_accesorio'";
        if (mysqli_query($conn, $sql)) {
            mysqli_close($conn);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------------------------------------------------------------
    // COTIZACIONES

    function conexionBDCotizacionItemsProv() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM cotizacion_itemsprovisional";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaItemsProvCotizacion($IdProvisional) {
        $datos = conexionBDCotizacionItemsProv();
        $listaItemsProvCotizacion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['cotizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_DetalleProducto']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_CantidadProducto']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_PrecioProducto']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_ValorTotal']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsprovisional_Id']);
            }
        }
        return $listaItemsProvCotizacion;
    }

    function estaItemProvCotizacion($IdProvisional,$DetalleItemProv) {
        $datos = conexionBDCotizacionItemsProv();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['cotizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                if ($fila['cotizacion_itemsProvisional_DetalleProducto'] == $DetalleItemProv) {
                    return TRUE;
                    break;
                }
            }
        }
        return FALSE;
    }

    function estaCodeProvCotizacion($IdProvisional) {
        $datos = conexionBDCotizacionItemsProv();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['cotizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function cantidadItemSProvCotizacion($IdProvisional) {
        $datos = conexionBDCotizacionItemsProv();
        $CantidadItems = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['cotizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                $CantidadItems += 1;
            }
        }
        return $CantidadItems;
    }

    function conexionBDCotizacion() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM cotizacion";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaCotizaciones() {
        $conexion = conexionBD();
        $listaCotizaciones = array();
        $consulta = "SELECT cotizacion_Consecutivo, cotizacion_Id, cotizacion_NitTercero FROM cotizacion ORDER BY cotizacion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaCotizaciones, $fila['cotizacion_Id']);
            array_push($listaCotizaciones, datosTercero($fila['cotizacion_NitTercero'])[2]);
        }
        mysqli_close($conexion);
        return $listaCotizaciones;
    }

    function listaCotizacionesTercero($NitTercero) {
        $conexion = conexionBD();
        $listaCotizacionesTercero = array();
        $consulta = "SELECT cotizacion_Consecutivo, cotizacion_Id, cotizacion_Fecha, cotizacion_ValorTotal FROM cotizacion WHERE cotizacion_NitTercero='$NitTercero' ORDER BY cotizacion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaCotizacionesTercero, $fila['cotizacion_Id']);
            array_push($listaCotizacionesTercero, $fila['cotizacion_Fecha']);
        }
        mysqli_close($conexion);
        return $listaCotizacionesTercero;
    }

    function listaCotizaciones_SinFacturar() {
        $conexion = conexionBD();
        $listaCotizaciones = array();
        $consulta = "SELECT cotizacion_Consecutivo, cotizacion_Id, cotizacion_NitTercero, cotizacion_Facturada, cotizacion_Fecha, cotizacion_Anulada FROM cotizacion ORDER BY cotizacion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (date("Y-m-d") <= date("Y-m-d",strtotime(date($fila['cotizacion_Fecha'])."+ 15 days"))) {
                if ($fila['cotizacion_Facturada'] == FALSE) {
                    if ($fila['cotizacion_Anulada'] == "NO") {
                        array_push($listaCotizaciones, $fila['cotizacion_Id']);
                        array_push($listaCotizaciones, datosTercero($fila['cotizacion_NitTercero'])[2]);
                    }
                }
            }
        }
        mysqli_close($conexion);
        return $listaCotizaciones;
    }

    function listaCotizaciones_SinPlanillaProduccion($Tercero) {
        $conexion = conexionBD();
        $listaCotizaciones = array();
        $consulta = "";
        if ($Tercero == 0) {
            $consulta = "SELECT cotizacion_Consecutivo, cotizacion_Id, cotizacion_NitTercero, cotizacion_Fecha, cotizacion_Anulada FROM cotizacion ORDER BY cotizacion_Consecutivo DESC";
        } else {
            $consulta = "SELECT cotizacion_Consecutivo, cotizacion_Id, cotizacion_NitTercero, cotizacion_Fecha, cotizacion_Anulada FROM cotizacion WHERE cotizacion_NitTercero='$Tercero' ORDER BY cotizacion_Consecutivo DESC";
        }
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (date("Y-m-d") <= date("Y-m-d",strtotime(date($fila['cotizacion_Fecha'])."+ 15 days"))) {
                if (!CotizacionTienePlanilla($fila['cotizacion_Id'])) {
                    if ($fila['cotizacion_Anulada'] == "NO") {
                        array_push($listaCotizaciones, $fila['cotizacion_Id']);
                        array_push($listaCotizaciones, datosTercero($fila['cotizacion_NitTercero'])[2]);
                    }
                }
            }
        }
        mysqli_close($conexion);
        return $listaCotizaciones;
    }

    function listaCotizacionesSinAnular() {
        $conexion = conexionBD();
        $listaCotizaciones = array();
        $consulta = "SELECT cotizacion_Consecutivo, cotizacion_Id, cotizacion_NitTercero, cotizacion_Anulada FROM cotizacion ORDER BY cotizacion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Anulada'] == "NO") {
                array_push($listaCotizaciones, $fila['cotizacion_Id']);
                array_push($listaCotizaciones, datosTercero($fila['cotizacion_NitTercero'])[2]);
            }
        }
        mysqli_close($conexion);
        return $listaCotizaciones;
    }

    function listaCotizacionesSinAnular_Tercero($NitTercero) {
        $conexion = conexionBD();
        $listaCotizacionesTercero = array();
        $consulta = "SELECT cotizacion_Consecutivo, cotizacion_Id, cotizacion_Fecha, cotizacion_ValorTotal, cotizacion_Anulada FROM cotizacion WHERE cotizacion_NitTercero='$NitTercero' ORDER BY cotizacion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Anulada'] == "NO") {
                array_push($listaCotizacionesTercero, $fila['cotizacion_Id']);
                array_push($listaCotizacionesTercero, $fila['cotizacion_Fecha']);
            }
        }
        mysqli_close($conexion);
        return $listaCotizacionesTercero;
    }

    function listaCotizacionesSinPP() {
        $conexion = conexionBD();
        $listaCotizaciones = array();
        $consulta = "SELECT cotizacion_Id, cotizacion_NitTercero, cotizacion_Anulada FROM cotizacion ORDER BY cotizacion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (!CotizacionTienePlanilla($fila['cotizacion_Id'])) {
                if ($fila['cotizacion_Anulada'] == "NO") {
                    array_push($listaCotizaciones, $fila['cotizacion_Id']);
                    array_push($listaCotizaciones, datosTercero($fila['cotizacion_NitTercero'])[2]);
                }
            }
        }
        mysqli_close($conexion);
        return $listaCotizaciones;
    }

    function listaCotizacionesHistoricoCliente($Tercero) {
        $conexion = conexionBD();
        $listaFV = array();
        $consulta = "SELECT cotizacion_Fecha, cotizacion_Id, cotizacion_NitTercero, cotizacion_Subtotal, cotizacion_ValorDescuento, cotizacion_Anulada FROM cotizacion ORDER BY cotizacion_Fecha DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Anulada'] == "NO") {
                if ($fila['cotizacion_NitTercero'] == $Tercero) {
                    array_push($listaFV, $fila['cotizacion_Fecha']);
                    array_push($listaFV, $fila['cotizacion_Id']);
                    array_push($listaFV, ($fila['cotizacion_Subtotal']-$fila['cotizacion_ValorDescuento']));
                }
            }
        }
        mysqli_close($conexion);
        return $listaFV;
    }

    function valorTotalCotizacionesHistoricoCliente($Tercero) {
        $conexion = conexionBD();
        $totalCotizaciones = 0;
        $consulta = "SELECT cotizacion_Fecha, cotizacion_NitTercero, cotizacion_Subtotal, cotizacion_ValorDescuento, cotizacion_Anulada FROM cotizacion";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Anulada'] == "NO") {
                if ($fila['cotizacion_NitTercero'] == $Tercero) {
                    $totalCotizaciones += ($fila['cotizacion_Subtotal']-$fila['cotizacion_ValorDescuento']);
                }
            }
        }
        mysqli_close($conexion);
        return $totalCotizaciones;
    }

    function estaCotizacion($IdCotizacion) {
        $conexion = conexionBD();
        $ValidacionCotizacion = FALSE;
        $consulta = "SELECT cotizacion_Id FROM cotizacion";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Id'] == $IdCotizacion) {
                $ValidacionCotizacion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $ValidacionCotizacion;
    }

    function Cotizacion_Anulada($IdCotizacion) {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT cotizacion_Anulada FROM cotizacion WHERE cotizacion_Id='$IdCotizacion'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Anulada'] == "SI") {
                $Validacion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function Cotizacion_Facturada($IdCotizacion) {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT cotizacion_Facturada FROM cotizacion WHERE cotizacion_Id='$IdCotizacion'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Facturada'] == TRUE) {
                $Validacion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function cotizacion_DisponibleFecha($IdCotizacion) {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT cotizacion_Fecha FROM cotizacion WHERE cotizacion_Id='$IdCotizacion'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (date("Y-m-d") <= date("Y-m-d",strtotime(date($fila['cotizacion_Fecha'])."+ 15 days"))) {
                $Validacion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function CotizacionTienePlanilla($IdCotizacion) {
        $conexion = conexionBD();
        $validacion = FALSE;
        $consulta = "SELECT planilla_produccion_Id FROM planilla_produccion WHERE planilla_produccion_Cotizacion='$IdCotizacion'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            $validacion = TRUE;
            break;
        }
        mysqli_close($conexion);
        return $validacion;
    }

    function Cotizacion_PlanillasProduccion($IdCotizacion) {
        $conexion = conexionBD();
        $formato = substr(sintaxisConsecutivo("PP"), 0,(strlen(sintaxisConsecutivo("PP"))-3));
        $Planillas = "";
        $consulta = "SELECT planilla_produccion_Id FROM planilla_produccion WHERE planilla_produccion_Cotizacion='$IdCotizacion'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            $Planillas .= " - ".substr($fila['planilla_produccion_Id'], (strlen($formato)+1));
        }
        if ($Planillas == "") {
            $formato = "";
        }
        mysqli_close($conexion);
        return $formato.$Planillas;
    }

    function datosCotizacion($IdCotizacion) {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM cotizacion WHERE cotizacion_Id='$IdCotizacion'";
        $datos = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_array($datos);
        mysqli_close($conexion);
        return $fila;
    }

    function itemsCotizacion($IdCotizacion) {
        $datos = conexionBDCotizacion();
        $datosCotizacion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_Id'] == $IdCotizacion) {
                if ($fila['cotizacion_Detalle_Item1'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item1']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item1']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item1']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item1']);
                }
                
                if ($fila['cotizacion_Detalle_Item2'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item2']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item2']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item2']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item2']);
                }

                if ($fila['cotizacion_Detalle_Item3'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item3']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item3']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item3']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item3']);
                }

                if ($fila['cotizacion_Detalle_Item4'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item4']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item4']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item4']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item4']);
                }

                if ($fila['cotizacion_Detalle_Item5'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item5']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item5']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item5']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item5']);
                }

                if ($fila['cotizacion_Detalle_Item6'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item6']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item6']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item6']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item6']);
                }

                if ($fila['cotizacion_Detalle_Item7'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item7']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item7']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item7']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item7']);
                }

                if ($fila['cotizacion_Detalle_Item8'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item8']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item8']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item8']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item8']);
                }

                if ($fila['cotizacion_Detalle_Item9'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item9']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item9']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item9']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item9']);
                }

                if ($fila['cotizacion_Detalle_Item10'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item10']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item10']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item10']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item10']);
                }

                if ($fila['cotizacion_Detalle_Item11'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item11']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item11']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item11']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item11']);
                }

                if ($fila['cotizacion_Detalle_Item12'] != "") {
                    array_push($datosCotizacion, $fila['cotizacion_Detalle_Item12']);
                    array_push($datosCotizacion, $fila['cotizacion_Cantidad_Item12']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorUnidad_Item12']);
                    array_push($datosCotizacion, $fila['cotizacion_ValorTotal_Item12']);
                }
            }
        }
        return $datosCotizacion;
    }

    //-----------------------------------------------------------------------------------------------------------
    // PLANILLAS DE PRODUCCIÓN - PLANTA

    function conexionBDPlanillaProduccionPlanta() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM cotizacion_PlanillaPlanta";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function obtenerDatosProvisionalesParaPlanillaPlanta($IdProvisional) {
        $datos = conexionBDCotizacionItemsProv();
        $listaItemsProvCotizacion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['cotizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_TipoProducto']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_IdProducto']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_DetalleProducto']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_itemsProvisional_CantidadProducto']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_Tipo']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_Hueco']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_Calibre']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_Ancho']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_Gancho']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_TipoGancho']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_Largo']);
                array_push($listaItemsProvCotizacion, $fila['cotizacion_Malla_Traslapo']);
            }
        }
        return $listaItemsProvCotizacion;
    }

    function insertarDatosPlanillaPlanta($IdProvisional,$Cotizacion) {
        $conn = conexionBD();
        $Datos = obtenerDatosProvisionalesParaPlanillaPlanta($IdProvisional);
        for ($i = 0; $i < count($Datos); $i += 12) {
            $TipoProducto = $Datos[$i];
            $Producto = $Datos[$i+1];
            $DetalleProducto = $Datos[$i+2];
            $CantidadProducto = $Datos[$i+3];
            $Malla_Tipo = $Datos[$i+4];
            $Malla_Hueco = $Datos[$i+5];
            $Malla_Calibre = $Datos[$i+6];
            $Malla_Ancho = $Datos[$i+7];
            $Malla_Gancho = $Datos[$i+8];
            $Malla_TipoGancho = $Datos[$i+9];
            $Malla_Largo = $Datos[$i+10];
            $Malla_Traslapo = $Datos[$i+11];
            $conn = conexionBD();
            $sql = "INSERT INTO cotizacion_PlanillaPlanta 
                                (cotizacion_PlanillaPlanta_Cotizacion,
                                cotizacion_PlanillaPlanta_TipoProducto,
                                cotizacion_PlanillaPlanta_Producto,
                                cotizacion_PlanillaPlanta_Detalle,
                                cotizacion_PlanillaPlanta_Cantidad,
                                cotizacion_PlanillaPlanta_TipoMalla,
                                cotizacion_PlanillaPlanta_HuecoMalla,
                                cotizacion_PlanillaPlanta_CalibreMalla,
                                cotizacion_PlanillaPlanta_AnchoMalla,
                                cotizacion_PlanillaPlanta_GanchoMalla,
                                cotizacion_PlanillaPlanta_TipoGanchoMalla,
                                cotizacion_PlanillaPlanta_LargoMalla,
                                cotizacion_PlanillaPlanta_TraslapoMalla) 
                                VALUES 
                                ('$Cotizacion',
                                '$TipoProducto',
                                '$Producto',
                                '$DetalleProducto',
                                '$CantidadProducto',
                                '$Malla_Tipo',
                                '$Malla_Hueco',
                                '$Malla_Calibre',
                                '$Malla_Ancho',
                                '$Malla_Gancho',
                                '$Malla_TipoGancho',
                                '$Malla_Largo',
                                '$Malla_Traslapo')";
            mysqli_query($conn, $sql);
        }
        mysqli_close($conn);
    }

    function actualizarDatosPlanillaPlanta($Cotizacion, $DetalleItem, $CantidadItem) {
        $conn = conexionBD();
        $sql = "UPDATE cotizacion_PlanillaPlanta Set cotizacion_PlanillaPlanta_Cantidad='$CantidadItem' WHERE cotizacion_PlanillaPlanta_Cotizacion='$Cotizacion' AND cotizacion_PlanillaPlanta_Detalle='$DetalleItem'";
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }

    function obtenerDatos_PlanillaPlanta_Mallas($Cotizacion, $PlanillaProduccion) {
        $datos = conexionBDPlanillaProduccionPlanta();
        $itemsPP = itemsPlanilla($PlanillaProduccion);
        $listaItems = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_PlanillaPlanta_Cotizacion'] == $Cotizacion) {
                if (number_format($fila['cotizacion_PlanillaPlanta_TipoProducto']) == 1) {
                    for ($i = 0; $i < count($itemsPP); $i += 4) {
                        if ($itemsPP[$i] == $fila['cotizacion_PlanillaPlanta_Detalle']) {
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_TipoMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_HuecoMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_CalibreMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_AnchoMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_GanchoMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_TipoGanchoMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_LargoMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_TraslapoMalla']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_Cantidad']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_Producto']);
                        }
                    }
                }
            }
        }
        return $listaItems;
    }

    function obtenerDatos_PlanillaPlanta_Accesorios($Cotizacion, $PlanillaProduccion) {
        $datos = conexionBDPlanillaProduccionPlanta();
        $itemsPP = itemsPlanilla($PlanillaProduccion);
        $listaItems = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_PlanillaPlanta_Cotizacion'] == $Cotizacion) {
                if (number_format($fila['cotizacion_PlanillaPlanta_TipoProducto']) == 2) {
                    for ($i = 0; $i < count($itemsPP); $i += 4) {
                        if ($itemsPP[$i] == $fila['cotizacion_PlanillaPlanta_Detalle']) {
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_Detalle']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_Cantidad']);
                        }
                    }
                }
            }
        }
        return $listaItems;
    }

    function obtenerDatos_PlanillaPlanta_Otros($Cotizacion, $PlanillaProduccion) {
        $datos = conexionBDPlanillaProduccionPlanta();
        $itemsPP = itemsPlanilla($PlanillaProduccion);
        $listaItems = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['cotizacion_PlanillaPlanta_Cotizacion'] == $Cotizacion) {
                if (number_format($fila['cotizacion_PlanillaPlanta_TipoProducto']) == 3) {
                    for ($i = 0; $i < count($itemsPP); $i += 4) {
                        if ($itemsPP[$i] == $fila['cotizacion_PlanillaPlanta_Detalle']) {
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_Detalle']);
                            array_push($listaItems, $fila['cotizacion_PlanillaPlanta_Cantidad']);
                        }
                    }
                }
            }
        }
        return $listaItems;
    }

    //-----------------------------------------------------------------------------------------------------------
    // PLANILLAS DE PRODUCCIÓN

    function conexionBDPlanillaProduccion() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM planilla_produccion";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaPlanillasProduccion() {
        $conexion = conexionBD();
        $listaPlanillasProduccion = array();
        $consulta = "SELECT planilla_produccion_Consecutivo, planilla_produccion_Id, planilla_produccion_NitTercero FROM planilla_produccion ORDER BY planilla_produccion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaPlanillasProduccion, $fila['planilla_produccion_Id']);
            array_push($listaPlanillasProduccion, datosTercero($fila['planilla_produccion_NitTercero'])[2]);
        }
        mysqli_close($conexion);
        return $listaPlanillasProduccion;
    }

    function listaPlanillasProduccionIncompletas() {
        $conexion = conexionBD();
        $listaPlanillasProduccion = array();
        $consulta = "SELECT planilla_produccion_Consecutivo, planilla_produccion_Id, planilla_produccion_NitTercero, planilla_produccion_Anulada, planilla_produccion_Completa FROM planilla_produccion ORDER BY planilla_produccion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['planilla_produccion_Anulada'] == "NO") {
                if ($fila['planilla_produccion_Completa'] == FALSE) {
                    array_push($listaPlanillasProduccion, $fila['planilla_produccion_Id']);
                    array_push($listaPlanillasProduccion, datosTercero($fila['planilla_produccion_NitTercero'])[2]);
                }
            }
        }
        mysqli_close($conexion);
        return $listaPlanillasProduccion;
    }

    /*function IdPlanillaProduccionRemision($IdRemision) {
        $conexion = conexionBD();
        $IdPlanillaProduccion = "";
        $consulta = "SELECT planilla_produccion_Id FROM planilla_produccion WHERE planilla_produccion_Remision='$IdRemision'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            $IdPlanillaProduccion = $fila['planilla_produccion_Id'];
        }
        mysqli_close($conexion);
        return $IdPlanillaProduccion;
    }*/
    
    function PlanillaProduccion_IdCotizacion($IdPlanilla) {
        $conexion = conexionBD();
        $IdCotizacion = "";
        $consulta = "SELECT planilla_produccion_Cotizacion FROM planilla_produccion WHERE planilla_produccion_Id='$IdPlanilla'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            $IdCotizacion = $fila['planilla_produccion_Cotizacion'];
        }
        mysqli_close($conexion);
        return $IdCotizacion;
    }

    function RemisionesPlanillaProduccion($IdPlanilla) {
        $conexion = conexionBD();
        $formato = substr(sintaxisConsecutivo("REMISION"), 0,(strlen(sintaxisConsecutivo("REMISION"))-3));
        $Remisiones = "";
        $consulta = "SELECT remision_Id FROM remision WHERE remision_PlanillaProduccion='$IdPlanilla'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            $Remisiones .= " - ".substr($fila['remision_Id'], (strlen($formato)+1));
        }
        if ($Remisiones == "") {
            $formato = "";
        }
        mysqli_close($conexion);
        return $formato.$Remisiones;
    }

    function PlanillaProduccionTieneRemision($IdPlanilla) {
        $conexion = conexionBD();
        $validacion = FALSE;
        $consulta = "SELECT remision_Id FROM remision WHERE remision_PlanillaProduccion='$IdPlanilla'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            $validacion = TRUE;
            break;
        }
        mysqli_close($conexion);
        return $validacion;
    }

    function estaPlanillaProduccion($IdPlanillaProduccion) {
        $conexion = conexionBD();
        $ValidacionPlanillaProduccion = FALSE;
        $consulta = "SELECT planilla_produccion_Id FROM planilla_produccion";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['planilla_produccion_Id'] == $IdPlanillaProduccion) {
                $ValidacionPlanillaProduccion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $ValidacionPlanillaProduccion;
    }

    function estaAnuladaPlanillaProduccion($IdPlanillaProduccion) {
        $conexion = conexionBD();
        $ValidacionPlanillaProduccion = FALSE;
        $consulta = "SELECT planilla_produccion_Anulada FROM planilla_produccion WHERE planilla_produccion_Id='$IdPlanillaProduccion'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['planilla_produccion_Anulada'] == "SI") {
                $ValidacionPlanillaProduccion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $ValidacionPlanillaProduccion;
    }

    function estaDisponiblePlanillaProduccion($IdPlanillaProduccion) {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT planilla_produccion_Id, planilla_produccion_Anulada, planilla_produccion_Completa FROM planilla_produccion WHERE planilla_produccion_Id='$IdPlanillaProduccion'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (($fila['planilla_produccion_Anulada'] == "NO") and ($fila['planilla_produccion_Completa'] == FALSE)) {
                $Validacion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function PlanillasProduccion_ComprobacionFaltantes() {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT planilla_produccion_Anulada, planilla_produccion_Completa, planilla_produccion_Fecha, planilla_produccion_TiempoEntrega FROM planilla_produccion ORDER BY planilla_produccion_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (date("Y-m-d") >= date("Y-m-d",strtotime(date($fila['planilla_produccion_Fecha'])."+ ".$fila['planilla_produccion_TiempoEntrega']." days"))) {
                if ($fila['planilla_produccion_Anulada'] == "NO") {
                    if ($fila['planilla_produccion_Completa'] == FALSE) {
                        $Validacion = TRUE;
                    }
                }
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function datosPlanillaProduccion($IdPlanillaProduccion) {
        /*$datos = conexionBDPlanillaProduccion();
        $datosPlanillaProduccion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['planilla_produccion_Id'] == $IdPlanillaProduccion) {
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Id']); //0
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Año']); //1
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Mes']); //2
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Dia']); //3
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_NitTercero']); //4
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_DVTercero']); //5
                array_push($datosPlanillaProduccion, datosTercero($fila['planilla_produccion_NitTercero'])[2]); //6
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Telefono1Tercero']); //7
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Telefono2Tercero']); //8
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_EmailTercero']); //9
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_CiudadTercero']); //10
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_DireccionTercero']); //11
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ContactoTercero']); //12
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_FormaPago']); //13
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_TiempoEntrega']); //14
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_CiudadEntrega']); //15
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_DireccionEntrega']); //16

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item1']); //17
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item1']); //18
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item1']); //19
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item1']); //20

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item2']); //21
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item2']); //22
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item2']); //23
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item2']); //24

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item3']); //25
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item3']); //26
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item3']); //27
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item3']); //28

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item4']); //29
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item4']); //30
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item4']); //31
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item4']); //32

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item5']); //33
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item5']); //34
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item5']); //35
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item5']); //36

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item6']); //37
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item6']); //38
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item6']); //39
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item6']); //40

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item7']); //41
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item7']); //42
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item7']); //43
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item7']); //44

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item8']); //45
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item8']); //46
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item8']); //47
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item8']); //48

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item9']); //49
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item9']); //50
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item9']); //51
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item9']); //52

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item10']); //53
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item10']); //54
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item10']); //55
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item10']); //56

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item11']); //57
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item11']); //58
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item11']); //59
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item11']); //60

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item12']); //61
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item12']); //62
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item12']); //63
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item12']); //64

                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Subtotal']); //65
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_PorcentajeDescuento']); //66
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorDescuento']); //67
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorIVA']); //68
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal']); //69
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Vendedor']); //70
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Remision']); //71
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cotizacion']); //72
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Fecha']); //73
                array_push($datosPlanillaProduccion, $fila['planilla_produccion_Anulada']); //74
            }
        }
        return $datosPlanillaProduccion;*/

        $conexion = conexionBD();
        $consulta = "SELECT * FROM planilla_produccion WHERE planilla_produccion_Id='$IdPlanillaProduccion'";
        $datos = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_array($datos);
        mysqli_close($conexion);
        return $fila;
    }

    function itemsPlanilla($IdPlanillaProduccion) {
        $datos = conexionBDPlanillaProduccion();
        $datosPlanillaProduccion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['planilla_produccion_Id'] == $IdPlanillaProduccion) {
                if ($fila['planilla_produccion_Detalle_Item1'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item1']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item1']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item1']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item1']);
                }
                
                if ($fila['planilla_produccion_Detalle_Item2'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item2']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item2']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item2']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item2']);
                }

                if ($fila['planilla_produccion_Detalle_Item3'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item3']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item3']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item3']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item3']);
                }

                if ($fila['planilla_produccion_Detalle_Item4'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item4']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item4']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item4']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item4']);
                }

                if ($fila['planilla_produccion_Detalle_Item5'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item5']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item5']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item5']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item5']);
                }

                if ($fila['planilla_produccion_Detalle_Item6'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item6']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item6']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item6']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item6']);
                }

                if ($fila['planilla_produccion_Detalle_Item7'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item7']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item7']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item7']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item7']);
                }

                if ($fila['planilla_produccion_Detalle_Item8'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item8']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item8']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item8']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item8']);
                }

                if ($fila['planilla_produccion_Detalle_Item9'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item9']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item9']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item9']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item9']);
                }

                if ($fila['planilla_produccion_Detalle_Item10'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item10']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item10']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item10']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item10']);
                }

                if ($fila['planilla_produccion_Detalle_Item11'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item11']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item11']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item11']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item11']);
                }

                if ($fila['planilla_produccion_Detalle_Item12'] != "") {
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Detalle_Item12']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_Cantidad_Item12']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorUnidad_Item12']);
                    array_push($datosPlanillaProduccion, $fila['planilla_produccion_ValorTotal_Item12']);
                }
            }
        }
        return $datosPlanillaProduccion;
    }

    function saberItemPlanillado($IdCotizacion, $Detalle, $ValorUnitario) {
        $conexion = conexionBD();
        $CantidadRestanteItem = 0;
        $consulta = "SELECT * FROM planilla_produccion WHERE planilla_produccion_Cotizacion='$IdCotizacion'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['planilla_produccion_Anulada'] != "SI") {
                if ($fila['planilla_produccion_Detalle_Item1'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item1'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item1'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item2'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item2'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item2'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item3'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item3'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item3'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item4'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item4'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item4'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item5'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item5'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item5'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item6'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item6'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item6'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item7'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item7'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item7'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item8'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item8'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item8'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item9'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item9'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item9'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item10'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item10'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item10'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item11'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item11'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item11'];
                    }
                }
                if ($fila['planilla_produccion_Detalle_Item12'] == $Detalle) {
                    if ($fila['planilla_produccion_ValorUnidad_Item12'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['planilla_produccion_Cantidad_Item12'];
                    }
                }
            }
        }
        mysqli_close($conexion);
        return $CantidadRestanteItem;
    }

    //-----------------------------------------------------------------------------------------------------------
    // REMISIONES

    function conexionBDRemision() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM remision";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaRemisiones() {
        $conexion = conexionBD();
        $listaRemisiones = array();
        $consulta = "SELECT remision_Consecutivo, remision_Id, remision_NitTercero FROM remision ORDER BY remision_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaRemisiones, $fila['remision_Id']);
            array_push($listaRemisiones, datosTercero($fila['remision_NitTercero'])[2]);
        }
        mysqli_close($conexion);
        return $listaRemisiones;
    }

    function listaRemisionesSinFacturaVenta() {
        $conexion = conexionBD();
        $listaRemisiones = array();
        $consulta = "SELECT remision_Consecutivo, remision_Id, remision_NitTercero, remision_Anulada FROM remision ORDER BY remision_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (!Remision_TieneFacturaVenta($fila['remision_Id'])) {
                if ($fila['remision_Anulada'] == "NO") {
                    array_push($listaRemisiones, $fila['remision_Id']);
                    array_push($listaRemisiones, datosTercero($fila['remision_NitTercero'])[2]);
                }
            }
        }
        mysqli_close($conexion);
        return $listaRemisiones;
    }

    function listaRemisionesSinFacturaVentaTercero($Tercero) {
        $conexion = conexionBD();
        $listaRemisiones = array();
        $consulta = "SELECT remision_Consecutivo, remision_Id, remision_NitTercero, remision_Anulada, remision_NitTercero FROM remision ORDER BY remision_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['remision_NitTercero']) == number_format($Tercero)) {
                if (!Remision_TieneFacturaVenta($fila['remision_Id'])) {
                    if ($fila['remision_Anulada'] == "NO") {
                        array_push($listaRemisiones, $fila['remision_Id']);
                        array_push($listaRemisiones, datosTercero($fila['remision_NitTercero'])[2]);
                    }
                }
            }
        }
        mysqli_close($conexion);
        return $listaRemisiones;
    }

    function listaRemisionesHistoricoCliente($Tercero) {
        $conexion = conexionBD();
        $listaREM = array();
        $consulta = "SELECT remision_Fecha, remision_Id, remision_NitTercero, remision_Subtotal, remision_ValorDescuento, remision_PlanillaProduccion, remision_Anulada FROM remision ORDER BY remision_Fecha DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Anulada'] == "NO") {
                if ($fila['remision_NitTercero'] == $Tercero) {
                    array_push($listaREM, $fila['remision_Fecha']);
                    array_push($listaREM, $fila['remision_Id']);
                    array_push($listaREM, $fila['remision_PlanillaProduccion']);
                    array_push($listaREM, ($fila['remision_Subtotal']-$fila['remision_ValorDescuento']));
                }
            }
        }
        mysqli_close($conexion);
        return $listaREM;
    }

    function valorTotalRemisionesHistoricoCliente($Tercero) {
        $conexion = conexionBD();
        $totalRemisiones = 0;
        $consulta = "SELECT remision_Fecha, remision_NitTercero, remision_Subtotal, remision_ValorDescuento, remision_Anulada FROM remision";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Anulada'] == "NO") {
                if ($fila['remision_NitTercero'] == $Tercero) {
                    $totalRemisiones += ($fila['remision_Subtotal']-$fila['remision_ValorDescuento']);
                }
            }
        }
        mysqli_close($conexion);
        return $totalRemisiones;
    }

    function listaRemisionesSinFacturar() {
        $conexion = conexionBD();
        $listaREM = array();
        $consulta = "SELECT remision_Fecha, remision_Id, remision_NitTercero, remision_ValorTotal, remision_Anulada FROM remision ORDER BY remision_Fecha DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Anulada'] == "NO") {
                if (!Remision_TieneFacturaVenta($fila['remision_Id'])) {
                    array_push($listaREM, $fila['remision_Fecha']);
                    array_push($listaREM, $fila['remision_Id']);
                    array_push($listaREM, $fila['remision_NitTercero']);
                    array_push($listaREM, datosTercero($fila['remision_NitTercero'])[2]);
                    array_push($listaREM, $fila['remision_ValorTotal']);
                }
            }
        }
        mysqli_close($conexion);
        return $listaREM;
    }

    function IdPlanillaProduccion_Remision($IdRemision) {
        $conexion = conexionBD();
        $IdPlanillaProduccion = "";
        $consulta = "SELECT remision_Id, remision_PlanillaProduccion FROM remision WHERE remision_Id='$IdRemision'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            $IdPlanillaProduccion = $fila['remision_PlanillaProduccion'];
        }
        mysqli_close($conexion);
        return $IdPlanillaProduccion;
    }

    function estaRemision($IdRemision) {
        $conexion = conexionBD();
        $ValidacionRemision = FALSE;
        $consulta = "SELECT remision_Id FROM remision";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Id'] == $IdRemision) {
                $ValidacionRemision = TRUE;
            }
        }
        mysqli_close($conexion);
        return $ValidacionRemision;
    }

    function estaDisponibleRemision($IdRemision) {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT remision_Id, remision_Anulada FROM remision WHERE remision_Id='$IdRemision'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Anulada'] == "NO" and !Remision_TieneFacturaVenta($fila['remision_Id'])) {
                $Validacion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function estaAnuladaRemision($IdRemision) {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT remision_Id, remision_Anulada FROM remision WHERE remision_Id='$IdRemision'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Anulada'] == "SI") {
                $Validacion = TRUE;
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function Remisiones_ComprobacionFaltantes() {
        $conexion = conexionBD();
        $Validacion = FALSE;
        $consulta = "SELECT remision_Id, remision_Anulada FROM remision";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Anulada'] == "NO") {
                if (!Remision_TieneFacturaVenta($fila['remision_Id'])) {
                    $Validacion = TRUE;
                    break;
                }
            }
        }
        mysqli_close($conexion);
        return $Validacion;
    }

    function Remision_TieneFacturaVenta($IdRemision) {
        $conexion = conexionBD();
        $validacion = FALSE;
        $consulta = "SELECT facturaventa_Id 
                        FROM facturaventa 
                        WHERE 
                        facturaventa_Remision1='$IdRemision' OR
                        facturaventa_Remision2='$IdRemision' OR
                        facturaventa_Remision3='$IdRemision' OR
                        facturaventa_Remision4='$IdRemision' OR
                        facturaventa_Remision5='$IdRemision' OR
                        facturaventa_Remision6='$IdRemision' OR
                        facturaventa_Remision7='$IdRemision' OR
                        facturaventa_Remision8='$IdRemision' OR
                        facturaventa_Remision9='$IdRemision' OR
                        facturaventa_Remision10='$IdRemision' OR
                        facturaventa_Remision11='$IdRemision' OR
                        facturaventa_Remision12='$IdRemision' OR
                        facturaventa_Remision13='$IdRemision' OR
                        facturaventa_Remision14='$IdRemision' OR
                        facturaventa_Remision15='$IdRemision' OR
                        facturaventa_Remision16='$IdRemision' OR
                        facturaventa_Remision17='$IdRemision' OR
                        facturaventa_Remision18='$IdRemision' OR
                        facturaventa_Remision19='$IdRemision' OR
                        facturaventa_Remision20='$IdRemision' OR
                        facturaventa_Remision21='$IdRemision' OR
                        facturaventa_Remision22='$IdRemision' OR
                        facturaventa_Remision23='$IdRemision' OR
                        facturaventa_Remision24='$IdRemision'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            $validacion = TRUE;
            break;
        }
        mysqli_close($conexion);
        return $validacion;
    }

    function Remision_FacturaVenta($IdRemision) {
        $conexion = conexionBD();
        $formato = substr(sintaxisConsecutivo("FV"), 0,(strlen(sintaxisConsecutivo("FV"))-3));
        $Remisiones = "";
        $consulta = "SELECT facturaventa_Id 
                        FROM facturaventa 
                        WHERE 
                        facturaventa_Remision1='$IdRemision' OR
                        facturaventa_Remision2='$IdRemision' OR
                        facturaventa_Remision3='$IdRemision' OR
                        facturaventa_Remision4='$IdRemision' OR
                        facturaventa_Remision5='$IdRemision' OR
                        facturaventa_Remision6='$IdRemision' OR
                        facturaventa_Remision7='$IdRemision' OR
                        facturaventa_Remision8='$IdRemision' OR
                        facturaventa_Remision9='$IdRemision' OR
                        facturaventa_Remision10='$IdRemision' OR
                        facturaventa_Remision11='$IdRemision' OR
                        facturaventa_Remision12='$IdRemision' OR
                        facturaventa_Remision13='$IdRemision' OR
                        facturaventa_Remision14='$IdRemision' OR
                        facturaventa_Remision15='$IdRemision' OR
                        facturaventa_Remision16='$IdRemision' OR
                        facturaventa_Remision17='$IdRemision' OR
                        facturaventa_Remision18='$IdRemision' OR
                        facturaventa_Remision19='$IdRemision' OR
                        facturaventa_Remision20='$IdRemision' OR
                        facturaventa_Remision21='$IdRemision' OR
                        facturaventa_Remision22='$IdRemision' OR
                        facturaventa_Remision23='$IdRemision' OR
                        facturaventa_Remision24='$IdRemision'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            $Remisiones .= " - ".substr($fila['facturaventa_Id'], (strlen($formato)+1));
        }
        if ($Remisiones == "") {
            $formato = "";
        }
        mysqli_close($conexion);
        return $formato.$Remisiones;
    }

    function datosRemision($IdRemision) {
        /*$datos = conexionBDRemision();
        $datosRemision = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Id'] == $IdRemision) {
                array_push($datosRemision, $fila['remision_Id']); //0
                array_push($datosRemision, $fila['remision_Año']); //1
                array_push($datosRemision, $fila['remision_Mes']); //2
                array_push($datosRemision, $fila['remision_Dia']); //3
                array_push($datosRemision, $fila['remision_NitTercero']); //4
                array_push($datosRemision, $fila['remision_DVTercero']); //5
                array_push($datosRemision, datosTercero($fila['remision_NitTercero'])[2]); //6
                array_push($datosRemision, $fila['remision_Telefono1Tercero']); //7
                array_push($datosRemision, $fila['remision_Telefono2Tercero']); //8
                array_push($datosRemision, $fila['remision_EmailTercero']); //9
                array_push($datosRemision, $fila['remision_CiudadTercero']); //10
                array_push($datosRemision, $fila['remision_DireccionTercero']); //11
                array_push($datosRemision, $fila['remision_ContactoTercero']); //12
                array_push($datosRemision, $fila['remision_FormaPago']); //13
                array_push($datosRemision, $fila['remision_TiempoEntrega']); //14
                array_push($datosRemision, $fila['remision_CiudadEntrega']); //15
                array_push($datosRemision, $fila['remision_DireccionEntrega']); //16

                array_push($datosRemision, $fila['remision_Detalle_Item1']); //17
                array_push($datosRemision, $fila['remision_Cantidad_Item1']); //18
                array_push($datosRemision, $fila['remision_ValorUnidad_Item1']); //19
                array_push($datosRemision, $fila['remision_ValorTotal_Item1']); //20

                array_push($datosRemision, $fila['remision_Detalle_Item2']); //21
                array_push($datosRemision, $fila['remision_Cantidad_Item2']); //22
                array_push($datosRemision, $fila['remision_ValorUnidad_Item2']); //23
                array_push($datosRemision, $fila['remision_ValorTotal_Item2']); //24

                array_push($datosRemision, $fila['remision_Detalle_Item3']); //25
                array_push($datosRemision, $fila['remision_Cantidad_Item3']); //26
                array_push($datosRemision, $fila['remision_ValorUnidad_Item3']); //27
                array_push($datosRemision, $fila['remision_ValorTotal_Item3']); //28

                array_push($datosRemision, $fila['remision_Detalle_Item4']); //29
                array_push($datosRemision, $fila['remision_Cantidad_Item4']); //30
                array_push($datosRemision, $fila['remision_ValorUnidad_Item4']); //31
                array_push($datosRemision, $fila['remision_ValorTotal_Item4']); //32

                array_push($datosRemision, $fila['remision_Detalle_Item5']); //33
                array_push($datosRemision, $fila['remision_Cantidad_Item5']); //34
                array_push($datosRemision, $fila['remision_ValorUnidad_Item5']); //35
                array_push($datosRemision, $fila['remision_ValorTotal_Item5']); //36

                array_push($datosRemision, $fila['remision_Detalle_Item6']); //37
                array_push($datosRemision, $fila['remision_Cantidad_Item6']); //38
                array_push($datosRemision, $fila['remision_ValorUnidad_Item6']); //39
                array_push($datosRemision, $fila['remision_ValorTotal_Item6']); //40

                array_push($datosRemision, $fila['remision_Detalle_Item7']); //41
                array_push($datosRemision, $fila['remision_Cantidad_Item7']); //42
                array_push($datosRemision, $fila['remision_ValorUnidad_Item7']); //43
                array_push($datosRemision, $fila['remision_ValorTotal_Item7']); //44

                array_push($datosRemision, $fila['remision_Detalle_Item8']); //45
                array_push($datosRemision, $fila['remision_Cantidad_Item8']); //46
                array_push($datosRemision, $fila['remision_ValorUnidad_Item8']); //47
                array_push($datosRemision, $fila['remision_ValorTotal_Item8']); //48

                array_push($datosRemision, $fila['remision_Detalle_Item9']); //49
                array_push($datosRemision, $fila['remision_Cantidad_Item9']); //50
                array_push($datosRemision, $fila['remision_ValorUnidad_Item9']); //51
                array_push($datosRemision, $fila['remision_ValorTotal_Item9']); //52

                array_push($datosRemision, $fila['remision_Detalle_Item10']); //53
                array_push($datosRemision, $fila['remision_Cantidad_Item10']); //54
                array_push($datosRemision, $fila['remision_ValorUnidad_Item10']); //55
                array_push($datosRemision, $fila['remision_ValorTotal_Item10']); //56

                array_push($datosRemision, $fila['remision_Detalle_Item11']); //57
                array_push($datosRemision, $fila['remision_Cantidad_Item11']); //58
                array_push($datosRemision, $fila['remision_ValorUnidad_Item11']); //59
                array_push($datosRemision, $fila['remision_ValorTotal_Item11']); //60

                array_push($datosRemision, $fila['remision_Detalle_Item12']); //61
                array_push($datosRemision, $fila['remision_Cantidad_Item12']); //62
                array_push($datosRemision, $fila['remision_ValorUnidad_Item12']); //63
                array_push($datosRemision, $fila['remision_ValorTotal_Item12']); //64

                array_push($datosRemision, $fila['remision_Subtotal']); //65
                array_push($datosRemision, $fila['remision_PorcentajeDescuento']); //66
                array_push($datosRemision, $fila['remision_ValorDescuento']); //67
                array_push($datosRemision, $fila['remision_ValorIVA']); //68
                array_push($datosRemision, $fila['remision_ValorTotal']); //69
                array_push($datosRemision, $fila['remision_Vendedor']); //70
                array_push($datosRemision, $fila['remision_FacturaVenta']); //71
                array_push($datosRemision, $fila['remision_PlanillaProduccion']); //72
                array_push($datosRemision, $fila['remision_OrdenCompra']); //73
                array_push($datosRemision, $fila['remision_Fecha']); //74
                array_push($datosRemision, $fila['remision_Anulada']); //75
            }
        }
        return $datosRemision;*/

        $conexion = conexionBD();
        $consulta = "SELECT * FROM remision WHERE remision_Id='$IdRemision'";
        $datos = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_array($datos);
        mysqli_close($conexion);
        return $fila;
    }

    function itemsRemision($IdRemision) {
        $datos = conexionBDRemision();
        $datosRemision = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Id'] == $IdRemision) {
                if ($fila['remision_Detalle_Item1'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item1']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item1']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item1']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item1']);
                }
                
                if ($fila['remision_Detalle_Item2'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item2']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item2']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item2']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item2']);
                }

                if ($fila['remision_Detalle_Item3'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item3']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item3']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item3']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item3']);
                }

                if ($fila['remision_Detalle_Item4'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item4']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item4']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item4']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item4']);
                }

                if ($fila['remision_Detalle_Item5'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item5']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item5']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item5']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item5']);
                }

                if ($fila['remision_Detalle_Item6'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item6']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item6']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item6']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item6']);
                }

                if ($fila['remision_Detalle_Item7'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item7']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item7']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item7']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item7']);
                }

                if ($fila['remision_Detalle_Item8'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item8']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item8']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item8']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item8']);
                }

                if ($fila['remision_Detalle_Item9'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item9']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item9']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item9']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item9']);
                }

                if ($fila['remision_Detalle_Item10'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item10']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item10']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item10']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item10']);
                }

                if ($fila['remision_Detalle_Item11'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item11']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item11']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item11']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item11']);
                }

                if ($fila['remision_Detalle_Item12'] != "") {
                    array_push($datosRemision, $fila['remision_Detalle_Item12']);
                    array_push($datosRemision, $fila['remision_Cantidad_Item12']);
                    array_push($datosRemision, $fila['remision_ValorUnidad_Item12']);
                    array_push($datosRemision, $fila['remision_ValorTotal_Item12']);
                }
            }
        }
        return $datosRemision;
    }

    function contItemsRemision($IdRemision) {
        $datos = conexionBDRemision();
        $cont = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Id'] == $IdRemision) {
                if ($fila['remision_Detalle_Item1'] != "") {
                    $cont = $cont + 1;
                }
                
                if ($fila['remision_Detalle_Item2'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item3'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item4'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item5'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item6'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item7'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item8'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item9'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item10'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item11'] != "") {
                    $cont = $cont + 1;
                }

                if ($fila['remision_Detalle_Item12'] != "") {
                    $cont = $cont + 1;
                }
            }
        }
        return $cont;
    }

    function saberCantidadItemRemisionado($IdPlanilla, $Detalle, $ValorUnitario) {
        $conexion = conexionBD();
        $CantidadRestanteItem = 0;
        $consulta = "SELECT * FROM remision WHERE remision_PlanillaProduccion='$IdPlanilla'";
        $datos = mysqli_query($conexion, $consulta);
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['remision_Anulada'] != "SI") {
                if ($fila['remision_Detalle_Item1'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item1'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item1'];
                    }
                }
                if ($fila['remision_Detalle_Item2'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item2'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item2'];
                    }
                }
                if ($fila['remision_Detalle_Item3'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item3'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item3'];
                    }
                }
                if ($fila['remision_Detalle_Item4'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item4'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item4'];
                    }
                }
                if ($fila['remision_Detalle_Item5'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item5'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item5'];
                    }
                }
                if ($fila['remision_Detalle_Item6'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item6'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item6'];
                    }
                }
                if ($fila['remision_Detalle_Item7'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item7'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item7'];
                    }
                }
                if ($fila['remision_Detalle_Item8'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item8'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item8'];
                    }
                }
                if ($fila['remision_Detalle_Item9'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item9'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item9'];
                    }
                }
                if ($fila['remision_Detalle_Item10'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item10'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item10'];
                    }
                }
                if ($fila['remision_Detalle_Item11'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item11'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item11'];
                    }
                }
                if ($fila['remision_Detalle_Item12'] == $Detalle) {
                    if ($fila['remision_ValorUnidad_Item12'] == $ValorUnitario) {
                        $CantidadRestanteItem += $fila['remision_Cantidad_Item12'];
                    }
                }
            }
        }
        mysqli_close($conexion);
        return $CantidadRestanteItem;
    }

    //-----------------------------------------------------------------------------------------------------------
    // FACTURA DE VENTA

    function conexionBD_FVProvisional() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM facturaventa_provisional";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaRemisiones_ProvFV($IdProvisional) {
        $datos = conexionBD_FVProvisional();
        $listaItemsProvCotizacion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['facturaventa_Provisional_CodeProv']) == number_format($IdProvisional)) {
                array_push($listaItemsProvCotizacion, $fila['facturaventa_Provisional_Remision']);
                array_push($listaItemsProvCotizacion, $fila['facturaventa_Provisional_Valor']);
                array_push($listaItemsProvCotizacion, $fila['facturaventa_Provisional_Id']);
            }
        }
        return $listaItemsProvCotizacion;
    }

    function countRemisiones_ProvFV($IdProvisional) {
        $datos = conexionBD_FVProvisional();
        $cont = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['facturaventa_Provisional_CodeProv']) == number_format($IdProvisional)) {
                $cont = $cont + 1;
            }
        }
        return $cont;
    }

    function estaRemision__ProvFV($IdProvisional,$Remision) {
        $datos = conexionBD_FVProvisional();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['facturaventa_Provisional_CodeProv']) == number_format($IdProvisional)) {
                if ($fila['facturaventa_Provisional_Remision'] == $Remision) {
                    return TRUE;
                    break;
                }
            }
        }
        return FALSE;
    }

    function estaCodeProvFV($IdProvisional) {
        $datos = conexionBD_FVProvisional();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['facturaventa_Provisional_CodeProv']) == number_format($IdProvisional)) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function conexionBDFacturaVenta() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM facturaventa";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaFacturasVenta() {
        $conexion = conexionBD();
        $listaFV = array();
        $consulta = "SELECT facturaventa_Consecutivo, facturaventa_Id, facturaventa_NitTercero FROM facturaventa ORDER BY facturaventa_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            array_push($listaFV, $fila['facturaventa_Id']);
            array_push($listaFV, datosTercero($fila['facturaventa_NitTercero'])[2]);
        }
        mysqli_close($conexion);
        return $listaFV;
    }

    function listaFacturasVentaTercero($Tercero) {
        $conexion = conexionBD();
        $listaFV = array();
        $consulta = "SELECT facturaventa_Consecutivo, facturaventa_Id, facturaventa_NitTercero, facturaventa_Anulada, facturaventa_NitTercero FROM facturaventa ORDER BY facturaventa_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['facturaventa_NitTercero']) == number_format($Tercero)) {
                if ($fila['facturaventa_Anulada'] == "NO") {
                    array_push($listaFV, $fila['facturaventa_Id']);
                    array_push($listaFV, datosTercero($fila['facturaventa_NitTercero'])[2]);
                }
            }
        }
        mysqli_close($conexion);
        return $listaFV;
    }

    function listaFacturasVentaSinAnular() {
        $conexion = conexionBD();
        $listaFV = array();
        $consulta = "SELECT facturaventa_Consecutivo, facturaventa_Id, facturaventa_NitTercero, facturaventa_Anulada FROM facturaventa ORDER BY facturaventa_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Anulada'] == "NO") {
                array_push($listaFV, $fila['facturaventa_Id']);
                array_push($listaFV, datosTercero($fila['facturaventa_NitTercero'])[2]);
            }
        }
        mysqli_close($conexion);
        return $listaFV;
    }

    function listaFacturasVentaHistoricoCliente($Tercero) {
        $conexion = conexionBD();
        $listaFV = array();
        $consulta = "SELECT facturaventa_Fecha, facturaventa_Id, facturaventa_NitTercero, facturaventa_Subtotal, facturaventa_ValorDescuento, facturaventa_Remision, facturaventa_Anulada FROM facturaventa ORDER BY facturaventa_Fecha DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Anulada'] == "NO") {
                if ($fila['facturaventa_NitTercero'] == $Tercero) {
                    array_push($listaFV, $fila['facturaventa_Fecha']);
                    array_push($listaFV, $fila['facturaventa_Id']);
                    array_push($listaFV, $fila['facturaventa_Remision']);
                    array_push($listaFV, ($fila['facturaventa_Subtotal']-$fila['facturaventa_ValorDescuento']));
                }
            }
        }
        mysqli_close($conexion);
        return $listaFV;
    }

    function valorTotalFacturasVentaHistoricoCliente($Tercero) {
        $conexion = conexionBD();
        $valorFacturas = 0;
        $consulta = "SELECT facturaventa_Fecha, facturaventa_NitTercero, facturaventa_Subtotal, facturaventa_ValorDescuento, facturaventa_Anulada FROM facturaventa";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Anulada'] == "NO") {
                if ($fila['facturaventa_NitTercero'] == $Tercero) {
                    $valorFacturas += ($fila['facturaventa_Subtotal']-$fila['facturaventa_ValorDescuento']);
                }
            }
        }
        mysqli_close($conexion);
        return $valorFacturas;
    }

    function listaFacturasClientes() {
        $conexion = conexionBD();
        $listaFV = array();
        $consulta = "SELECT facturaventa_Fecha, facturaventa_Id, facturaventa_NitTercero, facturaventa_Subtotal, facturaventa_ValorDescuento, facturaventa_Anulada FROM facturaventa ORDER BY facturaventa_Fecha DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Anulada'] == "NO") {
                array_push($listaFV, $fila['facturaventa_Fecha']);
                array_push($listaFV, $fila['facturaventa_Id']);
                array_push($listaFV, $fila['facturaventa_NitTercero']);
                array_push($listaFV, datosTercero($fila['facturaventa_NitTercero'])[2]);
                array_push($listaFV, ($fila['facturaventa_Subtotal']-$fila['facturaventa_ValorDescuento']));
            }
        }
        mysqli_close($conexion);
        return $listaFV;
    }

    function valorTotalFacturasVenta() {
        $conexion = conexionBD();
        $valorFacturas = 0;
        $consulta = "SELECT facturaventa_Fecha, facturaventa_Subtotal, facturaventa_ValorDescuento, facturaventa_Anulada FROM facturaventa";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Anulada'] == "NO") {
                $valorFacturas += ($fila['facturaventa_Subtotal']-$fila['facturaventa_ValorDescuento']);
            }
        }
        mysqli_close($conexion);
        return $valorFacturas;
    }

    function estaFacturaVenta($IdFV) {
        $conexion = conexionBD();
        $ValidacionFacturaVenta = FALSE;
        $consulta = "SELECT facturaventa_Id FROM facturaventa";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Id'] == $IdFV) {
                $ValidacionFacturaVenta = TRUE;
            }
        }
        mysqli_close($conexion);
        return $ValidacionFacturaVenta;
    }

    function factura_ObtenerIdRemision($IdFV) {
        $conexion = conexionBD();
        $Remision = "";
        $consulta = "SELECT facturaventa_Remision FROM facturaventa WHERE facturaventa_Id='$IdFV'";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            $Remision = $fila['facturaventa_Remision'];
        }
        mysqli_close($conexion);
        return $Remision;
    }

    function factura_CerrarCotizacion($IdFV) {
        $Remisiones = listadoRemisiones_FacturaVenta($IdFV);
        for ($i = 0; $i < count($Remisiones); $i++) {
            $PlanillaProduccion = IdPlanillaProduccion_Remision($Remisiones[$i]);
            $Cotizacion = PlanillaProduccion_IdCotizacion($PlanillaProduccion);
            $Validacion = FALSE;
            $conexion = conexionBD();
            $sql = "UPDATE cotizacion Set cotizacion_Facturada=TRUE WHERE cotizacion_Id='$Cotizacion'";
            if (mysqli_query($conexion, $sql)) {
                $Validacion = TRUE;
            }
        }
        mysqli_close($conn);
        return $Validacion;
    }

    function listadoRemisiones_FacturaVenta($IdFV) {
        $datos = conexionBDFacturaVenta();
        $datosfacturaventa = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Id'] == $IdFV) {
                if ($fila['facturaventa_Remision1'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision1']);
                }
                if ($fila['facturaventa_Remision2'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision2']);
                }
                if ($fila['facturaventa_Remision3'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision3']);
                }
                if ($fila['facturaventa_Remision4'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision4']);
                }
                if ($fila['facturaventa_Remision5'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision5']);
                }
                if ($fila['facturaventa_Remision6'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision6']);
                }
                if ($fila['facturaventa_Remision7'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision7']);
                }
                if ($fila['facturaventa_Remision8'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision8']);
                }
                if ($fila['facturaventa_Remision9'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision9']);
                }
                if ($fila['facturaventa_Remision10'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision10']);
                }
                if ($fila['facturaventa_Remision11'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision11']);
                }
                if ($fila['facturaventa_Remision12'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision12']);
                }
                if ($fila['facturaventa_Remision13'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision13']);
                }
                if ($fila['facturaventa_Remision14'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision14']);
                }
                if ($fila['facturaventa_Remision15'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision15']);
                }
                if ($fila['facturaventa_Remision16'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision16']);
                }
                if ($fila['facturaventa_Remision17'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision17']);
                }
                if ($fila['facturaventa_Remision18'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision18']);
                }
                if ($fila['facturaventa_Remision19'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision19']);
                }
                if ($fila['facturaventa_Remision20'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision20']);
                }
                if ($fila['facturaventa_Remision21'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision21']);
                }
                if ($fila['facturaventa_Remision22'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision22']);
                }
                if ($fila['facturaventa_Remision23'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision23']);
                }
                if ($fila['facturaventa_Remision24'] != "") {
                    array_push($datosfacturaventa, $fila['facturaventa_Remision24']);
                }
            }
        }
        return $datosfacturaventa;
    }

    function datosFacturaVenta($IdFV) {
        /*$datos = conexionBDFacturaVenta();
        $datosfacturaventa = array();
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['facturaventa_Id'] == $IdFV) {
                array_push($datosfacturaventa, $fila['facturaventa_Id']); //0
                array_push($datosfacturaventa, $fila['facturaventa_Año']); //1
                array_push($datosfacturaventa, $fila['facturaventa_Mes']); //2
                array_push($datosfacturaventa, $fila['facturaventa_Dia']); //3
                array_push($datosfacturaventa, $fila['facturaventa_NitTercero']); //4
                array_push($datosfacturaventa, $fila['facturaventa_DVTercero']); //5
                array_push($datosfacturaventa, datosTercero($fila['facturaventa_NitTercero'])[2]); //6
                array_push($datosfacturaventa, $fila['facturaventa_Telefono1Tercero']); //7
                array_push($datosfacturaventa, $fila['facturaventa_Telefono2Tercero']); //8
                array_push($datosfacturaventa, $fila['facturaventa_EmailTercero']); //9
                array_push($datosfacturaventa, $fila['facturaventa_CiudadTercero']); //10
                array_push($datosfacturaventa, $fila['facturaventa_DireccionTercero']); //11
                array_push($datosfacturaventa, $fila['facturaventa_ContactoTercero']); //12
                array_push($datosfacturaventa, $fila['facturaventa_FormaPago']); //13

                array_push($datosfacturaventa, $fila['facturaventa_Remision1']); //14
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision1']); //15
                array_push($datosfacturaventa, $fila['facturaventa_Remision2']); //16
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision2']); //17
                array_push($datosfacturaventa, $fila['facturaventa_Remision3']); //18
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision3']); //19
                array_push($datosfacturaventa, $fila['facturaventa_Remision4']); //20
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision4']); //21
                array_push($datosfacturaventa, $fila['facturaventa_Remision5']); //22
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision5']); //23
                array_push($datosfacturaventa, $fila['facturaventa_Remision6']); //24
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision6']); //25
                array_push($datosfacturaventa, $fila['facturaventa_Remision7']); //26
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision7']); //27
                array_push($datosfacturaventa, $fila['facturaventa_Remision8']); //28
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision8']); //29
                array_push($datosfacturaventa, $fila['facturaventa_Remision9']); //30
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision9']); //31
                array_push($datosfacturaventa, $fila['facturaventa_Remision10']); //32
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision10']); //33
                array_push($datosfacturaventa, $fila['facturaventa_Remision11']); //34
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision11']); //35
                array_push($datosfacturaventa, $fila['facturaventa_Remision12']); //36
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision12']); //37
                array_push($datosfacturaventa, $fila['facturaventa_Remision13']); //38
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision13']); //39
                array_push($datosfacturaventa, $fila['facturaventa_Remision14']); //40
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision14']); //41
                array_push($datosfacturaventa, $fila['facturaventa_Remision15']); //42
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision15']); //43
                array_push($datosfacturaventa, $fila['facturaventa_Remision16']); //44
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision16']); //45
                array_push($datosfacturaventa, $fila['facturaventa_Remision17']); //46
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision17']); //47
                array_push($datosfacturaventa, $fila['facturaventa_Remision18']); //48
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision18']); //49
                array_push($datosfacturaventa, $fila['facturaventa_Remision19']); //50
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision19']); //51
                array_push($datosfacturaventa, $fila['facturaventa_Remision20']); //52
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision20']); //53
                array_push($datosfacturaventa, $fila['facturaventa_Remision21']); //54
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision21']); //55
                array_push($datosfacturaventa, $fila['facturaventa_Remision22']); //56
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision22']); //57
                array_push($datosfacturaventa, $fila['facturaventa_Remision23']); //58
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision23']); //59
                array_push($datosfacturaventa, $fila['facturaventa_Remision24']); //60
                array_push($datosfacturaventa, $fila['facturaventa_ValorRemision24']); //61

                array_push($datosfacturaventa, $fila['facturaventa_Subtotal']); //62
                array_push($datosfacturaventa, $fila['facturaventa_PorcentajeDescuento']); //63
                array_push($datosfacturaventa, $fila['facturaventa_ValorDescuento']); //64
                array_push($datosfacturaventa, $fila['facturaventa_ValorIVA_24081001']); //65
                array_push($datosfacturaventa, $fila['facturaventa_ValorRetefuente']); //66
                array_push($datosfacturaventa, $fila['facturaventa_ValorTotal']); //67

                array_push($datosfacturaventa, $fila['facturaventa_ValorCompras_13551501']); //68
                array_push($datosfacturaventa, $fila['facturaventa_ValorReteIVA_13551701']); //69
                array_push($datosfacturaventa, $fila['facturaventa_ValorDemasActividadIndustriales_13551804']); //70
                array_push($datosfacturaventa, $fila['facturaventa_ValorAutoRentaEspecial_23657501']); //71
                array_push($datosfacturaventa, $fila['facturaventa_ValorAutoRentaEspecial_13551541']); //72
                array_push($datosfacturaventa, $fila['facturaventa_ValorClientesNacionales_13050501']); //73
                array_push($datosfacturaventa, $fila['facturaventa_DB']); //74
                array_push($datosfacturaventa, $fila['facturaventa_HB']); //75
                array_push($datosfacturaventa, $fila['facturaventa_Saldo']); //76

                array_push($datosfacturaventa, $fila['facturaventa_Vendedor']); //77
                array_push($datosfacturaventa, $fila['facturaventa_Remision']); //78
                array_push($datosfacturaventa, $fila['facturaventa_Fecha']); //79
                array_push($datosfacturaventa, $fila['facturaventa_Anulada']); //80
            }
        }
        return $datosfacturaventa;*/

        $conexion = conexionBD();
        $consulta = "SELECT * FROM facturaventa WHERE facturaventa_Id='$IdFV'";
        $datos = mysqli_query($conexion, $consulta);
        $fila = mysqli_fetch_array($datos);
        mysqli_close($conexion);
        return $fila;
    }

    //-----------------------------------------------------------------------------------------------------------
    // LEGALIZACIONES CAJA MENOR

    function conexionBDLegalizacionCMItemsProv() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM legalizacion_cm_itemsprovisional";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaItemsProvLegalizacionCM($IdProvisional) {
        $datos = conexionBDLegalizacionCMItemsProv();
        $listaItemsProvCotizacion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['legalizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Nit']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_RazonSocial']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_CentroCosto']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Detalle']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Cantidad']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_ValorUnitario']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_ValorTotal']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Iva']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Id']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_CuentaPuc']);
            }
        }
        return $listaItemsProvCotizacion;
    }

    function estaCodeProvLegalizacionCM($IdProvisional) {
        $datos = conexionBDLegalizacionCMItemsProv();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['legalizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function cantidadItemsProvLegalizacionCM($IdProvisional) {
        $datos = conexionBDLegalizacionCMItemsProv();
        $number = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['legalizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                $number = $number + 1;
            }
        }
        return $number;
    }

    function conexionBDLegalizacionCM() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM legalizacion_cm";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaLegalizacionesCM() {
        $conexion = conexionBD();
        $listaLG_CM = array();
        $consulta = "SELECT legalizacion_cm_Consecutivo, legalizacion_cm_Id, legalizacion_cm_RazonSocialTercero FROM legalizacion_cm ORDER BY legalizacion_cm_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            $comprobacion = FALSE;
            for ($i = 0, $size = count($listaLG_CM); $i < $size; ++$i) {
                if ($listaLG_CM[$i] == $fila['legalizacion_cm_Id']) {
                    $comprobacion = TRUE;
                }
            }
            if ($comprobacion == FALSE) {
                array_push($listaLG_CM, $fila['legalizacion_cm_Id']);
                array_push($listaLG_CM, $fila['legalizacion_cm_RazonSocialTercero']);
            }
        }
        mysqli_close($conexion);
        return $listaLG_CM;
    }

    function listaLegalizacionesCMSinAnular() {
        $conexion = conexionBD();
        $listaLG_CM = array();
        $consulta = "SELECT legalizacion_cm_Consecutivo, legalizacion_cm_Id, legalizacion_cm_RazonSocialTercero, legalizacion_cm_Anulada FROM legalizacion_cm ORDER BY legalizacion_cm_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cm_Anulada'] == "NO") {
                $comprobacion = FALSE;
                for ($i = 0, $size = count($listaLG_CM); $i < $size; ++$i) {
                    if ($listaLG_CM[$i] == $fila['legalizacion_cm_Id']) {
                        $comprobacion = TRUE;
                    }
                }
                if ($comprobacion == FALSE) {
                    array_push($listaLG_CM, $fila['legalizacion_cm_Id']);
                    array_push($listaLG_CM, $fila['legalizacion_cm_RazonSocialTercero']);
                }
            }
        }
        mysqli_close($conexion);
        return $listaLG_CM;
    }

    function estaLegalizacionCM($IdLegCM) {
        $conexion = conexionBD();
        $ValidacionLegalizacionCM = FALSE;
        $consulta = "SELECT legalizacion_cm_Id FROM legalizacion_cm";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cm_Id'] == $IdLegCM) {
                $ValidacionLegalizacionCM = TRUE;
            }
        }
        mysqli_close($conexion);
        return $ValidacionLegalizacionCM;
    }

    function datosLegalizacionCM($IdLegCM) {
        $datos = conexionBDLegalizacionCM();
        $datosLegCM = array();
        $comprobacion = FALSE;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cm_Id'] == $IdLegCM) {
                if ($comprobacion == FALSE) {
                    array_push($datosLegCM, $fila['legalizacion_cm_Id']);
                    array_push($datosLegCM, $fila['legalizacion_cm_Año']);
                    array_push($datosLegCM, $fila['legalizacion_cm_Mes']);
                    array_push($datosLegCM, $fila['legalizacion_cm_Dia']);
                    array_push($datosLegCM, $fila['legalizacion_cm_NitTercero']);
                    array_push($datosLegCM, $fila['legalizacion_cm_DVTercero']);
                    array_push($datosLegCM, $fila['legalizacion_cm_RazonSocialTercero']);
                    array_push($datosLegCM, $fila['legalizacion_cm_Usuario']);
                    array_push($datosLegCM, $fila['legalizacion_cm_Anulada']);
                    $comprobacion = TRUE;
                }
                array_push($datosLegCM, $fila['legalizacion_cm_CentroCosto']);
                array_push($datosLegCM, $fila['legalizacion_cm_Nit']);
                array_push($datosLegCM, $fila['legalizacion_cm_RazonSocial']);
                array_push($datosLegCM, $fila['legalizacion_cm_Detalle']);
                array_push($datosLegCM, $fila['legalizacion_cm_Cantidad']);
                array_push($datosLegCM, $fila['legalizacion_cm_ValorUnitario']);
                array_push($datosLegCM, $fila['legalizacion_cm_ValorTotal']);
                array_push($datosLegCM, $fila['legalizacion_cm_ValorIva']);
                array_push($datosLegCM, $fila['legalizacion_cm_Cuenta']);
            }
        }
        return $datosLegCM;
    }

    function cantidadDatosLegalizacionCM($IdLegCM) {
        $datos = conexionBDLegalizacionCM();
        $contador = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cm_Id'] == $IdLegCM) {
                $contador = $contador + 1;
            }
        }
        return $contador;
    }

    //-----------------------------------------------------------------------------------------------------------
    // LEGALIZACIONES CUENTAS POR PAGAR

    function conexionBDLegalizacionCXPItemsProv() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM legalizacion_cxp_itemsprovisional";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaItemsProvLegalizacionCXP($IdProvisional) {
        $datos = conexionBDLegalizacionCXPItemsProv();
        $listaItemsProvCotizacion = array();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['legalizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Detalle']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Cantidad']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_ValorUnitario']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_ValorTotal']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Iva']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_Id']);
                array_push($listaItemsProvCotizacion, $fila['legalizacion_itemsprovisional_CuentaPUC']);
            }
        }
        return $listaItemsProvCotizacion;
    }

    function estaCodeProvLegalizacionCXP($IdProvisional) {
        $datos = conexionBDLegalizacionCXPItemsProv();
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['legalizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                return TRUE;
                break;
            }
        }
        return FALSE;
    }

    function cantidadItemsProvLegalizacionCXP($IdProvisional) {
        $datos = conexionBDLegalizacionCXPItemsProv();
        $number = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if (number_format($fila['legalizacion_itemsprovisional_CodeProv']) == number_format($IdProvisional)) {
                $number = $number + 1;
            }
        }
        return $number;
    }

    function conexionBDLegalizacionCXP() {
        $conexion = conexionBD();
        $consulta = "SELECT * FROM legalizacion_cxp";
        $datos = mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        return $datos;
    }

    function listaLegalizacionesCXP() {
        $conexion = conexionBD();
        $listaLG_CXP = array();
        $consulta = "SELECT legalizacion_cxp_Consecutivo, legalizacion_cxp_Id, legalizacion_cxp_RazonSocialTercero FROM legalizacion_cxp ORDER BY legalizacion_cxp_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            $comprobacion = FALSE;
            for ($i = 0, $size = count($listaLG_CXP); $i < $size; ++$i) {
                if ($listaLG_CXP[$i] == $fila['legalizacion_cxp_Id']) {
                    $comprobacion = TRUE;
                }
            }
            if ($comprobacion == FALSE) {
                array_push($listaLG_CXP, $fila['legalizacion_cxp_Id']);
                array_push($listaLG_CXP, $fila['legalizacion_cxp_RazonSocialTercero']);
            }
        }
        mysqli_close($conexion);
        return $listaLG_CXP;
    }

    function listaLegalizacionesCXPSinAnular() {
        $conexion = conexionBD();
        $listaLG_CXP = array();
        $consulta = "SELECT legalizacion_cxp_Consecutivo, legalizacion_cxp_Id, legalizacion_cxp_RazonSocialTercero, legalizacion_cxp_Anulada FROM legalizacion_cxp ORDER BY legalizacion_cxp_Consecutivo DESC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cxp_Anulada'] == "NO") {
                $comprobacion = FALSE;
                for ($i = 0, $size = count($listaLG_CXP); $i < $size; ++$i) {
                    if ($listaLG_CXP[$i] == $fila['legalizacion_cxp_Id']) {
                        $comprobacion = TRUE;
                    }
                }
                if ($comprobacion == FALSE) {
                    array_push($listaLG_CXP, $fila['legalizacion_cxp_Id']);
                    array_push($listaLG_CXP, $fila['legalizacion_cxp_RazonSocialTercero']);
                }
            }
        }
        mysqli_close($conexion);
        return $listaLG_CXP;
    }

    function estaLegalizacionCXP($IdLegCXP) {
        $conexion = conexionBD();
        $ValidacionLegalizacionCXP = FALSE;
        $consulta = "SELECT legalizacion_cxp_Id FROM legalizacion_cxp";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cxp_Id'] == $IdLegCXP) {
                $ValidacionLegalizacionCXP = TRUE;
            }
        }
        mysqli_close($conexion);
        return $ValidacionLegalizacionCXP;
    }

    function datosLegalizacionCXP($IdLegCXP) {
        $datos = conexionBDLegalizacionCXP();
        $datosLegCXP = array();
        $comprobacion = FALSE;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cxp_Id'] == $IdLegCXP) {
                if ($comprobacion == FALSE) {
                    array_push($datosLegCXP, $fila['legalizacion_cxp_Id']); //0
                    array_push($datosLegCXP, $fila['legalizacion_cxp_Año']); //1
                    array_push($datosLegCXP, $fila['legalizacion_cxp_Mes']); //2
                    array_push($datosLegCXP, $fila['legalizacion_cxp_Dia']); //3
                    array_push($datosLegCXP, $fila['legalizacion_cxp_NitTercero']); //4
                    array_push($datosLegCXP, $fila['legalizacion_cxp_DVTercero']); //5
                    array_push($datosLegCXP, $fila['legalizacion_cxp_RazonSocialTercero']); //6
                    array_push($datosLegCXP, $fila['legalizacion_cxp_TelefonoTercero']); //7
                    array_push($datosLegCXP, $fila['legalizacion_cxp_EmailTercero']); //8
                    array_push($datosLegCXP, $fila['legalizacion_cxp_CiudadTercero']); //9
                    array_push($datosLegCXP, $fila['legalizacion_cxp_DireccionTercero']); //10
                    array_push($datosLegCXP, $fila['legalizacion_cxp_Cotizacion']); //11
                    array_push($datosLegCXP, $fila['legalizacion_cxp_CentroCosto']); //12
                    array_push($datosLegCXP, $fila['legalizacion_cxp_FacturaCompra']); //13
                    array_push($datosLegCXP, $fila['legalizacion_cxp_NitCliente']); //14
                    array_push($datosLegCXP, $fila['legalizacion_cxp_RazonSocialCliente']); //15
                    array_push($datosLegCXP, $fila['legalizacion_cxp_Usuario']); //16
                    array_push($datosLegCXP, $fila['legalizacion_cxp_Anulada']); //17
                    $comprobacion = TRUE;
                }
                array_push($datosLegCXP, $fila['legalizacion_cxp_Cuenta']);
                array_push($datosLegCXP, $fila['legalizacion_cxp_Detalle']);
                array_push($datosLegCXP, $fila['legalizacion_cxp_Cantidad']);
                array_push($datosLegCXP, $fila['legalizacion_cxp_ValorUnitario']);
                array_push($datosLegCXP, $fila['legalizacion_cxp_ValorTotal']);
                array_push($datosLegCXP, $fila['legalizacion_cxp_ValorIva']);
            }
        }
        return $datosLegCXP;
    }

    function cantidadDatosLegalizacionCXP($IdLegCXP) {
        $datos = conexionBDLegalizacionCXP();
        $contador = 0;
        while($fila = mysqli_fetch_array($datos)) {
            if ($fila['legalizacion_cxp_Id'] == $IdLegCXP) {
                $contador = $contador + 1;
            }
        }
        return $contador;
    }

    //******************************************************************************************************************
    function obtenerNumeroCuenta($Cuenta) {
        $datos = conexionBDFacturaVenta();
        $datosfacturaventa = array();
        while($fila = mysqli_fetch_array($datos)) {
            $datosfacturaventa = $fila['facturaventa_'.$Cuenta];
            break;
        }
        return $datosfacturaventa;  
    }





    //******************************************************************************************************************

    function validacionUsuario_RC($Documento) {
        $conexion = conexionBD();
        $sql = "";
        if (estaDocumento($Documento) and usuario_TieneAcceso($Documento)) {
            $datos = conexionBDUsuario();
            while($fila = mysqli_fetch_array($datos)) {
                if (number_format($Documento) == number_format($fila['usuario_Documento'])) {
                    $NumAlt = rand(1000,20000);
                    $sql = "UPDATE usuario set usuario_RC='$NumAlt' WHERE usuario_Documento='$Documento'";
                    $Destinatario = datosUsuario($Documento)['usuario_Correo'];
                    $Asunto = "Código de verificación GTE";
                    $Subject = utf8_decode($Asunto);
                    $descripcionUsuario = "Use el siguiente código para la validación en el sistema de GTE: ". $NumAlt;
                    $Contenido = utf8_decode($descripcionUsuario) . "\n\n";
                    $Contenido .= "Gracias por confiar en nosotros";
                    mail($Destinatario, $Subject, $Contenido);

                    mysqli_query($conexion, $sql);
                    mysqli_close($conexion);
                    return TRUE;
                }
            }
            mysqli_query($conexion, $sql);
            mysqli_close($conexion);
        } else {
            return FALSE;
        }
    }
    
    function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }




    //******************************************************************************************************************
    //FUNCIONES PARA CONVERTIR NÚMEROS A LETRAS

    function convertirNumeroLetra($numero){
        $numf = milmillon($numero);
        return $numf;
    }

    function milmillon($nummierod){
        if ($nummierod >= 1000000000 && $nummierod <2000000000){
            $num_letrammd = "MIL ".(cienmillon($nummierod%1000000000));
        }
        if ($nummierod >= 2000000000 && $nummierod <10000000000){
            $num_letrammd = unidad(Floor($nummierod/1000000000))." MIL ".(cienmillon($nummierod%1000000000));
        }
        if ($nummierod < 1000000000)
            $num_letrammd = cienmillon($nummierod);
        
        return $num_letrammd;
    }

    function cienmillon($numcmeros){
        if ($numcmeros == 100000000)
            $num_letracms = "CIEN MILLONES";
        if ($numcmeros >= 100000000 && $numcmeros <1000000000){
            $num_letracms = centena(Floor($numcmeros/1000000))." MILLONES ".(millon($numcmeros%1000000));       
        }
        if ($numcmeros < 100000000)
            $num_letracms = decmillon($numcmeros);
        return $num_letracms;
    }

    function decmillon($numerodm){
        if ($numerodm == 10000000)
            $num_letradmm = "DIEZ MILLONES";
        if ($numerodm > 10000000 && $numerodm <20000000){
            $num_letradmm = decena(Floor($numerodm/1000000))."MILLONES ".(cienmiles($numerodm%1000000));        
        }
        if ($numerodm >= 20000000 && $numerodm <100000000){
            $num_letradmm = decena(Floor($numerodm/1000000))." MILLONES ".(millon($numerodm%1000000));      
        }
        if ($numerodm < 10000000)
            $num_letradmm = millon($numerodm);
        
        return $num_letradmm;
    }

    function millon($nummiero){
        if ($nummiero >= 1000000 && $nummiero <2000000){
            $num_letramm = "UN MILLON ".(cienmiles($nummiero%1000000));
        }
        if ($nummiero >= 2000000 && $nummiero <10000000){
            $num_letramm = unidad(Floor($nummiero/1000000))." MILLONES ".(cienmiles($nummiero%1000000));
        }
        if ($nummiero < 1000000)
            $num_letramm = cienmiles($nummiero);
        
        return $num_letramm;
    }

    function cienmiles($numcmero){
        if ($numcmero == 100000)
            $num_letracm = "CIEN MIL";
        if ($numcmero >= 100000 && $numcmero <1000000){
            $num_letracm = centena(Floor($numcmero/1000))." MIL ".(centena($numcmero%1000));        
        }
        if ($numcmero < 100000)
            $num_letracm = decmiles($numcmero);
        return $num_letracm;
    }

    function decmiles($numdmero){
        if ($numdmero == 10000)
            $numde = "DIEZ MIL";
        if ($numdmero > 10000 && $numdmero <20000){
            $numde = decena(Floor($numdmero/1000))."MIL ".(centena($numdmero%1000));        
        }
        if ($numdmero >= 20000 && $numdmero <100000){
            $numde = decena(Floor($numdmero/1000))." MIL ".(miles($numdmero%1000));     
        }       
        if ($numdmero < 10000)
            $numde = miles($numdmero);
        
        return $numde;
    }

    function miles($nummero){
        if ($nummero >= 1000 && $nummero < 2000){
            $numm = "MIL ".(centena($nummero%1000));
        }
        if ($nummero >= 2000 && $nummero <10000){
            $numm = unidad(Floor($nummero/1000))." MIL ".(centena($nummero%1000));
        }
        if ($nummero < 1000)
            $numm = centena($nummero);
        
        return $numm;
    }

    function centena($numc){
        if ($numc >= 100)
        {
            if ($numc >= 900 && $numc <= 999)
            {
                $numce = "NOVECIENTOS ";
                if ($numc > 900)
                    $numce = $numce.(decena($numc - 900));
            }
            else if ($numc >= 800 && $numc <= 899)
            {
                $numce = "OCHOCIENTOS ";
                if ($numc > 800)
                    $numce = $numce.(decena($numc - 800));
            }
            else if ($numc >= 700 && $numc <= 799)
            {
                $numce = "SETECIENTOS ";
                if ($numc > 700)
                    $numce = $numce.(decena($numc - 700));
            }
            else if ($numc >= 600 && $numc <= 699)
            {
                $numce = "SEISCIENTOS ";
                if ($numc > 600)
                    $numce = $numce.(decena($numc - 600));
            }
            else if ($numc >= 500 && $numc <= 599)
            {
                $numce = "QUINIENTOS ";
                if ($numc > 500)
                    $numce = $numce.(decena($numc - 500));
            }
            else if ($numc >= 400 && $numc <= 499)
            {
                $numce = "CUATROCIENTOS ";
                if ($numc > 400)
                    $numce = $numce.(decena($numc - 400));
            }
            else if ($numc >= 300 && $numc <= 399)
            {
                $numce = "TRESCIENTOS ";
                if ($numc > 300)
                    $numce = $numce.(decena($numc - 300));
            }
            else if ($numc >= 200 && $numc <= 299)
            {
                $numce = "DOSCIENTOS ";
                if ($numc > 200)
                    $numce = $numce.(decena($numc - 200));
            }
            else if ($numc >= 100 && $numc <= 199)
            {
                if ($numc == 100)
                    $numce = "CIEN ";
                else
                    $numce = "CIENTO ".(decena($numc - 100));
            }
        }
        else
            $numce = decena($numc);
        
        return $numce;  
    }

    function decena($numdero){
    
        if ($numdero >= 90 && $numdero <= 99)
        {
            $numd = "NOVENTA ";
            if ($numdero > 90)
                $numd = $numd."Y ".(unidad($numdero - 90));
        }
        else if ($numdero >= 80 && $numdero <= 89)
        {
            $numd = "OCHENTA ";
            if ($numdero > 80)
                $numd = $numd."Y ".(unidad($numdero - 80));
        }
        else if ($numdero >= 70 && $numdero <= 79)
        {
            $numd = "SETENTA ";
            if ($numdero > 70)
                $numd = $numd."Y ".(unidad($numdero - 70));
        }
        else if ($numdero >= 60 && $numdero <= 69)
        {
            $numd = "SESENTA ";
            if ($numdero > 60)
                $numd = $numd."Y ".(unidad($numdero - 60));
        }
        else if ($numdero >= 50 && $numdero <= 59)
        {
            $numd = "CINCUENTA ";
            if ($numdero > 50)
                $numd = $numd."Y ".(unidad($numdero - 50));
        }
        else if ($numdero >= 40 && $numdero <= 49)
        {
            $numd = "CUARENTA ";
            if ($numdero > 40)
                $numd = $numd."Y ".(unidad($numdero - 40));
        }
        else if ($numdero >= 30 && $numdero <= 39)
        {
            $numd = "TREINTA ";
            if ($numdero > 30)
                $numd = $numd."Y ".(unidad($numdero - 30));
        }
        else if ($numdero >= 20 && $numdero <= 29)
        {
            if ($numdero == 20)
                $numd = "VEINTE ";
            else
                $numd = "VEINTI".(unidad($numdero - 20));
        }
        else if ($numdero >= 10 && $numdero <= 19)
        {
            switch ($numdero){
            case 10:
            {
                $numd = "DIEZ ";
                break;
            }
            case 11:
            {               
                $numd = "ONCE ";
                break;
            }
            case 12:
            {
                $numd = "DOCE ";
                break;
            }
            case 13:
            {
                $numd = "TRECE ";
                break;
            }
            case 14:
            {
                $numd = "CATORCE ";
                break;
            }
            case 15:
            {
                $numd = "QUINCE ";
                break;
            }
            case 16:
            {
                $numd = "DIECISEIS ";
                break;
            }
            case 17:
            {
                $numd = "DIECISIETE ";
                break;
            }
            case 18:
            {
                $numd = "DIECIOCHO ";
                break;
            }
            case 19:
            {
                $numd = "DIECINUEVE ";
                break;
            }
            }   
        }
        else
            $numd = unidad($numdero);
        return $numd;
    }

    function unidad($numuero){
        switch ($numuero)
        {
            case 9:
            {
                $numu = "NUEVE";
                break;
            }
            case 8:
            {
                $numu = "OCHO";
                break;
            }
            case 7:
            {
                $numu = "SIETE";
                break;
            }       
            case 6:
            {
                $numu = "SEIS";
                break;
            }       
            case 5:
            {
                $numu = "CINCO";
                break;
            }       
            case 4:
            {
                $numu = "CUATRO";
                break;
            }       
            case 3:
            {
                $numu = "TRES";
                break;
            }       
            case 2:
            {
                $numu = "DOS";
                break;
            }       
            case 1:
            {
                $numu = "UN";
                break;
            }       
            case 0:
            {
                $numu = "";
                break;
            }       
        }
        return $numu;   
    }
?>
