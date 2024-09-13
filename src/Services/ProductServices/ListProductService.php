<?php

namespace App\Services\ProductServices;

use App\DTOs\Response;
use App\Repositories\Products\ListProductRepo;
use App\Services\ProductServices\Interfaces\ListProductServiceInterface;

class ListProductService implements ListProductServiceInterface {

    private ListProductRepo $listProductRepo;

    public function __construct(ListProductRepo $listProductRepo)
    {
        $this->listProductRepo = $listProductRepo;
    }
    public function list(): void {
        // implement validation, authentication or any other logic here 
        $allProducts = $this->listProductRepo->list();
        $res = new Response(["products" => $allProducts]);
        echo $res->jsonResponse();
    }
}
