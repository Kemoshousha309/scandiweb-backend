<?php

namespace App\Services\ProductServices\Interfaces;

use App\DTOs\CreateProductDto;

interface CreateProductServiceInterface
{
    public function create(CreateProductDto $createProductDto): void;
}
