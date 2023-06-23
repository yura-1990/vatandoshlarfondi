<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\AboutUzbekistanPageMenuSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AboutUzbekistanPageMenuResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(AboutUzbekistanPageMenuSchema::ref())
        );
    }
}
