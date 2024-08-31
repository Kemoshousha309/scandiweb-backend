<?php

namespace App\Controllers;

class ProductController
{
    public function index()
    {
        // Fetch all products
        echo json_encode(['message' => 'List all products']);
    }

    public function create()
    {
        // Create a new product
        echo json_encode(['message' => 'Product created']);
    }

    public function show($id)
    {
        // Show a specific product
        echo json_encode(['message' => "Show product with ID: $id"]);
    }

    public function update($id)
    {
        // Update an existing product
        echo json_encode(['message' => "Update product with ID: $id"]);
    }

    public function delete($id)
    {
        // Delete a product
        echo json_encode(['message' => "Delete product with ID: $id"]);
    }
}
