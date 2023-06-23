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

class UserEmploymentInfoSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('UserEmploymentInfo')
            ->properties(
                Schema::string('company')->default('Google'),
                Schema::string('position')->default('Web Engineer'),
                Schema::string('location_id')->default(10),
                Schema::boolean('status')->default(false),
                Schema::string('city')->default('Ulan Bator'),
                Schema::string('start_date')->format(Schema::FORMAT_DATE)->default(null),
                Schema::string('finish_date')->format(Schema::FORMAT_DATE)->default(null),
                Schema::string('specialization')->default('Web'),
            );

    }
}
