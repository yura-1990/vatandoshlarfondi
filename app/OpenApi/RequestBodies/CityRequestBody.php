<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CityRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create();
    }
}
