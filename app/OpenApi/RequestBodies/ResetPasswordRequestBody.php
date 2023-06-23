<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class ResetPasswordRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::json()->schema(Schema::object()->properties(
                Schema::string('email')->default('example@gmail.com')
            )
            )
        );
    }
}
