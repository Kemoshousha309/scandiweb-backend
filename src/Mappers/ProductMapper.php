<?php

namespace App\Mappers;

use App\DTOs\CreateProductDto;
use App\Exceptions\ValidationException;
use App\Models\AbstractProduct;
use App\Models\BookProduct;
use App\Models\DvdProduct;
use App\Models\FurnitureProduct;
use Ramsey\Uuid\Nonstandard\Uuid;

// map dto to models  
// mapping 
class ProductMapper
{

    // map dto => product
    public function toProduct(CreateProductDto $dto): AbstractProduct
    {
        $product = null;
        $id = Uuid::uuid4(); 
        $sku = $dto->getSKU();
        $name = $dto->getName();
        $price = $dto->getPrice();
        switch ($dto->gettype()) {
            case 'book':
                $product = new BookProduct(
                    $id,
                    $sku,
                    $name,
                    $price,
                    $dto->getWeight()
                );
                break;
            case 'dvd':
                $product = new DvdProduct(
                    $id,
                    $sku,
                    $name,
                    $price,
                    $dto->getSize()
                );
                break;
            case 'furniture':
                $product = new FurnitureProduct(
                    $id,
                    $sku,
                    $name,
                    $price,
                    $dto->getDimensions()
                );
                break;
            default:
                throw new ValidationException(["Type Error" => 'please provide a correct type']);
                break;
        }
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
