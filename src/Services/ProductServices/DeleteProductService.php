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
   
    public function delete(string $id): void
    {
        $this->deleteProductRepo->delete($id);
        $res = new Response(["Message" => "The product has been deleted successfully"]);
        echo $res->jsonResponse();
    }
    public function deleteAll(): void
    {
        $this->deleteProductRepo->deleteAll();
        $res = new Response(["Message" => "All The products have been deleted successfully"]);
        echo $res->jsonResponse();
    }
}
