<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CreateUserEmploymentInfoSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AllUserEmploymentInfoResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Successful response')
            ->content(
                MediaType::json()->schema(
                    CreateUserEmploymentInfoSchema::ref()
                )
            );
    }
}
