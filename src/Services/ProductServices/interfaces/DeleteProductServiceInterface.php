<?php

namespace App\Services\ProductServices\Interfaces;

interface DeleteProductServiceInterface
{
    public function delete(array $ids): void;
}
