<?php

declare(strict_types=1);


namespace App\Factories;

use App\DTOs\CreateProductDto;
use App\Models\AbstractProduct;

interface IProductCreator
{
    function createProduct(CreateProductDto $data): AbstractProduct;
}
