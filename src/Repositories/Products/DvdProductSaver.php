<?php


namespace App\Repositories\Products;

use App\Models\AbstractProduct;
use App\Models\DvdProduct;
use App\Repositories\DbHandler;

class DvdProductSaver extends ProductSaver
{

    public function __construct(DbHandler $dbHandler)
    {
        parent::__construct($dbHandler);
    }

    public function save(AbstractProduct $product): void
    {
        $this->dbHandler->getPdo()->beginTransaction();
        $this->commonSave($product);
        $this->saveDvdProduct($product);
        $this->dbHandler->getPdo()->commit();
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