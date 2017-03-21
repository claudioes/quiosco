<?php
namespace App\Helper\LP_Export;

class Pdf extends Base {
    function save($filename) {
        $html = $this->html();

        $pdf = new \mikehaertl\wkhtmlto\Pdf([
            'commandOptions' => [
                'useExec' => true,
            ],
            'encoding'      => 'UTF-8',
            'no-outline',   // Make Chrome not complain
            'page-size'     => 'A4',
            'margin-top'    => 4,
            'margin-right'  => 4,
            'margin-bottom' => 4,
            'margin-left'   => 4,
            'disable-smart-shrinking',
            'zoom'          => WKHTMLTOPDF_ZOOM // Soluciona problemas con el tamaño de letra en servidores Linux
        ]);

        $pdf->addPage($html);

        if (file_exists($filename)) {
            unlink($filename);
        }

        return $pdf->saveAs($filename);
    }
}
