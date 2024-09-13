<?php


namespace App\Utils;

use Exception;

class EnvLoader {
    public static function loadEnv($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception('.env file not found');
        }
    
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
        foreach ($lines as $line) {
            // Skip comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
    
            // Parse environment variable name and value
            list($name, $value) = explode('=', $line, 2);
    
            // Remove surrounding whitespace and quotes (if any)
            $name = trim($name);
            $value = trim($value, '"');
    
            // Set the environment variable using putenv
            putenv("$name=$value");
    
            // Optionally add to $_ENV and $_SERVER superglobals
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }

}