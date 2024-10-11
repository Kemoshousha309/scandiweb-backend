<?php


namespace App\Repositories\Products;

use App\Models\AbstractProduct;
use App\Models\BookProduct;
use App\Repositories\DbHandler;

class BookProductSaver extends ProductSaver
{

    public function __construct(DbHandler $dbHandler)
    {
        parent::__construct($dbHandler);
    }

    public function save(AbstractProduct $product): void
    {
        $this->dbHandler->getPdo()->beginTransaction();
        $this->commonSave($product);
        $this->saveBookProduct($product);
        $this->dbHandler->getPdo()->commit();
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
}
