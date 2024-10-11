<?php 

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\ValidationException;
use App\Repositories\Products\DvdProductSaver;
use App\Validators\Validator;

class DvdProduct extends AbstractProduct
{
    private float $size;
    private DvdProductSaver $saver;

    public function __construct(string $id, string $SKU, string $name, float $price, float $size, $saver)
    {
        $this->size = $size;
        $this->saver = $saver;
        parent::__construct($id, $SKU, $name, $price, "dvd");
    }

    public function validate()
    {
        parent::validate();
        $validation = [];
        // Validate weight
        if (!Validator::required((string) $this->size) || !Validator::greaterThan($this->size, 0)) {
            $validation['size'] = 'DVD size is required and should be greater than zero';
        }
        if(count($validation) > 0) {
            throw new ValidationException($validation, 400);
        }
    }
    
    public function save(): void {
        $this->saver->save($this);
    }

    // getters & setters 
    public function getSize(): float {
        return $this->size;
    }
    public function setSize(float $size): void {
        $this->size = $size;
    }
}
