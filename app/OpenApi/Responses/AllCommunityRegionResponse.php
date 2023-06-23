<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\AllCommunityRegionSchema;
use App\OpenApi\Schemas\AllCommunitySchema;
use App\OpenApi\Schemas\CreateUserEmploymentInfoSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AllCommunityRegionResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Successful response')
            ->content(
                MediaType::json()->schema(
                    AllCommunityRegionSchema::ref()
                )
            );
    }
}
