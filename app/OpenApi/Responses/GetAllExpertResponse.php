<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CompatriotExpertSchema;
use App\OpenApi\Schemas\UpdateUserProfileSchema;
use App\OpenApi\Schemas\UserEducationSchema;
use App\OpenApi\Schemas\UserEmploymentInfoSchema;
use App\OpenApi\Schemas\UserSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class GetAllExpertResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                CompatriotExpertSchema::ref('experts'),
            )
        );
    }
}
