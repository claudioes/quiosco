<?php
namespace App\Helpers;

class Helper
{
    # Devuelve un array simple sin indexar (por defecto NotORM lo devuelve indexado usando la PK)
    public static function resultArray($result)
    {
        return array_map('iterator_to_array', iterator_to_array($result, false));
    }

    public static function serializeResult($r)
    {
        return array_map('iterator_to_array', iterator_to_array($r, false));
    }

    # Devuelve un string con el formato especificado a partir de una fecha en ingles US
    # Ej: formatDate('2015-10-21', 'd/m/y') >> '21/10/15'
    public static function formatDate($d, $f='Y-m-d')
    {
        return date($f, strtotime($d));
    }

    # Devuelve una fecha desde un string con el formato especificado
    # Ej: createDate('16/10/2015', 'd/m/Y') >> (object)->format('Y-m-d') >> '2015-10-16'
    public static function createDate($s, $f='d/m/Y')
    {
        $d = DateTime::createFromFormat($f, $s);
        if ($d) {
            return $d;
        }
        throw new Exception('Helper::createDate(): No se pudo convertir la fecha con el formato especificado');
    }

    public static function emptyToNull($val)
    {
        if (empty(trim($val))) {
            return null;
        }

        return $val;
    }
}
