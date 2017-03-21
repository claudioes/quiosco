<?php
namespace App\Helper\LP_Export;

class Html extends Base {
    function save($filename) {
        $html = $this->html();

        return file_put_contents($filename, $html);
    }
}
