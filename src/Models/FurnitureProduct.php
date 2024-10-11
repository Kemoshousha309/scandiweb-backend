<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\ValidationException;
use App\Repositories\Products\FurnitureProductSaver;
use App\Validators\Validator;

class FurnitureProduct extends AbstractProduct
{
    private array $dimensions; // (HxWxL)
    private FurnitureProductSaver $saver;

    public function __construct(string $id, string $SKU, string $name, float $price, array $dimensions, $saver)
    {
        parent::__construct($id, $SKU, $name, $price, "furniture");
        $this->dimensions = $dimensions;
        $this->saver = $saver;
    }


    public function validate()
    {
        parent::validate(); // Assuming there's some parent validation to call
        $validation = [];

        // Ensure there are dimensions to validate
        if (empty($this->dimensions) || count($this->dimensions) !== 3) {
            $validation['dimensions'] = 'Dimensions are required and should be in the (Height-Weight-Length) order.';
        } else {
            $validDimensions = true;

            foreach ($this->dimensions as $dimension) {
                // Ensure each dimension is valid: required and greater than 0
                if (!Validator::required((string) $dimension) || !Validator::greaterThan($dimension, 0)) {
                    $validDimensions = false;
                    break;
                }
            }

            if (!$validDimensions) {
                $validation['dimensions'] = 'Each dimension must be a positive value greater than 0.';
            }
        }

        // If validation errors exist, throw the exception
        if (count($validation) > 0) {
            throw new ValidationException($validation, 400);
        }
    }

    public function save(): void
    {
        $this->saver->save($this);
    }


    // Getters
    public function getDimensions(): array
    {
        return $this->dimensions;
    }

}
