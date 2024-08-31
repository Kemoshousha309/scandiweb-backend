<?php

namespace App;

class Router
{
    private array $routes = [];

    public function add(string $endpoint, string $controller, string $method, string $httpMethod = 'GET')
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
            $pattern = "@^" . preg_replace('/\{[^\}]+\}/', '([A-Za-z0-9]+)', $route['endpoint']) . "$@";

            if (preg_match($pattern, $path, $matches) && $route['httpMethod'] === $requestMethod) {
                $controller = new $route['controller']();
                array_shift($matches); // Remove the full match from the matches array
                return call_user_func_array([$controller, $route['method']], $matches);
            }
        }

        // Fallback to a 404 page if no route is found
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
}
