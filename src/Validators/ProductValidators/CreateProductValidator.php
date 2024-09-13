<?php
namespace App\Validators\ProductValidators;

use App\Models\AbstractProduct;

class CreateProductValidator {
    public function validate (AbstractProduct $product) {
        // do validation not related to product model data
        $product->validate(); // related to model data 
    }
}