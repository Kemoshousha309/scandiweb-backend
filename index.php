<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Specify allowed HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers
// Handle preflight requests (CORS OPTIONS request)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


use App\Router;
use App\Controllers\ProductController;
use App\Mappers\ProductMapper;
use App\Repositories\DbHandler;
use App\Repositories\Products\DeleteProductRepo;
use App\Repositories\Products\ListProductRepo;
use App\Services\ProductServices\ListProductService;
use App\Services\ProductServices\CreateProductService;
use App\Services\ProductServices\DeleteProductService;
use App\Validators\ProductValidators\CreateProductValidator;

$router = new Router();
$dbHandler = DbHandler::getInstance();


// Define product endpoints
$createProductValidator = new CreateProductValidator();
$productMapper = new ProductMapper();
$listProductRepo = new ListProductRepo($dbHandler);
$deleteProductRepo = new DeleteProductRepo($dbHandler);
$deleteProductService = new DeleteProductService($deleteProductRepo);
$createService = new CreateProductService($productMapper, $createProductValidator);
$listProductService = new ListProductService($listProductRepo);

$productController = new ProductController(
    $createService,
    $listProductService,
    $deleteProductService,
    $productMapper
);

$router->add('/api/products', $productController, 'list', 'GET');    // List all products
$router->add('/api/products', $productController, 'create', 'POST');  // Create a new product
$router->add('/api/products/{SKU}', $productController, 'show', 'GET'); // Show a specific product
$router->add('/api/products/{SKU}', $productController, 'update', 'PUT'); // Update a product
$router->add('/api/products', $productController, 'delete', 'DELETE'); // Delete a product



$router->dispatch($_SERVER['REQUEST_URI']);
