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

    public function delete(string $id)
    {
        if (!$this->isExistProduct($id)) {
            throw new ValidationException(["Can't delete not existing product"]);
        }
        $sql = 'DELETE FROM products WHERE id = :id';
        $params = [
            "id" => $id
        ];
        $this->dbHandler->query($sql, $params);
    }

    public function deleteAll() {
        $sql = 'DELETE FROM products';
        $this->dbHandler->query($sql);
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
