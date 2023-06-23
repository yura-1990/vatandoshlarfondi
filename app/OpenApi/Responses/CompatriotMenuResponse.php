<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CompatriotMenuSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class CompatriotMenuResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()
            ->description('Successful response')
            ->content(
                MediaType::json()->schema(CompatriotMenuSchema::ref('menu'))
            );
    }
}
