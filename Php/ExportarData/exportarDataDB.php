<?php

    include '../Funciones.php'; 
    require('../../Excel/Vendor/autoload.php');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;   

    $Documento=$_GET['cc'];
    $CS=$_GET['cs'];
    if (SesionUsuario($Documento,$CS) == FALSE) {
        header("Location: ../Login");
        exit();
    }
    else if (!validarPermisosUsuario($Documento,array(16,26))) {
        header("Location: ../MainPage? cc=$Documento&cs=$CS&msj=EPD");
        exit();
    }   
    else {

        $conexion = conexionBD();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data_GTE.xlsx"');

        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('GTE')
            ->setTitle('DATA GTE');

        $numeroHoja = 0;
        $hojaCotizacion = $_GET['COT'];
        $hojaPlanillaProduccion = $_GET['PP'];
        $hojaRemision = $_GET['REM'];
        $hojaFacturaVenta = $_GET['FV'];
        $hojaTerceros = $_GET['TER'];
        $hojaPlantasTerceros = $_GET['PLTER'];
        $hojaLegalizacionCM = $_GET['LEGCM'];
        $hojaLegalizacionCXP = $_GET['LEGCXP'];

        //*******************************************************************************************
        //COTIZACIÓN
        if ($hojaCotizacion == 1) {

            $spreadsheet->createSheet($numeroHoja);

            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Año')
                ->setCellValue('B1', 'Mes')
                ->setCellValue('C1', 'Dia')
                ->setCellValue('D1', 'Cotización')
                ->setCellValue('E1', 'Planilla producción')
                ->setCellValue('F1', 'Nit Tercero')
                ->setCellValue('G1', 'DV Tercero')
                ->setCellValue('H1', 'Razon Social')
                ->setCellValue('I1', 'Tiempo de entrega')
                ->setCellValue('J1', 'Forma pago')
                ->setCellValue('K1', 'Ciudad')
                ->setCellValue('L1', 'Dirección')
                ->setCellValue('M1', '% Descuento')
                ->setCellValue('N1', 'Detalle')
                ->setCellValue('O1', 'Cantidad')
                ->setCellValue('P1', 'Valor unitario')
                ->setCellValue('Q1', 'Valor total')
                ->setCellValue('R1', 'Vendedor')
                ->setCellValue('S1', 'ANULADA');

            $aux2_ContItems = 2;
            $consulta = "SELECT * FROM cotizacion ORDER BY cotizacion_Consecutivo DESC";
            $datos = mysqli_query($conexion, $consulta);
            while($fila = mysqli_fetch_array($datos)) {

                $IdCotizacion = $fila['cotizacion_Id'];
                $ItemCotizacion = itemsCotizacion($IdCotizacion);
                $contItems = count($ItemCotizacion);
                $auxContItems = 0;

                while ($auxContItems < $contItems) {
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['cotizacion_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['cotizacion_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['cotizacion_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['cotizacion_Id'])
                        ->setCellValue('E'.$aux2_ContItems, Cotizacion_PlanillasProduccion($fila['cotizacion_Id']))
                        ->setCellValue('F'.$aux2_ContItems, $fila['cotizacion_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, $fila['cotizacion_TiempoEntrega'])
                        ->setCellValue('J'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('K'.$aux2_ContItems, nombreDepartamento(datosTercero($fila['cotizacion_NitTercero'])['tercero_Departamento']).' - '.nombreCiudad(datosTercero($fila['cotizacion_NitTercero'])['tercero_Ciudad']))
                        ->setCellValue('L'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Direccion'])
                        ->setCellValue('M'.$aux2_ContItems, $fila['cotizacion_PorcentajeDescuento'].'%')
                        ->setCellValue('N'.$aux2_ContItems, $ItemCotizacion[$auxContItems])
                        ->setCellValue('O'.$aux2_ContItems, $ItemCotizacion[$auxContItems+1])
                        ->setCellValue('P'.$aux2_ContItems, $ItemCotizacion[$auxContItems+2])
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['cotizacion_Vendedor'])
                        ->setCellValue('S'.$aux2_ContItems, $fila['cotizacion_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                    $auxContItems = $auxContItems + 4;
                }

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['cotizacion_Año'])
                    ->setCellValue('B'.$aux2_ContItems, $fila['cotizacion_Mes'])
                    ->setCellValue('C'.$aux2_ContItems, $fila['cotizacion_Dia'])
                    ->setCellValue('D'.$aux2_ContItems, $fila['cotizacion_Id'])
                    ->setCellValue('E'.$aux2_ContItems, Cotizacion_PlanillasProduccion($fila['cotizacion_Id']))
                    ->setCellValue('F'.$aux2_ContItems, $fila['cotizacion_NitTercero'])
                    ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Dv'])
                    ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_RazonSocial'])
                    ->setCellValue('I'.$aux2_ContItems, $fila['cotizacion_TiempoEntrega'])
                    ->setCellValue('J'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_FormaPago'])
                    ->setCellValue('K'.$aux2_ContItems, nombreDepartamento(datosTercero($fila['cotizacion_NitTercero'])['tercero_Departamento']).' - '.nombreCiudad(datosTercero($fila['cotizacion_NitTercero'])['tercero_Ciudad']))
                    ->setCellValue('L'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Direccion'])
                    ->setCellValue('M'.$aux2_ContItems, $fila['cotizacion_PorcentajeDescuento'].'%')
                    ->setCellValue('N'.$aux2_ContItems, 'VALOR SUBTOTAL')
                    ->setCellValue('O'.$aux2_ContItems, '1')
                    ->setCellValue('P'.$aux2_ContItems, $fila['cotizacion_Subtotal'])
                    ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                    ->setCellValue('R'.$aux2_ContItems, $fila['cotizacion_Vendedor'])
                    ->setCellValue('S'.$aux2_ContItems, $fila['cotizacion_Anulada']);
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['cotizacion_Año'])
                    ->setCellValue('B'.$aux2_ContItems, $fila['cotizacion_Mes'])
                    ->setCellValue('C'.$aux2_ContItems, $fila['cotizacion_Dia'])
                    ->setCellValue('D'.$aux2_ContItems, $fila['cotizacion_Id'])
                    ->setCellValue('E'.$aux2_ContItems, Cotizacion_PlanillasProduccion($fila['cotizacion_Id']))
                    ->setCellValue('F'.$aux2_ContItems, $fila['cotizacion_NitTercero'])
                    ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Dv'])
                    ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_RazonSocial'])
                    ->setCellValue('I'.$aux2_ContItems, $fila['cotizacion_TiempoEntrega'])
                    ->setCellValue('J'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_FormaPago'])
                    ->setCellValue('K'.$aux2_ContItems, nombreDepartamento(datosTercero($fila['cotizacion_NitTercero'])['tercero_Departamento']).' - '.nombreCiudad(datosTercero($fila['cotizacion_NitTercero'])['tercero_Ciudad']))
                    ->setCellValue('L'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Direccion'])
                    ->setCellValue('M'.$aux2_ContItems, $fila['cotizacion_PorcentajeDescuento'].'%')
                    ->setCellValue('N'.$aux2_ContItems, 'VALOR DESCUENTO')
                    ->setCellValue('O'.$aux2_ContItems, '1')
                    ->setCellValue('P'.$aux2_ContItems, $fila['cotizacion_ValorDescuento'])
                    ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                    ->setCellValue('R'.$aux2_ContItems, $fila['cotizacion_Vendedor'])
                    ->setCellValue('S'.$aux2_ContItems, $fila['cotizacion_Anulada']);
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['cotizacion_Año'])
                    ->setCellValue('B'.$aux2_ContItems, $fila['cotizacion_Mes'])
                    ->setCellValue('C'.$aux2_ContItems, $fila['cotizacion_Dia'])
                    ->setCellValue('D'.$aux2_ContItems, $fila['cotizacion_Id'])
                    ->setCellValue('E'.$aux2_ContItems, Cotizacion_PlanillasProduccion($fila['cotizacion_Id']))
                    ->setCellValue('F'.$aux2_ContItems, $fila['cotizacion_NitTercero'])
                    ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Dv'])
                    ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_RazonSocial'])
                    ->setCellValue('I'.$aux2_ContItems, $fila['cotizacion_TiempoEntrega'])
                    ->setCellValue('J'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_FormaPago'])
                    ->setCellValue('K'.$aux2_ContItems, nombreDepartamento(datosTercero($fila['cotizacion_NitTercero'])['tercero_Departamento']).' - '.nombreCiudad(datosTercero($fila['cotizacion_NitTercero'])['tercero_Ciudad']))
                    ->setCellValue('L'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Direccion'])
                    ->setCellValue('M'.$aux2_ContItems, $fila['cotizacion_PorcentajeDescuento'].'%')
                    ->setCellValue('N'.$aux2_ContItems, 'VALOR IVA')
                    ->setCellValue('O'.$aux2_ContItems, '1')
                    ->setCellValue('P'.$aux2_ContItems, $fila['cotizacion_ValorIVA'])
                    ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                    ->setCellValue('R'.$aux2_ContItems, $fila['cotizacion_Vendedor'])
                    ->setCellValue('S'.$aux2_ContItems, $fila['cotizacion_Anulada']);
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['cotizacion_Año'])
                    ->setCellValue('B'.$aux2_ContItems, $fila['cotizacion_Mes'])
                    ->setCellValue('C'.$aux2_ContItems, $fila['cotizacion_Dia'])
                    ->setCellValue('D'.$aux2_ContItems, $fila['cotizacion_Id'])
                    ->setCellValue('E'.$aux2_ContItems, Cotizacion_PlanillasProduccion($fila['cotizacion_Id']))
                    ->setCellValue('F'.$aux2_ContItems, $fila['cotizacion_NitTercero'])
                    ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Dv'])
                    ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_RazonSocial'])
                    ->setCellValue('I'.$aux2_ContItems, $fila['cotizacion_TiempoEntrega'])
                    ->setCellValue('J'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_FormaPago'])
                    ->setCellValue('K'.$aux2_ContItems, nombreDepartamento(datosTercero($fila['cotizacion_NitTercero'])['tercero_Departamento']).' - '.nombreCiudad(datosTercero($fila['cotizacion_NitTercero'])['tercero_Ciudad']))
                    ->setCellValue('L'.$aux2_ContItems, datosTercero($fila['cotizacion_NitTercero'])['tercero_Direccion'])
                    ->setCellValue('M'.$aux2_ContItems, $fila['cotizacion_PorcentajeDescuento'].'%')
                    ->setCellValue('N'.$aux2_ContItems, 'VALOR TOTAL')
                    ->setCellValue('O'.$aux2_ContItems, '1')
                    ->setCellValue('P'.$aux2_ContItems, $fila['cotizacion_ValorTotal'])
                    ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                    ->setCellValue('R'.$aux2_ContItems, $fila['cotizacion_Vendedor'])
                    ->setCellValue('S'.$aux2_ContItems, $fila['cotizacion_Anulada']);
                if ($fila['cotizacion_Anulada'] == "NO") {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
                } else {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                }
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;
            }

            $spreadsheet->getActiveSheet()
                ->getStyle('P:P')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            
            $spreadsheet->getActiveSheet()
                ->getStyle('Q:Q')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            
            // Rename worksheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_COT');   
            
            $numeroHoja = $numeroHoja + 1;
        }

        //*********************************************************************************************
        //PLANILLA DE PRODUCCIÓN

        if ($hojaPlanillaProduccion == 1) {

            $spreadsheet->createSheet($numeroHoja);

            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Año')
                ->setCellValue('B1', 'Mes')
                ->setCellValue('C1', 'Dia')
                ->setCellValue('D1', 'Planilla producción')
                ->setCellValue('E1', 'Remisión')
                ->setCellValue('F1', 'Cotización')
                ->setCellValue('G1', 'Nit Tercero')
                ->setCellValue('H1', 'DV Tercero')
                ->setCellValue('I1', 'Razon Social')
                ->setCellValue('J1', 'Tiempo de entrega')
                ->setCellValue('K1', 'Forma pago')
                ->setCellValue('L1', 'Ciudad')
                ->setCellValue('M1', 'Dirección')
                ->setCellValue('N1', 'Detalle')
                ->setCellValue('O1', 'Cantidad')
                ->setCellValue('P1', 'Valor unitario')
                ->setCellValue('Q1', 'Valor total')
                ->setCellValue('R1', 'Vendedor')
                ->setCellValue('S1', 'ANULADA');

            $aux2_ContItems = 2;
            $consulta = "SELECT * FROM planilla_produccion ORDER BY planilla_produccion_Consecutivo DESC";
            $datos = mysqli_query($conexion, $consulta);
            while($fila = mysqli_fetch_array($datos)) {

                $IdPlanilla = $fila['planilla_produccion_Id'];
                $ItemPlanilla = itemsPlanilla($IdPlanilla);
                $contItems = count($ItemPlanilla);
                $auxContItems = 0;

                while ($auxContItems < $contItems) {
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['planilla_produccion_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['planilla_produccion_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['planilla_produccion_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['planilla_produccion_Id'])
                        ->setCellValue('E'.$aux2_ContItems, RemisionesPlanillaProduccion($fila['planilla_produccion_Id']))
                        ->setCellValue('F'.$aux2_ContItems, $fila['planilla_produccion_Cotizacion'])
                        ->setCellValue('G'.$aux2_ContItems, $fila['planilla_produccion_NitTercero'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Dv'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('J'.$aux2_ContItems, $fila['planilla_produccion_TiempoEntrega'])
                        ->setCellValue('K'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('L'.$aux2_ContItems, nombreDepartamento(datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Ciudad']))
                        ->setCellValue('M'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Direccion'])
                        ->setCellValue('N'.$aux2_ContItems, $ItemPlanilla[$auxContItems])
                        ->setCellValue('O'.$aux2_ContItems, $ItemPlanilla[$auxContItems+1])
                        ->setCellValue('P'.$aux2_ContItems, $ItemPlanilla[$auxContItems+2])
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['planilla_produccion_Vendedor'])
                        ->setCellValue('S'.$aux2_ContItems, $fila['planilla_produccion_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                    $auxContItems = $auxContItems + 4;
                }

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['planilla_produccion_Año'])
                    ->setCellValue('B'.$aux2_ContItems, $fila['planilla_produccion_Mes'])
                    ->setCellValue('C'.$aux2_ContItems, $fila['planilla_produccion_Dia'])
                    ->setCellValue('D'.$aux2_ContItems, $fila['planilla_produccion_Id'])
                    ->setCellValue('E'.$aux2_ContItems, RemisionesPlanillaProduccion($fila['planilla_produccion_Id']))
                    ->setCellValue('F'.$aux2_ContItems, $fila['planilla_produccion_Cotizacion'])
                    ->setCellValue('G'.$aux2_ContItems, $fila['planilla_produccion_NitTercero'])
                    ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Dv'])
                    ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_RazonSocial'])
                    ->setCellValue('J'.$aux2_ContItems, $fila['planilla_produccion_TiempoEntrega'])
                    ->setCellValue('K'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_FormaPago'])
                    ->setCellValue('L'.$aux2_ContItems, nombreDepartamento(datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Departamento'])." - ".nombreCiudad(datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Ciudad']))
                    ->setCellValue('M'.$aux2_ContItems, datosTercero($fila['planilla_produccion_NitTercero'])['tercero_Direccion'])
                    ->setCellValue('N'.$aux2_ContItems, 'TOTAL PLANILLA')
                    ->setCellValue('O'.$aux2_ContItems, '1')
                    ->setCellValue('P'.$aux2_ContItems, $fila['planilla_produccion_Subtotal'])
                    ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                    ->setCellValue('R'.$aux2_ContItems, $fila['planilla_produccion_Vendedor'])
                    ->setCellValue('S'.$aux2_ContItems, $fila['planilla_produccion_Anulada']);
                if ($fila['planilla_produccion_Anulada'] == "NO") {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
                } else {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                }
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;
            }

            $spreadsheet->getActiveSheet()
                ->getStyle('P:P')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            
            $spreadsheet->getActiveSheet()
                ->getStyle('Q:Q')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            
            // Rename sheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_PP');

            $numeroHoja = $numeroHoja + 1;
        }

        //*********************************************************************************************
        //REMISIÓN

        if ($hojaRemision == 1) {

            $spreadsheet->createSheet($numeroHoja);

            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Año')
                ->setCellValue('B1', 'Mes')
                ->setCellValue('C1', 'Dia')
                ->setCellValue('D1', 'Remisión')
                ->setCellValue('E1', 'Factura venta')
                ->setCellValue('F1', 'Planilla producción')
                ->setCellValue('G1', 'Nit Tercero')
                ->setCellValue('H1', 'DV Tercero')
                ->setCellValue('I1', 'Razon Social')
                ->setCellValue('J1', 'Orden compra')
                ->setCellValue('K1', 'Forma pago')
                ->setCellValue('L1', 'Ciudad planta')
                ->setCellValue('M1', 'Dirección planta')
                ->setCellValue('N1', 'Detalle')
                ->setCellValue('O1', 'Cantidad')
                ->setCellValue('P1', 'Valor unitario')
                ->setCellValue('Q1', 'Valor total')
                ->setCellValue('R1', 'Vendedor')
                ->setCellValue('S1', 'ANULADA');

            $aux2_ContItems = 2;
            $consulta = "SELECT * FROM remision ORDER BY remision_Consecutivo DESC";
            $datos = mysqli_query($conexion, $consulta);
            while($fila = mysqli_fetch_array($datos)) {

                $IdRemision = $fila['remision_Id'];
                $ItemRemision = itemsRemision($IdRemision);
                $contItems = count($ItemRemision);
                $auxContItems = 0;

                while ($auxContItems < $contItems) {
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['remision_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['remision_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['remision_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['remision_Id'])
                        ->setCellValue('E'.$aux2_ContItems, FacturaVenta_Remisiones($fila['remision_Id']))
                        ->setCellValue('F'.$aux2_ContItems, $fila['remision_PlanillaProduccion'])
                        ->setCellValue('G'.$aux2_ContItems, $fila['remision_NitTercero'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['remision_NitTercero'])['tercero_Dv'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['remision_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('J'.$aux2_ContItems, $fila['remision_OrdenCompra'])
                        ->setCellValue('K'.$aux2_ContItems, datosTercero($fila['remision_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('L'.$aux2_ContItems, nombreDepartamento(datosPlantaTercero($fila['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($fila['remision_PlantaEntrega'])['planta_tercero_Ciudad']))
                        ->setCellValue('M'.$aux2_ContItems, datosPlantaTercero($fila['remision_PlantaEntrega'])['planta_tercero_Direccion'])
                        ->setCellValue('N'.$aux2_ContItems, $ItemRemision[$auxContItems])
                        ->setCellValue('O'.$aux2_ContItems, $ItemRemision[$auxContItems+1])
                        ->setCellValue('P'.$aux2_ContItems, $ItemRemision[$auxContItems+2])
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['remision_Vendedor'])
                        ->setCellValue('S'.$aux2_ContItems, $fila['remision_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                    $auxContItems = $auxContItems + 4;
                }

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['remision_Año'])
                    ->setCellValue('B'.$aux2_ContItems, $fila['remision_Mes'])
                    ->setCellValue('C'.$aux2_ContItems, $fila['remision_Dia'])
                    ->setCellValue('D'.$aux2_ContItems, $fila['remision_Id'])
                    ->setCellValue('E'.$aux2_ContItems, FacturaVenta_Remisiones($fila['remision_Id']))
                    ->setCellValue('F'.$aux2_ContItems, $fila['remision_PlanillaProduccion'])
                    ->setCellValue('G'.$aux2_ContItems, $fila['remision_NitTercero'])
                    ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['remision_NitTercero'])['tercero_Dv'])
                    ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['remision_NitTercero'])['tercero_RazonSocial'])
                    ->setCellValue('J'.$aux2_ContItems, $fila['remision_OrdenCompra'])
                    ->setCellValue('K'.$aux2_ContItems, datosTercero($fila['remision_NitTercero'])['tercero_FormaPago'])
                    ->setCellValue('L'.$aux2_ContItems, nombreDepartamento(datosPlantaTercero($fila['remision_PlantaEntrega'])['planta_tercero_Departamento'])." - ".nombreCiudad(datosPlantaTercero($fila['remision_PlantaEntrega'])['planta_tercero_Ciudad']))
                    ->setCellValue('M'.$aux2_ContItems, datosPlantaTercero($fila['remision_PlantaEntrega'])['planta_tercero_Direccion'])
                    ->setCellValue('N'.$aux2_ContItems, 'TOTAL REMISIÓN')
                    ->setCellValue('O'.$aux2_ContItems, '1')
                    ->setCellValue('P'.$aux2_ContItems, $fila['remision_Subtotal'])
                    ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                    ->setCellValue('R'.$aux2_ContItems, $fila['remision_Vendedor'])
                    ->setCellValue('S'.$aux2_ContItems, $fila['remision_Anulada']);
                if ($fila['remision_Anulada'] == "NO") {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
                } else {
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                }
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':S'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;
            }

            $spreadsheet->getActiveSheet()
                ->getStyle('P:P')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            
            $spreadsheet->getActiveSheet()
                ->getStyle('Q:Q')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            
            // Rename sheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_REM'); 

            $numeroHoja = $numeroHoja + 1;
        }

        //*********************************************************************************************
        //FACTURA DE VENTA

        if ($hojaFacturaVenta == 1) {

            $spreadsheet->createSheet($numeroHoja);

            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Año')
                ->setCellValue('B1', 'Mes')
                ->setCellValue('C1', 'Dia')
                ->setCellValue('D1', 'FV')
                ->setCellValue('E1', 'Remisión')
                ->setCellValue('F1', 'Nit Tercero')
                ->setCellValue('G1', 'DV Tercero')
                ->setCellValue('H1', 'Razon Social')
                ->setCellValue('I1', 'Forma pago')
                ->setCellValue('J1', 'Cuenta')
                ->setCellValue('K1', 'Detalle cuenta')
                ->setCellValue('L1', 'Detalle')
                ->setCellValue('M1', 'Cantidad')
                ->setCellValue('N1', 'Valor unitario')
                ->setCellValue('O1', 'DB')
                ->setCellValue('P1', 'HB')
                ->setCellValue('Q1', 'SALDO')
                ->setCellValue('R1', 'ANULADA');

            $aux2_ContItems = 2;
            $consulta = "SELECT * FROM facturaventa ORDER BY facturaventa_Consecutivo DESC";
            $datos = mysqli_query($conexion, $consulta);
            while($fila = mysqli_fetch_array($datos)) {

                $IdFacturaVenta = $fila['facturaventa_Id'];
                $contItems = 0;
                $auxContItems = 1;
                
                $DatosRemisiones = array();

                if ($fila['facturaventa_Remision1'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision1']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision1']);
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
                if ($fila['facturaventa_Remision2'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision2']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision2']);
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
                if ($fila['facturaventa_Remision3'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision3']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision3']);
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
                if ($fila['facturaventa_Remision4'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision4']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision4']);
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
                if ($fila['facturaventa_Remision5'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision5']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision5']);
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
                if ($fila['facturaventa_Remision6'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision6']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision6']);
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
                if ($fila['facturaventa_Remision7'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision7']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision7']);
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
                if ($fila['facturaventa_Remision8'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision8']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision8']);
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
                if ($fila['facturaventa_Remision9'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision9']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision9']);
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
                if ($fila['facturaventa_Remision10'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision10']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision10']);
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
                if ($fila['facturaventa_Remision11'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision11']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision11']);
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
                if ($fila['facturaventa_Remision12'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision12']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision12']);
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
                if ($fila['facturaventa_Remision13'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision13']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision13']);
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
                if ($fila['facturaventa_Remision14'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision14']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision14']);
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
                if ($fila['facturaventa_Remision15'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision15']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision15']);
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
                if ($fila['facturaventa_Remision16'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision16']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision16']);
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
                if ($fila['facturaventa_Remision17'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision17']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision17']);
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
                if ($fila['facturaventa_Remision18'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision18']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision18']);
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
                if ($fila['facturaventa_Remision19'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision19']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision19']);
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
                if ($fila['facturaventa_Remision20'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision20']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision20']);
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
                if ($fila['facturaventa_Remision21'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision21']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision21']);
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
                if ($fila['facturaventa_Remision22'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision22']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision22']);
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
                if ($fila['facturaventa_Remision23'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision23']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision23']);
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
                if ($fila['facturaventa_Remision24'] != NULL) {
                    $contItems = $contItems + contItemsRemision($fila['facturaventa_Remision24']);
                    $DatosRemision = itemsRemision($fila['facturaventa_Remision24']);
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
            
                $aux3_ContItems = 1;
                $cont_Remisiones = 0;

                if ($fila['facturaventa_Anulada'] == "NO") {

                    while ($aux3_ContItems <= $contItems) {
                        $spreadsheet->setActiveSheetIndex($numeroHoja)
                            ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                            ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                            ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                            ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                            ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                            ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                            ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                            ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                            ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                            ->setCellValue('J'.$aux2_ContItems, '41350501')
                            ->setCellValue('K'.$aux2_ContItems, 'CONSUMIBLES PARA PLANTAS DE PRODUCCION')
                            ->setCellValue('L'.$aux2_ContItems, $DatosRemisiones[$cont_Remisiones])
                            ->setCellValue('M'.$aux2_ContItems, $DatosRemisiones[$cont_Remisiones+1])
                            ->setCellValue('N'.$aux2_ContItems, $DatosRemisiones[$cont_Remisiones+2])
                            ->setCellValue('P'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                            ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                            ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                        $cont_Remisiones = $cont_Remisiones + 4;
                        $aux3_ContItems = $aux3_ContItems + 1;
                        $aux2_ContItems = $aux2_ContItems + 1;
                    }

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '')
                        ->setCellValue('K'.$aux2_ContItems, 'DESCUENTO')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorDescuento'])
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '24081001')
                        ->setCellValue('K'.$aux2_ContItems, 'IVA GENERADO 19%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorIVA_24081001'])
                        ->setCellValue('P'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    
                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551501')
                        ->setCellValue('K'.$aux2_ContItems, 'COMPRAS 2,5% (961,000 DECLARANTES)')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorCompras_13551501'])
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551701')
                        ->setCellValue('K'.$aux2_ContItems, 'RETE IVA 15%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorReteIVA_13551701'])
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551804')
                        ->setCellValue('K'.$aux2_ContItems, '11,04 * 1000 Demás actividades industriales')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorDemasActividadIndustriales_13551804'])
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    
                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '23657501')
                        ->setCellValue('K'.$aux2_ContItems, 'AUTORENTA ESPECIAL 2201 DEL 2016 0,80%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorAutoRentaEspecial_23657501'])
                        ->setCellValue('P'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551541')
                        ->setCellValue('K'.$aux2_ContItems, 'AUTORENTA ESPECIAL 2201 DEL 2016 0,80%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorAutoRentaEspecial_13551541'])
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13050501')
                        ->setCellValue('K'.$aux2_ContItems, 'CLIENTES NACIONALES')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorClientesNacionales_13050501'])
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                } else {

                    while ($aux3_ContItems <= $contItems) {
                        $spreadsheet->setActiveSheetIndex($numeroHoja)
                            ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                            ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                            ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                            ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                            ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                            ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                            ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                            ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                            ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                            ->setCellValue('J'.$aux2_ContItems, '41350501')
                            ->setCellValue('K'.$aux2_ContItems, 'CONSUMIBLES PARA PLANTAS DE PRODUCCION')
                            ->setCellValue('L'.$aux2_ContItems, $DatosRemisiones[$cont_Remisiones])
                            ->setCellValue('M'.$aux2_ContItems, $DatosRemisiones[$cont_Remisiones+1])
                            ->setCellValue('N'.$aux2_ContItems, $DatosRemisiones[$cont_Remisiones+2])
                            ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                        $cont_Remisiones = $cont_Remisiones + 4;
                        $aux3_ContItems = $aux3_ContItems + 1;
                        $aux2_ContItems = $aux2_ContItems + 1;
                    }

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '')
                        ->setCellValue('K'.$aux2_ContItems, 'DESCUENTO')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorDescuento'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '24081001')
                        ->setCellValue('K'.$aux2_ContItems, 'IVA GENERADO 19%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorIVA_24081001'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    
                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551501')
                        ->setCellValue('K'.$aux2_ContItems, 'COMPRAS 2,5% (961,000 DECLARANTES)')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorCompras_13551501'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551701')
                        ->setCellValue('K'.$aux2_ContItems, 'RETE IVA 15%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorReteIVA_13551701'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551804')
                        ->setCellValue('K'.$aux2_ContItems, '11,04 * 1000 Demás actividades industriales')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorDemasActividadIndustriales_13551804'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    
                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '23657501')
                        ->setCellValue('K'.$aux2_ContItems, 'AUTORENTA ESPECIAL 2201 DEL 2016 0,80%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorAutoRentaEspecial_23657501'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13551541')
                        ->setCellValue('K'.$aux2_ContItems, 'AUTORENTA ESPECIAL 2201 DEL 2016 0,80%')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorAutoRentaEspecial_13551541'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');

                    $aux2_ContItems = $aux2_ContItems + 1;
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $fila['facturaventa_Año'])
                        ->setCellValue('B'.$aux2_ContItems, $fila['facturaventa_Mes'])
                        ->setCellValue('C'.$aux2_ContItems, $fila['facturaventa_Dia'])
                        ->setCellValue('D'.$aux2_ContItems, $fila['facturaventa_Id'])
                        ->setCellValue('E'.$aux2_ContItems, $fila['facturaventa_Remision'])
                        ->setCellValue('F'.$aux2_ContItems, $fila['facturaventa_NitTercero'])
                        ->setCellValue('G'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_Dv'])
                        ->setCellValue('H'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('I'.$aux2_ContItems, datosTercero($fila['facturaventa_NitTercero'])['tercero_FormaPago'])
                        ->setCellValue('J'.$aux2_ContItems, '13050501')
                        ->setCellValue('K'.$aux2_ContItems, 'CLIENTES NACIONALES')
                        ->setCellValue('L'.$aux2_ContItems, $fila['facturaventa_Id']." ".datosTercero($fila['facturaventa_NitTercero'])['tercero_RazonSocial'])
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $fila['facturaventa_ValorClientesNacionales_13050501'])
                        ->setCellValue('R'.$aux2_ContItems, $fila['facturaventa_Anulada']);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':R'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                }
            }

            $spreadsheet->getActiveSheet()
                ->getStyle('N:N')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('O:O')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            
            $spreadsheet->getActiveSheet()
                ->getStyle('P:P')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('Q:Q')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:R1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:R1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            
            // Rename worksheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_FV');

            $numeroHoja = $numeroHoja + 1;
        }

        //*******************************************************************************************
        //LEGALIZACIONES CM

        if ($hojaLegalizacionCM == 1) {

            $spreadsheet->createSheet($numeroHoja);

            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Año')
                ->setCellValue('B1', 'Mes')
                ->setCellValue('C1', 'Dia')
                ->setCellValue('D1', 'Legalización')
                ->setCellValue('E1', 'COT_CC')
                ->setCellValue('F1', 'Centro costo')
                ->setCellValue('G1', 'Nit Tercero')
                ->setCellValue('H1', 'Razon Social')
                ->setCellValue('I1', 'Pago')
                ->setCellValue('J1', 'Cuenta')
                ->setCellValue('K1', 'Detalle cuenta')
                ->setCellValue('L1', 'Detalle')
                ->setCellValue('M1', 'Cantidad')
                ->setCellValue('N1', 'Valor unitario')
                ->setCellValue('O1', 'Valor total')
                ->setCellValue('P1', 'DB')
                ->setCellValue('Q1', 'HB')
                ->setCellValue('R1', 'SALDO')
                ->setCellValue('S1', 'Usuario')
                ->setCellValue('T1', 'ANULADA');

            $aux2_ContItems = 2;
            $Legalizaciones = listaLegalizacionesCM();
            for ($i = 0; $i < count($Legalizaciones); $i += 2) {

                $IdLegalizacion = $Legalizaciones[$i];
                $DatosLegalizacion = datosLegalizacionCM($IdLegalizacion);

                $legalizacion_cm_Id = $DatosLegalizacion[0];
                $legalizacion_cm_Año = $DatosLegalizacion[1];
                $legalizacion_cm_Mes = $DatosLegalizacion[2];
                $legalizacion_cm_Dia = $DatosLegalizacion[3];
                $legalizacion_cm_NitTercero = $DatosLegalizacion[4];
                $legalizacion_cm_DVTercero = $DatosLegalizacion[5];
                $legalizacion_cm_RazonSocialTercero = $DatosLegalizacion[6];
                $legalizacion_cm_Usuario = $DatosLegalizacion[7];
                $legalizacion_cm_Anulada = $DatosLegalizacion[8];
                $legalizacion_cm_ValorSubtotalItems = 0;
                $legalizacion_cm_ValorIvaItems = 0;

                $PosItems = 9;
                $CantidadItems = cantidadDatosLegalizacionCM($legalizacion_cm_Id);
                $AuxCantidadItems = 1;

                if ($legalizacion_cm_Anulada == "NO") {
                    while ($AuxCantidadItems <= $CantidadItems) {

                        $spreadsheet->setActiveSheetIndex($numeroHoja)
                            ->setCellValue('A'.$aux2_ContItems, $legalizacion_cm_Año)
                            ->setCellValue('B'.$aux2_ContItems, $legalizacion_cm_Mes)
                            ->setCellValue('C'.$aux2_ContItems, $legalizacion_cm_Dia)
                            ->setCellValue('D'.$aux2_ContItems, $legalizacion_cm_Id)
                            ->setCellValue('E'.$aux2_ContItems, $legalizacion_cm_NitTercero)
                            ->setCellValue('F'.$aux2_ContItems, $DatosLegalizacion[$PosItems])
                            ->setCellValue('G'.$aux2_ContItems, $DatosLegalizacion[$PosItems+1])
                            ->setCellValue('H'.$aux2_ContItems, $DatosLegalizacion[$PosItems+2])
                            ->setCellValue('I'.$aux2_ContItems, 'CONTADO')
                            ->setCellValue('J'.$aux2_ContItems, $DatosLegalizacion[$PosItems+8])
                            ->setCellValue('K'.$aux2_ContItems, nombrePucSubcuenta($DatosLegalizacion[$PosItems+8]))
                            ->setCellValue('L'.$aux2_ContItems, $DatosLegalizacion[$PosItems+3])
                            ->setCellValue('M'.$aux2_ContItems, $DatosLegalizacion[$PosItems+4])
                            ->setCellValue('N'.$aux2_ContItems, $DatosLegalizacion[$PosItems+5])
                            ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                            ->setCellValue('P'.$aux2_ContItems, '=O'.$aux2_ContItems)
                            ->setCellValue('R'.$aux2_ContItems, '=P'.$aux2_ContItems.'-Q'.$aux2_ContItems)
                            ->setCellValue('S'.$aux2_ContItems, $legalizacion_cm_Usuario)
                            ->setCellValue('T'.$aux2_ContItems, $legalizacion_cm_Anulada);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                        
                        $legalizacion_cm_ValorSubtotalItems += $DatosLegalizacion[$PosItems+6];
                        $legalizacion_cm_ValorIvaItems += $DatosLegalizacion[$PosItems+7];
                        $PosItems = $PosItems + 9;
                        $AuxCantidadItems = $AuxCantidadItems + 1;
                        $aux2_ContItems = $aux2_ContItems + 1;
                    }

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cm_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cm_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cm_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cm_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cm_NitTercero)
                        ->setCellValue('I'.$aux2_ContItems, 'CONTADO')
                        ->setCellValue('J'.$aux2_ContItems, '24080501')
                        ->setCellValue('K'.$aux2_ContItems, 'IVA DESCONTABLE 19%')
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cm_ValorIvaItems)
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('P'.$aux2_ContItems, '=O'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, '=P'.$aux2_ContItems.'-Q'.$aux2_ContItems)
                        ->setCellValue('S'.$aux2_ContItems, $legalizacion_cm_Usuario)
                        ->setCellValue('T'.$aux2_ContItems, $legalizacion_cm_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cm_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cm_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cm_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cm_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cm_NitTercero)
                        ->setCellValue('I'.$aux2_ContItems, 'CONTADO')
                        ->setCellValue('J'.$aux2_ContItems, '11200501')
                        ->setCellValue('K'.$aux2_ContItems, 'BANCO CAJA SOCIAL CUENTA DE AHORROS 24098446818')
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, ($legalizacion_cm_ValorSubtotalItems+$legalizacion_cm_ValorIvaItems))
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'-P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, '=P'.$aux2_ContItems.'-Q'.$aux2_ContItems)
                        ->setCellValue('S'.$aux2_ContItems, $legalizacion_cm_Usuario)
                        ->setCellValue('T'.$aux2_ContItems, $legalizacion_cm_Anulada);
                    
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                } else {

                    while ($AuxCantidadItems <= $CantidadItems) {

                        $spreadsheet->setActiveSheetIndex($numeroHoja)
                            ->setCellValue('A'.$aux2_ContItems, $legalizacion_cm_Año)
                            ->setCellValue('B'.$aux2_ContItems, $legalizacion_cm_Mes)
                            ->setCellValue('C'.$aux2_ContItems, $legalizacion_cm_Dia)
                            ->setCellValue('D'.$aux2_ContItems, $legalizacion_cm_Id)
                            ->setCellValue('E'.$aux2_ContItems, $legalizacion_cm_NitTercero)
                            ->setCellValue('F'.$aux2_ContItems, $DatosLegalizacion[$PosItems])
                            ->setCellValue('G'.$aux2_ContItems, $DatosLegalizacion[$PosItems+1])
                            ->setCellValue('H'.$aux2_ContItems, $DatosLegalizacion[$PosItems+2])
                            ->setCellValue('I'.$aux2_ContItems, 'CONTADO')
                            ->setCellValue('J'.$aux2_ContItems, $DatosLegalizacion[$PosItems+8])
                            ->setCellValue('K'.$aux2_ContItems, nombrePucSubcuenta($DatosLegalizacion[$PosItems+8]))
                            ->setCellValue('L'.$aux2_ContItems, $DatosLegalizacion[$PosItems+3])
                            ->setCellValue('M'.$aux2_ContItems, $DatosLegalizacion[$PosItems+4])
                            ->setCellValue('N'.$aux2_ContItems, $DatosLegalizacion[$PosItems+5])
                            ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                            ->setCellValue('S'.$aux2_ContItems, $legalizacion_cm_Usuario)
                            ->setCellValue('T'.$aux2_ContItems, $legalizacion_cm_Anulada);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                        
                        $legalizacion_cm_ValorSubtotalItems += $DatosLegalizacion[$PosItems+6];
                        $legalizacion_cm_ValorIvaItems += $DatosLegalizacion[$PosItems+7];
                        $PosItems = $PosItems + 9;
                        $AuxCantidadItems = $AuxCantidadItems + 1;
                        $aux2_ContItems = $aux2_ContItems + 1;
                    }

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cm_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cm_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cm_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cm_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cm_NitTercero)
                        ->setCellValue('I'.$aux2_ContItems, 'CONTADO')
                        ->setCellValue('J'.$aux2_ContItems, '24080501')
                        ->setCellValue('K'.$aux2_ContItems, 'IVA DESCONTABLE 19%')
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cm_ValorIvaItems)
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('S'.$aux2_ContItems, $legalizacion_cm_Usuario)
                        ->setCellValue('T'.$aux2_ContItems, $legalizacion_cm_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cm_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cm_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cm_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cm_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cm_NitTercero)
                        ->setCellValue('I'.$aux2_ContItems, 'CONTADO')
                        ->setCellValue('J'.$aux2_ContItems, '11200501')
                        ->setCellValue('K'.$aux2_ContItems, 'BANCO CAJA SOCIAL CUENTA DE AHORROS 24098446818')
                        ->setCellValue('M'.$aux2_ContItems, '1')
                        ->setCellValue('N'.$aux2_ContItems, ($legalizacion_cm_ValorSubtotalItems+$legalizacion_cm_ValorIvaItems))
                        ->setCellValue('O'.$aux2_ContItems, '=M'.$aux2_ContItems.'*N'.$aux2_ContItems)
                        ->setCellValue('S'.$aux2_ContItems, $legalizacion_cm_Usuario)
                        ->setCellValue('T'.$aux2_ContItems, $legalizacion_cm_Anulada);
                    
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':T'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                }
                
            }

            $spreadsheet->getActiveSheet()
                ->getStyle('N:N')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('O:O')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('P:P')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('Q:Q')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            
            $spreadsheet->getActiveSheet()
                ->getStyle('R:R')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()->getStyle('A1:T1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:T1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:T1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
            
            // Rename worksheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_LEG_CM');   
            
            $numeroHoja = $numeroHoja + 1;
        }

        //*******************************************************************************************
        //LEGALIZACIONES CXP

        if ($hojaLegalizacionCXP == 1) {

            $spreadsheet->createSheet($numeroHoja);

            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Año')
                ->setCellValue('B1', 'Mes')
                ->setCellValue('C1', 'Dia')
                ->setCellValue('D1', 'Legalización')
                ->setCellValue('E1', 'COT_CC')
                ->setCellValue('F1', 'Centro costo')
                ->setCellValue('G1', 'Nit Tercero')
                ->setCellValue('H1', 'Razón Social')
                ->setCellValue('I1', 'Factura compra')
                ->setCellValue('J1', 'Nit cliente')
                ->setCellValue('K1', 'Razón social cliente')
                ->setCellValue('L1', 'Cuenta')
                ->setCellValue('M1', 'Detalle cuenta')
                ->setCellValue('N1', 'Detalle')
                ->setCellValue('O1', 'Cantidad')
                ->setCellValue('P1', 'Valor unitario')
                ->setCellValue('Q1', 'Valor total')
                ->setCellValue('R1', 'DB')
                ->setCellValue('S1', 'HB')
                ->setCellValue('T1', 'SALDO')
                ->setCellValue('U1', 'Usuario')
                ->setCellValue('V1', 'ANULADA');

            $aux2_ContItems = 2;
            $Legalizaciones = listaLegalizacionesCXP();
            for ($i = 0; $i < count($Legalizaciones); $i += 2) {

                $IdLegalizacion = $Legalizaciones[$i];
                $DatosLegalizacion = datosLegalizacionCXP($IdLegalizacion);
                
                $legalizacion_cxp_Año = $DatosLegalizacion[1];
                $legalizacion_cxp_Mes = $DatosLegalizacion[2];
                $legalizacion_cxp_Dia = $DatosLegalizacion[3];
                $legalizacion_cxp_Id = $DatosLegalizacion[0];
                $legalizacion_cxp_Cotizacion = $DatosLegalizacion[11];
                $legalizacion_cxp_CentroCosto = $DatosLegalizacion[12];
                $legalizacion_cxp_NitTercero = $DatosLegalizacion[4];
                $legalizacion_cxp_RazonSocialTercero = $DatosLegalizacion[6];
                $legalizacion_cxp_FacturaCompra = $DatosLegalizacion[13];
                $legalizacion_cxp_NitCliente = $DatosLegalizacion[14];
                $legalizacion_cxp_RazonSocialCliente = $DatosLegalizacion[15];
                $legalizacion_cxp_Usuario = $DatosLegalizacion[16];
                $legalizacion_cxp_Anulada = $DatosLegalizacion[17];
                $ValorSubtotalItems = 0;
                $ValorIvaItems = 0;

                $PosItems = 18;
                $CantidadItems = cantidadDatosLegalizacionCXP($IdLegalizacion);
                $AuxCantidadItems = 1;

                if ($legalizacion_cxp_Anulada == "NO") {
                    while ($AuxCantidadItems <= $CantidadItems) {

                        $spreadsheet->setActiveSheetIndex($numeroHoja)
                            ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                            ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                            ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                            ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                            ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                            ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                            ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                            ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                            ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                            ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                            ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                            ->setCellValue('L'.$aux2_ContItems, $DatosLegalizacion[$PosItems])
                            ->setCellValue('M'.$aux2_ContItems, nombrePucSubcuenta($DatosLegalizacion[$PosItems]))
                            ->setCellValue('N'.$aux2_ContItems, $DatosLegalizacion[$PosItems+1])
                            ->setCellValue('O'.$aux2_ContItems, $DatosLegalizacion[$PosItems+2])
                            ->setCellValue('P'.$aux2_ContItems, $DatosLegalizacion[$PosItems+3])
                            ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                            ->setCellValue('R'.$aux2_ContItems, '=Q'.$aux2_ContItems)
                            ->setCellValue('T'.$aux2_ContItems, '=R'.$aux2_ContItems.'-S'.$aux2_ContItems)
                            ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                            ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                        
                        $ValorSubtotalItems += $DatosLegalizacion[$PosItems+4];
                        $ValorIvaItems += $DatosLegalizacion[$PosItems+5];
                        $PosItems = $PosItems + 6;
                        $AuxCantidadItems = $AuxCantidadItems + 1;
                        $aux2_ContItems = $aux2_ContItems + 1;
                    }

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '24080501')
                        ->setCellValue('M'.$aux2_ContItems, 'IVA DESCONTABLE 19%')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, $ValorIvaItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('R'.$aux2_ContItems, '=Q'.$aux2_ContItems)
                        ->setCellValue('T'.$aux2_ContItems, '=R'.$aux2_ContItems.'-S'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;

                    $ReteFuente_cxp = 0;
                    if ($ValorSubtotalItems > 895000) { 
                        $ReteFuente_cxp = ($ValorSubtotalItems*0.025);
                    }
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '23654001')
                        ->setCellValue('M'.$aux2_ContItems, 'RTE F. COMPRAS 2,5%')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, $ReteFuente_cxp)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('S'.$aux2_ContItems, '=Q'.$aux2_ContItems)
                        ->setCellValue('T'.$aux2_ContItems, '=R'.$aux2_ContItems.'-S'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;

                    $ReteICA_cxp = (($ValorSubtotalItems*11.04)/1000);
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '23680501')
                        ->setCellValue('M'.$aux2_ContItems, 'RETE ICA COMPRAS 11,04*1000')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, $ReteICA_cxp)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('S'.$aux2_ContItems, '=Q'.$aux2_ContItems)
                        ->setCellValue('T'.$aux2_ContItems, '=R'.$aux2_ContItems.'-S'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;

                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '23359502')
                        ->setCellValue('M'.$aux2_ContItems, 'MALLAS COMERCIALIZACION')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, ($ValorSubtotalItems+$ValorIvaItems)-$ReteFuente_cxp-$ReteICA_cxp)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('S'.$aux2_ContItems, '=Q'.$aux2_ContItems)
                        ->setCellValue('T'.$aux2_ContItems, '=R'.$aux2_ContItems.'-S'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);              
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                } else {
                    while ($AuxCantidadItems <= $CantidadItems) {

                        $spreadsheet->setActiveSheetIndex($numeroHoja)
                            ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                            ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                            ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                            ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                            ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                            ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                            ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                            ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                            ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                            ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                            ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                            ->setCellValue('L'.$aux2_ContItems, $DatosLegalizacion[$PosItems])
                            ->setCellValue('M'.$aux2_ContItems, nombrePucSubcuenta($DatosLegalizacion[$PosItems]))
                            ->setCellValue('N'.$aux2_ContItems, $DatosLegalizacion[$PosItems+1])
                            ->setCellValue('O'.$aux2_ContItems, $DatosLegalizacion[$PosItems+2])
                            ->setCellValue('P'.$aux2_ContItems, $DatosLegalizacion[$PosItems+3])
                            ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                            ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                            ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                        $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                        
                        $ValorSubtotalItems += $DatosLegalizacion[$PosItems+4];
                        $ValorIvaItems += $DatosLegalizacion[$PosItems+5];
                        $PosItems = $PosItems + 6;
                        $AuxCantidadItems = $AuxCantidadItems + 1;
                        $aux2_ContItems = $aux2_ContItems + 1;
                    }
    
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '24080501')
                        ->setCellValue('M'.$aux2_ContItems, 'IVA DESCONTABLE 19%')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, $ValorIvaItems)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
    
                    $ReteFuente_cxp = 0;
                    if ($ValorSubtotalItems > 895000) { 
                        $ReteFuente_cxp = ($ValorSubtotalItems*0.025);
                    }
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '23654001')
                        ->setCellValue('M'.$aux2_ContItems, 'RTE F. COMPRAS 2,5%')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, $ReteFuente_cxp)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
    
                    $ReteICA_cxp = (($ValorSubtotalItems*11.04)/1000);
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '23680501')
                        ->setCellValue('M'.$aux2_ContItems, 'RETE ICA COMPRAS 11,04*1000')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, $ReteICA_cxp)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
    
                    $spreadsheet->setActiveSheetIndex($numeroHoja)
                        ->setCellValue('A'.$aux2_ContItems, $legalizacion_cxp_Año)
                        ->setCellValue('B'.$aux2_ContItems, $legalizacion_cxp_Mes)
                        ->setCellValue('C'.$aux2_ContItems, $legalizacion_cxp_Dia)
                        ->setCellValue('D'.$aux2_ContItems, $legalizacion_cxp_Id)
                        ->setCellValue('E'.$aux2_ContItems, $legalizacion_cxp_Cotizacion)
                        ->setCellValue('F'.$aux2_ContItems, $legalizacion_cxp_CentroCosto)
                        ->setCellValue('G'.$aux2_ContItems, $legalizacion_cxp_NitTercero)
                        ->setCellValue('H'.$aux2_ContItems, $legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('I'.$aux2_ContItems, $legalizacion_cxp_FacturaCompra)
                        ->setCellValue('J'.$aux2_ContItems, $legalizacion_cxp_NitCliente)
                        ->setCellValue('K'.$aux2_ContItems, $legalizacion_cxp_RazonSocialCliente)
                        ->setCellValue('L'.$aux2_ContItems, '23359502')
                        ->setCellValue('M'.$aux2_ContItems, 'MALLAS COMERCIALIZACION')
                        ->setCellValue('N'.$aux2_ContItems, $legalizacion_cxp_Cotizacion." ".$legalizacion_cxp_RazonSocialTercero)
                        ->setCellValue('O'.$aux2_ContItems, '1')
                        ->setCellValue('P'.$aux2_ContItems, ($ValorSubtotalItems+$ValorIvaItems)-$ReteFuente_cxp-$ReteICA_cxp)
                        ->setCellValue('Q'.$aux2_ContItems, '=O'.$aux2_ContItems.'*P'.$aux2_ContItems)
                        ->setCellValue('U'.$aux2_ContItems, $legalizacion_cxp_Usuario)
                        ->setCellValue('V'.$aux2_ContItems, $legalizacion_cxp_Anulada);              
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
                    $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':V'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                    $aux2_ContItems = $aux2_ContItems + 1;
                }
                
            }

            $spreadsheet->getActiveSheet()
                ->getStyle('P:P')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('Q:Q')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
            
            $spreadsheet->getActiveSheet()
                ->getStyle('R:R')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('S:S')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()
                ->getStyle('T:T')
                ->getNumberFormat()
                ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

            $spreadsheet->getActiveSheet()->getStyle('A1:V1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:V1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:V1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
            
            // Rename worksheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_LEG_CXP');   
            
            $numeroHoja = $numeroHoja + 1;
        }

        //*********************************************************************************************
        //TERCEROS

        if ($hojaTerceros == 1) {

            $spreadsheet->createSheet($numeroHoja);
            
            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Nit Tercero')
                ->setCellValue('B1', 'DV Tercero')
                ->setCellValue('C1', 'Razon Social')
                ->setCellValue('D1', 'Contacto')
                ->setCellValue('E1', 'Direccion')
                ->setCellValue('F1', 'Departamento')
                ->setCellValue('G1', 'Ciudad')
                ->setCellValue('H1', 'Telefono 1')
                ->setCellValue('I1', 'Telefono 2')
                ->setCellValue('J1', 'Dias de pago')
                ->setCellValue('K1', 'Email')
                ->setCellValue('L1', 'Forma de pago')
                ->setCellValue('M1', '% Retefuente')
                ->setCellValue('N1', '% Descuento')
                ->setCellValue('O1', 'Tipo tercero')
                ->setCellValue('P1', 'Link ubicación')
                ;

            $aux2_ContItems = 2;
            $consulta = "SELECT * FROM tercero ORDER BY tercero_RazonSocial DESC";
            $datos = mysqli_query($conexion, $consulta);
            while($fila = mysqli_fetch_array($datos)) {

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['tercero_Nit'])
                    ->setCellValue('B'.$aux2_ContItems, $fila['tercero_Dv'])
                    ->setCellValue('C'.$aux2_ContItems, $fila['tercero_RazonSocial'])
                    ->setCellValue('D'.$aux2_ContItems, $fila['tercero_Contacto'])
                    ->setCellValue('E'.$aux2_ContItems, $fila['tercero_Direccion'])
                    ->setCellValue('F'.$aux2_ContItems, nombreDepartamento($fila['tercero_Departamento']))
                    ->setCellValue('G'.$aux2_ContItems, nombreCiudad($fila['tercero_Ciudad']))
                    ->setCellValue('H'.$aux2_ContItems, $fila['tercero_Telefono1'])
                    ->setCellValue('I'.$aux2_ContItems, $fila['tercero_Telefono2'])
                    ->setCellValue('J'.$aux2_ContItems, $fila['tercero_DiasPago'])
                    ->setCellValue('K'.$aux2_ContItems, $fila['tercero_Email'])
                    ->setCellValue('L'.$aux2_ContItems, $fila['tercero_FormaPago'])
                    ->setCellValue('M'.$aux2_ContItems, $fila['tercero_PorcentajeRetefuente'].'%')
                    ->setCellValue('N'.$aux2_ContItems, $fila['tercero_PorcentajeDescuento'].'%')
                    ->setCellValue('O'.$aux2_ContItems, $fila['tercero_Tipo'])
                    ->setCellValue('P'.$aux2_ContItems, $fila['tercero_Ubicacion']);
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':P'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;
            }

            $spreadsheet->getActiveSheet()->getStyle('A1:P1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:P1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

            // Rename sheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_TERCEROS');

            $numeroHoja = $numeroHoja + 1;
        }
        
        //*********************************************************************************************
        //PLANTAS TERCEROS

        if ($hojaPlantasTerceros == 1) {

            $spreadsheet->createSheet($numeroHoja);
            
            $spreadsheet->setActiveSheetIndex($numeroHoja)
                ->setCellValue('A1', 'Nit Tercero')
                ->setCellValue('B1', 'Razon Social')
                ->setCellValue('C1', 'Contacto')
                ->setCellValue('D1', 'Departamento')
                ->setCellValue('E1', 'Ciudad')
                ->setCellValue('F1', 'Direccion')
                ->setCellValue('G1', 'Telefono 1')
                ->setCellValue('H1', 'Telefono 2')
                ->setCellValue('I1', 'Email')
                ->setCellValue('J1', 'Ubicación')
                ;

            $aux2_ContItems = 2;
            $consulta = "SELECT * FROM planta_tercero ORDER BY planta_tercero_NitTercero DESC";
            $datos = mysqli_query($conexion, $consulta);
            while($fila = mysqli_fetch_array($datos)) {

                $spreadsheet->setActiveSheetIndex($numeroHoja)
                    ->setCellValue('A'.$aux2_ContItems, $fila['planta_tercero_NitTercero'])
                    ->setCellValue('B'.$aux2_ContItems, nombreTercero($fila['planta_tercero_NitTercero']))
                    ->setCellValue('C'.$aux2_ContItems, $fila['planta_tercero_Contacto'])
                    ->setCellValue('D'.$aux2_ContItems, nombreDepartamento($fila['planta_tercero_Departamento']))
                    ->setCellValue('E'.$aux2_ContItems, nombreCiudad($fila['planta_tercero_Ciudad']))
                    ->setCellValue('F'.$aux2_ContItems, $fila['planta_tercero_Direccion'])
                    ->setCellValue('G'.$aux2_ContItems, $fila['planta_tercero_Telefono1'])
                    ->setCellValue('H'.$aux2_ContItems, $fila['planta_tercero_Telefono2'])
                    ->setCellValue('I'.$aux2_ContItems, $fila['planta_tercero_Email'])
                    ->setCellValue('J'.$aux2_ContItems, $fila['planta_tercero_Ubicacion'])
                    ;
                $spreadsheet->getActiveSheet()->getStyle('A'.$aux2_ContItems.':J'.$aux2_ContItems)->getAlignment()->setHorizontal('center');
                $aux2_ContItems = $aux2_ContItems + 1;
            }

            $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
            $spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

            // Rename sheet
            $spreadsheet->getActiveSheet()
                ->setTitle('DATA_PLANTAS_TERCEROS');

            $numeroHoja = $numeroHoja + 1;
        }  

        // Save    
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        mysqli_close($conexion);
    }
?>