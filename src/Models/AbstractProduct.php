<?php

declare(strict_types=1);


namespace App\Models;

use App\Exceptions\ValidationException;
use App\Validators\Validator;


abstract class AbstractProduct
{
    private string $id;
    private string $SKU;
    private string $name;
    private float $price;
    private string $type;

    public function __construct(string $id, string $SKU, string $name, float $price, string $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->SKU = $SKU;
        $this->type = $type;
    }

    public function validate(){
        // all these fields are required 
        $errors = [];
        // Validate SKU
        if (!Validator::required($this->SKU)) {
            $errors['SKU'] = 'SKU is required.';
        }

        // Validate name
        if (!Validator::required($this->name)) {
            $errors['name'] = 'Name is required.';
        }

        // Validate price
        if (!Validator::required((string) $this->price) || !Validator::greaterThan($this->price, 0)) {
            $errors['price'] = 'Price is required and must be greater than zero.';
        }

        if(count($errors) > 0) {
            throw new ValidationException($errors, 400);
        }
    } 

    // Getters 
    public function getSKU(): string
    {
        return $this->SKU;
    }
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
    
    public function getType(): string
    {
        return $this->type;
    }

    // Setters 
    public function setSKU(string $SKU): void
    {
        $this->SKU = $SKU;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
