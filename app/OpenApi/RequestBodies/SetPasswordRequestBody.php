<?php

namespace App\OpenApi\RequestBodies;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class SetPasswordRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::string('token')->default('required|size:60'),
                    Schema::string('password')->default('required|min:6|confirmed'),
                    Schema::string('password_confirmation')->default('repeat')
                )
            )
        );
    }
}
