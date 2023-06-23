<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\UserEmploymentInfoSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateUserEmploymentInfoRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::array('expert')->items(
                        UserEmploymentInfoSchema::ref()
                    )
                )

            )
        );
    }
}
