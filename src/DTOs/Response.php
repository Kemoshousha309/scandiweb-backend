<?php

namespace App\DTOs;

class Response {
    private array $data;
    private int | null $errCode;


    public function __construct(array $data, int $errCode = null) 
    {
        $this->data = $data;
        $this->errCode = $errCode;
    }

    public function jsonResponse(string $key = null) {
        $res = [];
        if(!$key) {
            $res["response"] = $this->data;
        }else {
            $res[$key] = $this->data;
        }
        if($this->errCode) {
            $res["code"] = $this->errCode;
        };
        return json_encode($res, JSON_NUMERIC_CHECK);
    }

}