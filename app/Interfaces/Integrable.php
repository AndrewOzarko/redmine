<?php

namespace App\Interfaces;

interface Integrable
{
    public function __construct(string $key, string $url);

    public function do(string $action, ...$args);
}