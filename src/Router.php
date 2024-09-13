<?php

declare(strict_types=1);

namespace App;

use App\Controllers\ControllerInterface;
use App\DTOs\Response;
use App\Exceptions\ValidationException;
use Throwable;

// direct the endpoint call to the right controller and method 
class Router
{
    private array $routes = [];

    public function add(string $endpoint, ControllerInterface $controller, string $method, string $httpMethod = 'GET')
    {
        $this->routes[] = [
            'endpoint' => $endpoint,
            'controller' => $controller,
            'method' => $method,
            'httpMethod' => $httpMethod
        ];
        return $this;
    }

    public function dispatch(string $uri, string $basePath = '/scandiweb-test')
    {
        // Parse the path from the URI and remove the base path
        $path = parse_url($uri, PHP_URL_PATH);
        if (strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath));
        }

        $path = rtrim($path, '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            // Simple pattern matching for dynamic routes (e.g., /products/{id})
            $pattern = "@^" . preg_replace('/\{[^\}]+\}/', '([A-Za-z0-9\-]+)', $route['endpoint']) . "$@";

            try {
                if (preg_match($pattern, $path, $matches) && $route['httpMethod'] === $requestMethod) {
                    $controller = $route['controller'];
                    array_shift($matches); // Remove the full match from the matches array
                    return call_user_func_array([$controller, $route['method']], $matches);
                }
            }catch (ValidationException $err) {
                http_response_code(400);
                $res = new Response(["Validation Error" => $err->getValidation()]);
                echo $res->jsonResponse();
                return;
            } catch (Throwable $error) {
                http_response_code(500);
                $res = new Response(["Error" => "Internal Server Error", "details" => $error->getMessage()]); 
                echo $res->jsonResponse();
                return;
            } 
        }

        // Fallback to a 404 page if no route is found
        http_response_code(404);
        $res = new Response(['Error' => 'Not Found']);
        echo $res->jsonResponse();
    }
}
