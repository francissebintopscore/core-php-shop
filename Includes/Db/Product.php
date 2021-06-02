<?php
namespace Includes\Db;

class Product extends Query
{
    protected $table = 'products';

    public function updateStock($qty, $id)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE `products` SET `stock`= (`stock`-?) WHERE `id`=?");

            $stmt->bind_param('ii', $qty, $id);
            $stmt->execute();

            if (!$stmt->error) {
                return true;
            }
            return false;
            $stmt->close();
            $this->conn->close();
        } catch (\Throwable $th) {
            return false;
        }
    }
}
