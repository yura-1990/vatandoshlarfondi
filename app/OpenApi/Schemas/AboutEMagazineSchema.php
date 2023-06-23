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

class AboutEMagazineSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('AboutEMagazine')
            ->properties(
                Schema::string('id')->default(null),
                Schema::string('e_magazine_id')->default(null),
                Schema::string('images')->default(null),
                Schema::string('short_title')->default(null),
                Schema::string('title')->default(null),
                Schema::string('pages')->default(null),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->default(null)
            );
    }
}
