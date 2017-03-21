<?php
namespace App\Helpers;

class Datatable
{
    public $columns;
    public $tableName;
    public $pkName;
    public $connection;
    public $where;

    public function __construct($connection, $tableName, $pkName, $where=null)
    {
        $this->tableName = $tableName;
        $this->pkName = $pkName;
        $this->connection = $connection;
        $this->where = $where;
    }

    public function addColumn($field, $title = '', $formatter = null)
    {
        if ($formatter) {
            $this->columns[] = [
                'db' => $field,
                'dt' => $title ? $title: $field,
                'formatter' => $formatter
            ];
        } else {
            $this->columns[] = [
                'db' => $field,
                'dt' => $title ? $title: $field,
            ];
        }
        return $this;
    }

    public function json()
    {
        header('Content-Type: application/json');

        if ($this->where) {
            echo json_encode(SSP::complex($_GET, $this->connection, $this->tableName, $this->pkName, $this->columns, $this->where, $this->where));
        } else {
            echo json_encode(SSP::simple($_GET, $this->connection, $this->tableName, $this->pkName, $this->columns));
        }
    }
}
