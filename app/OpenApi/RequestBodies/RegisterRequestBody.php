<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\MediaType\MediaFormDataType;
use App\OpenApi\Schemas\UpdateUserProfileSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class RegisterRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaFormDataType::formData()->schema(UpdateUserProfileSchema::ref())
        );
    }
}
