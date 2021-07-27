<?php

    include '../Php/Funciones.php';

    if (isset($_POST['id_Departamento'])) {
        $idDepartamento = $_POST['id_Departamento'];
        $conexion = conexionBD();
        $listaCiudades = '<option></option>';
        $consulta = "SELECT ciudad_Id, ciudad_Nombre FROM ciudad WHERE ciudad_Departamento='$idDepartamento' ORDER BY ciudad_Nombre ASC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            if (isset($_POST['id_CiudadTercero']) and $listaCiudades == '<option></option>') {
                $listaCiudades = '<option value="'.$_POST['id_CiudadTercero'].'">'.nombreCiudad($_POST['id_CiudadTercero']).'</option>';
            }
            $listaCiudades .= '<option value="'.$fila['ciudad_Id'].'">'.$fila['ciudad_Nombre'].'</option>';
        }
        echo $listaCiudades;
        mysqli_close($conexion);
    }

    if (isset($_POST['id_Tercero'])) {
        $idTercero = $_POST['id_Tercero'];
        $conexion = conexionBD();
        $listaPlantasTercero = '<option></option>';
        $consulta = "SELECT * FROM planta_tercero WHERE planta_tercero_NitTercero='$idTercero' ORDER BY planta_tercero_Id ASC";
        $datos = mysqli_query($conexion, $consulta);
        while ($fila = mysqli_fetch_array($datos)) {
            $listaPlantasTercero .= '<option value="'.$fila['planta_tercero_Id'].'">'.nombreDepartamento($fila['planta_tercero_Departamento']).', '. nombreCiudad($fila['planta_tercero_Ciudad']).', '. $fila['planta_tercero_Direccion'].'</option>';
        }
        echo $listaPlantasTercero;
        mysqli_close($conexion);
    }

?>