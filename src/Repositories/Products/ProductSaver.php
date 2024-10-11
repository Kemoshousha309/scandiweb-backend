<?php

declare(strict_types=1);

namespace App\Repositories\Products;

use App\Exceptions\ValidationException;
use App\Models\AbstractProduct;
use App\Repositories\DbHandler;

abstract class ProductSaver
{
    protected DbHandler $dbHandler;

    public function __construct(DbHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }

    abstract public function save(AbstractProduct $product): void;


    protected function isExistProduct(AbstractProduct $product)
    {
        $sql = "SELECT * FROM products WHERE sku = :sku";
        $params = [
            ":sku" => $product->getSKU()
        ];
        $dbData = $this->dbHandler->fetchOne($sql, $params);
        return $dbData;
    }

    protected function commonSave(AbstractProduct $product)
    {
        if ($this->isExistProduct($product)) {
            throw new ValidationException(["This sku is used before"]);
        }
        $sql = "INSERT INTO products (id, sku, name, price, type) 
        VALUES (:id, :sku, :name, :price, :type)";
        $params = [
            "id" =>  $product->getId(),
            "sku" => $product->getSKU(),
            "name" => $product->getName(),
            "price" => $product->getPrice(),
            "type" => $product->getType()
        ];
        $this->dbHandler->insert($sql, $params);
    }
}
