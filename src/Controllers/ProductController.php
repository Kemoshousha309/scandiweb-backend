<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Mappers\ProductMapper;
use App\Services\ProductServices\Interfaces\CreateProductServiceInterface;
use App\Services\ProductServices\Interfaces\DeleteProductServiceInterface;
use App\Services\ProductServices\Interfaces\ListProductServiceInterface;

// handle protocol logic and call the right service 
class ProductController implements ControllerInterface
{
    private CreateProductServiceInterface $createService;
    private ListProductServiceInterface $listProductService;
    private DeleteProductServiceInterface $deleteProductService;
    private ProductMapper $mapper;


    public function __construct(
        CreateProductServiceInterface $createService, 
        ListProductServiceInterface $listProductService,
        DeleteProductServiceInterface $deleteProductService, 
        ProductMapper $mapper)
    {
        $this->createService = $createService;
        $this->listProductService = $listProductService;
        $this->deleteProductService = $deleteProductService;
        $this->mapper = $mapper;
    }

    public function list(): void
    {
        $this->listProductService->list();
    } 

    public function create(): void 
    {
        $jsonData = file_get_contents("php://input");
        $postData = json_decode($jsonData, true);
        if(!$postData) {
            throw new ValidationException(["Type Error"=>"you should provide product data"]);
        }
        $productDto = $this->mapper->toCreateProductDto($postData);
        $this->createService->create($productDto);
    }

    public function delete(string $id): void
    {
        $this->deleteProductService->delete($id);
    }

    public function deleteAll(): void
    {
        $this->deleteProductService->deleteAll();
    }

    public function show($id): void
    {
        // Show a specific product
        echo json_encode(['message' => "Show product with ID: $id"]);
    }

    public function update($id): void
    {
        // Update an existing product
        echo json_encode(['message' => "Update product with ID: $id"]);
    }


}
