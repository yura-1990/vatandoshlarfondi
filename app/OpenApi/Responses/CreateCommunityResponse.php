<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CreateCommunitySchema;
use App\OpenApi\Schemas\UserEducationInfoSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CreateCommunityResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Successful response')
            ->content(
                MediaType::json()->schema(
                    CreateCommunitySchema::ref()
                )
            );
    }
}
