<?php
namespace App\Helper\LP_Export;

abstract class Base {
    public $view;
    public $templateTwig;
    public $templateExcel;
    public $cabecera;
    public $numero;
    public $fecha;
    public $recargo;
    public $articulos;
    public $notas;

    function save($fileName) {
    }

    function html() {
        return $this->view->render($this->templateTwig, [
            'numero'    => $this->numero,
            'fecha'     => $this->fecha,
            'recargo'   => $this->recargo,
            'notas'     => $this->notas,
            'cabecera'  => $this->cabecera,
            'articulos' => $this->articulos,
        ]);
    }

    // function excelTags($worksheet) {
    //     $tags = [];
    //
    //     foreach ($worksheet->getRowIterator() as $row) {
    //         $cellIterator = $row->getCellIterator();
    //         $cellIterator->setIterateOnlyExistingCells(true);
    //
    //         foreach ($cellIterator as $cell) {
    //             $value = trim($cell->getValue());
    //
    //             if (preg_match('/^\{(.*?)$\}/', strtolower($value))) {
    //                 $tags[substr(strtolower($value), 1, -1)] = $cell->getCoordinate();
    //             }
    //         }
    //     }
    //
    //     return $tags;
    // }
}
