<?php

namespace App\Annotation;

use Attribute;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Put extends Route
{
    public function getMethods(): mixed
    {
        return [HttpMethod::PUT->name];
    }
}
