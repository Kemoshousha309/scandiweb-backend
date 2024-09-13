<?php


namespace App\Repositories\Products;

use App\Exceptions\ValidationException;
use App\Models\AbstractProduct;
use App\Models\BookProduct;
use App\Models\DvdProduct;
use App\Models\FurnitureProduct;
use App\Repositories\DbHandler;

class CreateProductRepo
{
    private DbHandler $dbHandler;

    public function __construct(DbHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }

    public function save(AbstractProduct $product)
    {
        if ($this->isExistProduct($product)) {
            throw new ValidationException(["This sku is used before"]);
        }
        $this->dbHandler->getPdo()->beginTransaction();
        $this->commonSave($product);
        $this->specificSave($product);
        $this->dbHandler->getPdo()->commit();
    }

    private function isExistProduct(AbstractProduct $product)
    {
        $sql = "SELECT * FROM products WHERE sku = :sku";
        $params = [
            ":sku" => $product->getSKU()
        ];
        $dbData = $this->dbHandler->fetchOne($sql, $params);
        return $dbData;
    }

    private function commonSave(AbstractProduct $product)
    {
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

    private function specificSave(AbstractProduct $product)
    {
        // this should be implemented with overloading but this isn't directly supported in php
        if ($product instanceof BookProduct) {
            $this->saveBookProduct($product);
        } else if ($product instanceof FurnitureProduct) {
            $this->saveFurnitureProduct($product);
        } else if ($product instanceof DvdProduct) {
            $this->saveDvdProduct($product);
        }
    }

    private function saveBookProduct(BookProduct $product)
    {
        $sql = "INSERT INTO book_products (product_id, weight) 
        VALUES (:product_id, :weight)";
        $params = [
            "product_id" => $product->getId(),
            "weight" => $product->getWeight()
        ];
        $this->dbHandler->insert($sql, $params);
    }

    private function saveFurnitureProduct(FurnitureProduct $product)
    {
        $sql = "INSERT INTO furniture_products (product_id, height, width, length) 
        VALUES (:product_id, :height, :width, :length)";
        $dimensions = $product->getDimensions();
        $params = [
            "product_id" => $product->getId(),
            "height" => $dimensions[0],
            "width" => $dimensions[1],
            "length" => $dimensions[2],
        ];
        $this->dbHandler->insert($sql, $params);
    }

    private function saveDvdProduct(DvdProduct $product)
    {
        $sql = "INSERT INTO dvd_products (product_id, size) 
        VALUES (:product_id, :size)";
        $params = [
            "product_id" => $product->getId(),
            "size" => $product->getSize()
        ];
        $this->dbHandler->insert($sql, $params);
    }
}
