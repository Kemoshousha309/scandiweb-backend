<?php

namespace App\Controllers;

interface ControllerInterface
{

    public function list(): void;

    public function create(): void;

    public function show(string $id): void;

    public function update(string $id): void;

    public function delete(string $id): void;
}
