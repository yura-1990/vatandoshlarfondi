<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\MediaType\MediaFormDataType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class UserVolunteerActivityRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaFormDataType::formData()->schema(
                Schema::object()->properties(
                    Schema::string('title')->default('title'),
                    Schema::string('description')->default('title'),
                    Schema::string('images')->type('file'),
                )
            )
        );
    }
}
