<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class CreateUserEmploymentInfoSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        $properties = [...(new UserEmploymentInfoSchema())->build()->properties,
            Schema::string('location_name')->default(null),
            Schema::boolean('status')->default(false),
            Schema::string('created_at')->format(Schema::FORMAT_DATE)->default(null),
            Schema::string('updated_at')->format(Schema::FORMAT_DATE)->default(null),
        ];

        return Schema::array('CreateUserEmploymentInfo')
            ->items(
                Schema::object('CreateUserEmploymentInfo')
                    ->properties(...$properties)
            );
    }
}
