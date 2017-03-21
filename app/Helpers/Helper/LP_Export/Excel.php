<?php
namespace App\Helper\LP_Export;

class Excel extends Base {
    function save($filename) {
        if (!file_exists($this->templateExcel)) {
            return false;
        }

        if (file_exists($filename)) {
            unlink($filename);
        }

        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $excel = $reader->load($this->templateExcel);
        $ws = $excel->getActiveSheet();

        $ws->setCellValue('A9', 'Lista Nº ' . $this->numero);
        $ws->setCellValue('A10', 'Última modificación ' . $this->fecha->format('d/m/Y'));

        $styleFamilia = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['argb' => 'FFD8E4BC'],
            ],
            'font' => [
                'bold' => true,
                'size' => 10,
            ],
            // 'borders' => [
            //     'allborders' => [
            //         'style' => \PHPExcel_Style_Border::BORDER_THIN,
            //         'color' => ['rgb' => 'FF000000'],
            //     ]
            // ],
        ];

        $styleMarca = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'type' => \PHPExcel_Style_Fill::FILL_SOLID,
				'color' => ['argb' => 'FFF2F2F2'],
            ],
            'font' => [
                'bold' => true,
            ]
        ];

        $familiaAnterior = 0;
        $marcaAnterior = 0;
        $row = 14;
        $rows = count((array)$this->articulos) * 3; //el peor de los casos
        $ws->insertNewRowBefore($row+1, $rows);

        foreach((array)$this->articulos as $data) {
            if ((int)$data['familia_id'] != $familiaAnterior) {
                $familiaAnterior = (int)$data['familia_id'];
                $ws->setCellValue("A$row", $data['familia_nombre']);
                $ws->mergeCells("A$row:C$row");
                $ws->getStyle("A$row:C$row")->applyFromArray($styleFamilia);
                $row++;
                $rows--;
            }

            if ((int)$data['marca_id'] != $marcaAnterior) {
                $marcaAnterior = (int)$data['marca_id'];
                $ws->setCellValue("A$row", $data['marca_nombre']);
                $ws->mergeCells("A$row:C$row");
                $ws->getStyle("A$row:C$row")->applyFromArray($styleMarca);
                $row++;
                $rows--;
            }

            $ws->setCellValue("A$row", $data['codigo']);
            $ws->setCellValue("B$row", $data['descripcion']);
            $precio = round((float)$data['precio'] * (1+$this->recargo/100), 2);
            $ws->setCellValue("C$row", $precio);

            $row++;
            $rows--;
        }
        $ws->removeRow($row, $rows);

        $writer = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $writer->save($filename);
        return file_exists($filename);
    }
}
