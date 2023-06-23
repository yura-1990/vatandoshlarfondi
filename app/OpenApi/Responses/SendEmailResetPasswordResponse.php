<?php

namespace App\OpenApi\Responses;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class SendEmailResetPasswordResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')
            ->content(MediaType::json()->schema(Schema::object()->properties(
                Schema::string('message')->default('Sent reset password link to the email')
            )));
    }
}
