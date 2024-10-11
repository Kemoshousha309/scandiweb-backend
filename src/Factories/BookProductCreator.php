<?php

declare(strict_types=1);

namespace App\Factories;

use App\DTOs\CreateProductDto;
use App\Models\AbstractProduct;
use App\Models\BookProduct;
use App\Repositories\DbHandler;
use App\Repositories\Products\BookProductSaver;
use Ramsey\Uuid\Nonstandard\Uuid;

class BookProductCreator implements IProductCreator
{
    public function createProduct(CreateProductDto $dto): AbstractProduct
    {
        $saver = new BookProductSaver(DbHandler::getInstance());
        $id = Uuid::uuid4()->toString();
        $sku = $dto->getSKU();
        $name = $dto->getName();
        $price = $dto->getPrice();
        return  new BookProduct(
            $id,
            $sku,
            $name,
            $price,
            $dto->getWeight(),
            $saver
        );
    }
}
