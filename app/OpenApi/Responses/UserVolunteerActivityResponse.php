<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class UserVolunteerActivityResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Successful response')
            ->content(
                MediaType::json()->schema(
                    Schema::array()->items(
                        Schema::object()->properties(
                            Schema::string('title')->default('Title'),
                            Schema::string('description')->default('description'),
                            Schema::array('images')->items(
                                Schema::string()->default('upload images')->format(Schema::FORMAT_BINARY)
                            ),
                        )
                    )
                )
            );

    }
}
