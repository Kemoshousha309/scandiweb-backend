<?php

declare(strict_types=1);

namespace App\Factories;

use App\Exceptions\ValidationException;
use ErrorException;

class ProductCreatorSelector
{
    // on having more types just add a new record to the registry
    private array $productCreatorRegistry = [
        "book" => "App\Factories\BookProductCreator",
        "furniture" => "App\Factories\FurnitureProductCreator",
        "dvd" => "App\Factories\DvdProductCreator",
    ];
    public function selectCreator(string $type): IProductCreator
    {
        try {
            if (!isset($this->productCreatorRegistry[$type])) {
                throw new ErrorException();
            }
            $creator = new $this->productCreatorRegistry[$type]();
            return $creator;
        } catch (ErrorException $err) {
            throw new ValidationException(["Type Error" => 'please provide a correct type']);
        }
    }
}
