<?php

namespace App\Services\ProductServices;

use App\DTOs\Response;
use App\Repositories\Products\DeleteProductRepo;
use App\Services\ProductServices\Interfaces\DeleteProductServiceInterface;

class DeleteProductService implements DeleteProductServiceInterface {

    private DeleteProductRepo $deleteProductRepo;

    public function __construct(DeleteProductRepo $deleteProductRepo)
    {
        $this->deleteProductRepo = $deleteProductRepo;
    }
   
    public function delete(array $ids): void
    {
        $this->deleteProductRepo->delete($ids);
        $res = new Response(["Message" => "The products have been deleted successfully"]);
        echo $res->jsonResponse();
    }

}
