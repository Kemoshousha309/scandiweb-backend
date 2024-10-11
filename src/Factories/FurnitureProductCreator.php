<?php

declare(strict_types=1);

namespace App\Factories;

use App\DTOs\CreateProductDto;
use App\Models\AbstractProduct;
use App\Models\FurnitureProduct;
use App\Repositories\DbHandler;
use App\Repositories\Products\FurnitureProductSaver;
use Ramsey\Uuid\Nonstandard\Uuid;

class FurnitureProductCreator implements IProductCreator
{
    public function createProduct(CreateProductDto $dto): AbstractProduct
    {
        $saver = new FurnitureProductSaver(DbHandler::getInstance());
        $id = Uuid::uuid4()->toString();
        $sku = $dto->getSKU();
        $name = $dto->getName();
        $price = $dto->getPrice();
        return  new FurnitureProduct(
            $id,
            $sku,
            $name,
            $price,
            $dto->getDimensions(),
            $saver
        );
    }
}
