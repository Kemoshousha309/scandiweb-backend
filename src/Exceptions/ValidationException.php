<?php 

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    private array $validation; // {valid: boolean, {mess: string}};
    // Customizing the exception message
    public function __construct($validation, $code = 0, Exception $previous = null)
    {
        // Call the parent class constructor
        $this->validation = $validation;
        parent::__construct(null, $code, $previous);
    }

    public function getValidation(): array {
        return $this->validation;
    }
}

