<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\ValidationException;
use App\Validators\Validator;

class BookProduct extends AbstractProduct
{
    private float $weight;

    public function __construct(string $id, string $SKU, string $name, float $price, float $weight)
    {
        $this->weight = $weight;
        parent::__construct($id, $SKU, $name, $price, "book");
    }

    public function validate()
    {
        parent::validate();
        $validation = [];
        // Validate weight
        if (!Validator::required((string) $this->weight) || !Validator::greaterThan($this->weight, 0)) {
            $validation['weight'] = 'Book weight is required and should be greater than zero';
        }
        if(count($validation) > 0) {
            throw new ValidationException($validation, 400);
        }
    }

    // getters & setters 
    public function getWeight(): float
    {
        return $this->weight;
    }
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }
}
