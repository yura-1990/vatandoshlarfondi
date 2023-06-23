<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\EMagazineTipSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class EMagazineTipResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                EMagazineTipSchema::ref()
            )
        );
    }
}
