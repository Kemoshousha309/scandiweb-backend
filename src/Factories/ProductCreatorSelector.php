<?php

declare(strict_types=1);

namespace App\Factories;

use App\Exceptions\ValidationException;

class ProductCreatorSelector
{
    public function selectCreator(string $type): IProductCreator
    {
        // this condition logic could be done by switch, if, hashTable(map), ...
        switch ($type) {
            case 'book':
                return new BookProductCreator();
            case 'dvd':
                return new DvdProductCreator();
            case 'furniture':
                return new FurnitureProductCreator();
            default:
                throw new ValidationException(["Type Error" => 'please provide a correct type']);
                break;
        }
    }
}
