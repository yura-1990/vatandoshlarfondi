<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\MediaType\MediaFormDataType;
use App\OpenApi\Schemas\UserScientificDegreeSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UserScientificDegreeRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaFormDataType::formData()->schema(UserScientificDegreeSchema::ref())
        );
    }
}
