<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Router;
use App\Controllers\ProductController;

header('Content-Type: application/json');

$router = new Router();


// Define my routes
$router->add('/products', ProductController::class, 'index', 'GET');    // List all products
$router->add('/products', ProductController::class, 'create', 'POST');  // Create a new product
$router->add('/products/{SKU}', ProductController::class, 'show', 'GET'); // Show a specific product
$router->add('/products/{SKU}', ProductController::class, 'update', 'PUT'); // Update a product
$router->add('/products/{SKU}', ProductController::class, 'delete', 'DELETE'); // Delete a product

$router->dispatch($_SERVER['REQUEST_URI']);
