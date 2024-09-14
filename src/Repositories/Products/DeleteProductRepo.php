<?php


namespace App\Repositories\Products;

use App\Exceptions\ValidationException;
use App\Repositories\DbHandler;

class DeleteProductRepo
{
    private DbHandler $dbHandler;

    public function __construct(DbHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }

    public function delete(array $ids)
    {
        if(count($ids) === 0) {
            throw new ValidationException(["You should provide at least one product id."]);
        }
        foreach ($ids as $id) {
            if (!$this->isExistProduct($id)) {
                throw new ValidationException(["Can't delete not existing product."]);
            }
        }
        // Create placeholders for the SQL query
        $placeholders = implode(', ', array_map(fn($key) => ":id$key", array_keys($ids)));

        $sql = "DELETE FROM products WHERE id IN ($placeholders)";

        // Create an associative array to map placeholders to actual IDs
        $params = [];
        foreach ($ids as $key => $id) {
            $params[":id$key"] = $id;
        }

        $this->dbHandler->query($sql, $params);
    }

    private function isExistProduct(string $id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $params = [
            ":id" => $id
        ];
        $dbData = $this->dbHandler->fetchOne($sql, $params);
        return $dbData;
    }
}
