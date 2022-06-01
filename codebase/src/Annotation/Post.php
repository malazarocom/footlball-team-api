<?php

namespace App\Annotation;

use Attribute;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Component\Routing\Annotation\Route;

#[Attribute]
class Post extends Route
{
    public function getMethods(): mixed
    {
        return [HttpMethod::POST->name];
    }
}
