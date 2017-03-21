<?php
namespace App\Models;

class Articulo
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function stock($articuloId, $depositoId)
    {
        $sql = "SELECT cantidad FROM v_stock_deposito WHERE articulo_id = ? AND deposito_id = ?";
        $sth = $this->pdo->prepare($sql);
        $sth->execute([$articuloId, $depositoId]);
        $stock = $sth->fetch(\PDO::FETCH_ASSOC);

        if ($stock) {
            return (float)$stock['cantidad'];
        }

        return 0;
    }
}
