<?php

namespace App\Services\ProductServices;

use App\DTOs\CreateProductDto;
use App\DTOs\Response;
use App\Mappers\ProductMapper;
use App\Services\ProductServices\Interfaces\CreateProductServiceInterface;
use App\Validators\ProductValidators\CreateProductValidator;

// responsible for business logic
// validation
/// save to db
// send notification
class CreateProductService implements CreateProductServiceInterface
{

    private ProductMapper $mapper;
    private CreateProductValidator $validator;
    public function __construct(ProductMapper $mapper, CreateProductValidator $validator)
    {
        $this->mapper = $mapper;
        $this->validator = $validator;
    }

    public function create(CreateProductDto $createProductDto): void
    {
        $product = $this->mapper->toProduct($createProductDto);
        $this->validator->validate($product);
        $product->save();
        $res = new Response(["Message" => "The product has saved successfully"]);
        echo $res->jsonResponse();
    }
}
