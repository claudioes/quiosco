<?php

namespace App\Helper\InformeArticulo;

class InformeArticulo
{
    private $pdo;
    private $params;
    private $errors;

    public function __construct(\PDO $pdo, array $params)
    {
        $this->pdo = $pdo;
        $this->params = $params;
    }

    public function isValid()
    {
        $this->errores = [];

        $desde = \DateTime::createFromFormat(DATE_FORMAT, $this->params['desde']);
        if ( ! $desde) {
            $this->errores[] = 'La fecha desde es incorrecta';
        }

        $hasta = \DateTime::createFromFormat(DATE_FORMAT, $this->params['hasta']);
        if ( ! $hasta) {
            $this->errores[] = 'La fecha hasta es incorrecta';
        }

        if ($desde > $hasta) {
            $this->errores[] = 'La fecha desde no puede ser mayor a la fecha hasta';
        }

        return count($this->errors) === 0;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getData()
    {
        $desde = \DateTime::createFromFormat(DATE_FORMAT, $this->params['desde']);
        $hasta = \DateTime::createFromFormat(DATE_FORMAT, $this->params['hasta']);

        $sql = "
            SELECT
                a.id AS articulo_id,
                a.codigo AS articulo_codigo,
                a.descripcion AS articulo_descripcion,
                a.iva AS articulo_iva,
                a.costo AS articulo_costo,
                a.descuento1 AS articulo_descuento1,
                a.descuento2 AS articulo_descuento2,
                SUM(d.cantidad) AS total_cantidad,
                SUM(ROUND(d.cantidad * d.precio * (1 - d.descuento1 / 100) * (1 - d.descuento2 / 100) * (1 + d.recargo / 100), 2)) AS total_importe
            FROM presupuesto p
            JOIN presupuesto_detalle d ON d.presupuesto_id = p.id
            JOIN articulo a ON d.articulo_id = a.id
        ";

        $where = [
            'p.fecha BETWEEN ? AND ?',
        ];

        $params = [
            $desde->format('Y-m-d'),
            $hasta->format('Y-m-d'),
        ];

        if (isset($post['marca']) && $marcas = (array)$post['marca']) {
            $where[] = (isset($post['no_incluir_marca']) ? 'NOT': '') . ' a.marca_id IN (' .  str_repeat("?,", count($marcas)-1) . '?)';
            $params = array_merge($params, $marcas);
        }

        if (count($where)) {
            $sql .= ' WHERE ' . join(' AND ', $where);
        }

        $sql .= "
            GROUP BY a.id, a.codigo, a.descripcion, a.iva, a.costo, a.descuento1, a.descuento2
            ORDER BY a.codigo
        ";

        // echo $sql;
        // echo print_r($params);

        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);

        $data = [];

        foreach($sth->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $costo = $row['articulo_costo'] * (1 - $row['articulo_descuento1'] / 100) * (1 - $row['articulo_descuento2'] / 100);
            $costoTotal = $row['total_cantidad'] * $costo * (1 + $row['articulo_iva'] / 100);
            $importe = $row['total_importe'] /  $row['total_cantidad'];
            $total = $row['total_importe'] - $costoTotal;

            $data[] = [
                'codigo'            => $row['articulo_codigo'],
                'descripcion'       => $row['articulo_descripcion'],
                'total_cantidad'    => $row['total_cantidad'],
                'importe'           => round($importe, 2),
                'costo'             => round($costo, 2),
                'iva'               => round($row['articulo_iva'], 2),
                'total_importe'     => round($row['total_importe'], 2),
                'total_costo'       => round($costoTotal, 2),
                'total'             => round($total, 2),
            ];
        }

        return $data;
    }
}
