<?php

namespace App\OpenApi\RequestBodies;

use App\Enums\CompatriotTypeEnum;
use App\OpenApi\MediaType\MediaFormDataType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateExpertSuggestionRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()->content(
            MediaFormDataType::formData()->schema(
                Schema::object()->properties(
                    Schema::string('suggestions')->default('Taklif qoldirish'),
                    Schema::string('additional_information')->default('Ilmiy Unvoni'),
                    Schema::string('images')->type('file')->default('png, jpg, jpeg, heic'),
                )
            )
        );
    }
}
