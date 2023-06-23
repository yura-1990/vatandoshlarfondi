<?php

namespace App\OpenApi\Responses;

use App\Enums\CompatriotTypeEnum;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AllExpertSuggestionResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Successful response')
            ->content(
                MediaType::json()->schema(
                    Schema::object()->properties(
                        Schema::string('suggestions')->default('Taklif qoldirish'),
                        Schema::string('additional_information')->default('Ilmiy Unvoni'),
                        Schema::string('image')->format(Schema::FORMAT_BINARY)->default('png, jpg, jpeg, heic'),
                        Schema::integer('type')->enum(...CompatriotTypeEnum::cases())->default(1),
                    )
                )
            );
    }
}
