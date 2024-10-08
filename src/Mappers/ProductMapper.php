<?php

namespace App\Mappers;

use App\DTOs\CreateProductDto;
use App\Factories\ProductCreatorSelector;
use App\Models\AbstractProduct;

// map dto to models  
// mapping 
class ProductMapper
{

    // map dto => product
    public function toProduct(CreateProductDto $dto): AbstractProduct
    {
        $productCreatorSelector = new ProductCreatorSelector();
        $productCreator = $productCreatorSelector->selectCreator($dto->gettype());
        $product = $productCreator->createProduct($dto);
        return $product;
    }

    // map $_post (api response) => dto
    public function toCreateProductDto(array $post): CreateProductDto
    {
        $dto = new CreateProductDto(
            $post["type"] ?? "",
            $post["SKU"] ?? "",
            $post["name"] ?? "",
            $post["price"] ?? "",
            $post["weight"] ?? "",
            $post["size"] ?? "",
            $post["dimensions"] ?? []
        );
        return $dto;
    }
    
}
