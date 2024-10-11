<?php

declare(strict_types=1);

namespace App\Factories;

use App\DTOs\CreateProductDto;
use App\Models\AbstractProduct;
use App\Models\DvdProduct;
use App\Repositories\DbHandler;
use App\Repositories\Products\DvdProductSaver;
use Ramsey\Uuid\Nonstandard\Uuid;

class DvdProductCreator implements IProductCreator
{
    public function createProduct(CreateProductDto $dto): AbstractProduct
    {
        $saver = new DvdProductSaver(DbHandler::getInstance());
        $id = Uuid::uuid4()->toString();
        $sku = $dto->getSKU();
        $name = $dto->getName();
        $price = $dto->getPrice();
        return  new DvdProduct(
            $id,
            $sku,
            $name,
            $price,
            $dto->getSize(),
            $saver
        );
    }
}
