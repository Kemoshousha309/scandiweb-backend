<?php

namespace App\Services\ProductServices\Interfaces;

interface DeleteProductServiceInterface
{
    public function delete(string $id): void;
    public function deleteAll(): void;
}
