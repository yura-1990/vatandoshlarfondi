<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\UserEducationInfoSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateUserEducationInfoRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()
            ->content(
                MediaType::json()->schema(
                    UserEducationInfoSchema::ref()
                )
            );
    }
}
