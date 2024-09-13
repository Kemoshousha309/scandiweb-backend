<?php


namespace App\Repositories\Products;

use App\Repositories\DbHandler;

class ListProductRepo
{
    private DbHandler $dbHandler;

    public function __construct(DbHandler $dbHandler)
    {
        $this->dbHandler = $dbHandler;
    }

    public function list()
    {
        // list all products
        // SQL query to join products with type-specific tables
        $sql = "
            SELECT p.id, p.sku, p.name, p.price, p.type,
                   bp.weight AS book_weight,
                   fp.height AS furniture_height, fp.width AS furniture_width, fp.length AS furniture_length,
                   dp.size AS dvd_size
            FROM products p
            LEFT JOIN book_products bp ON p.id = bp.product_id
            LEFT JOIN furniture_products fp ON p.id = fp.product_id
            LEFT JOIN dvd_products dp ON p.id = dp.product_id
        ";
        // Execute the query and fetch all results
        $products = $this->dbHandler->fetchAll($sql);

        // clean the result
        $cleaned = $this->cleanProductsData($products);
        return $cleaned;
    }

    public function cleanProductsData(array $products)
    {
        $cleanedProducts = [];
        foreach ($products as $product) {
            $cleanedProduct = array_filter($product, function ($value) {
                return $value !== null;
            });
            $type = $product["type"];
            foreach ($cleanedProduct as $key => $value) {
                if(str_starts_with($key, $type)){ // "book_weight": "35"
                    $keyWithoutPrefix = substr($key, strlen($type)+1);
                    $cleanedProduct[$keyWithoutPrefix] = $value;
                    unset($cleanedProduct[$key]);
                }
            }
            array_push($cleanedProducts, $cleanedProduct);
        }
        return $cleanedProducts;
    }
}
