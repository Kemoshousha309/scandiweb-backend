<?php


namespace App\Repositories\Products;

use App\Models\AbstractProduct;
use App\Models\FurnitureProduct;
use App\Repositories\DbHandler;

class FurnitureProductSaver extends ProductSaver
{

    public function __construct(DbHandler $dbHandler)
    {
        parent::__construct($dbHandler);
    }

    public function save(AbstractProduct $product): void
    {
        $this->dbHandler->getPdo()->beginTransaction();
        $this->commonSave($product);
        $this->saveFurnitureProduct($product);
        $this->dbHandler->getPdo()->commit();
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
}
