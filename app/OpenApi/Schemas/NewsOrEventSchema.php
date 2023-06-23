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

class NewsOrEventSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('NewsOrEvent')
            ->properties(
                Schema::string('id')->default(null),
                Schema::string('news_or_event_type_id')->default(null),
                Schema::string('image')->default(null),
                Schema::string('images')->default(null),
                Schema::string('data')->default(null),
                Schema::boolean('status')->default(''),
                Schema::string('tags')->default(null),
                Schema::string('text')->default(null),
                Schema::string('title')->default(null),
                Schema::string('viewers')->default(null),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->default(null)
            );
    }
}
