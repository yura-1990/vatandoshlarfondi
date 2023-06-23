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

class ELibrarySchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('ELibrary')
            ->properties(
                Schema::string('id')->default(null),
                Schema::string('title')->default(null),
                Schema::integer('stars')->default(null),
                Schema::string('viewers')->default(null),
                Schema::string('author')->default(null),
                Schema::string('language')->default(null),
                Schema::string('text')->default(null),
                Schema::string('type')->default(null),
                Schema::string('format')->default(null),
                Schema::string('publication')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::integer('ages')->default(null),
                Schema::string('stir')->default(null),
                Schema::string('pages')->default(null),
                Schema::string('thumbnail')->default(null),
                Schema::string('image')->default(null),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->default(null)
            );
    }
}
