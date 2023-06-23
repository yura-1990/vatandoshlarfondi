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

class BannerExpertOrVolunteerSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('BannerExpertOrVolunteerPage')
            ->properties(
                Schema::string('id')->default(null),
                Schema::string('image')->default(null),
                Schema::string('title_uz')->default(null),
                Schema::string('title_oz')->default(null),
                Schema::string('title_ru')->default(null),
                Schema::string('title_en')->default(null),
                Schema::string('text_uz')->default(null),
                Schema::string('text_oz')->default(null),
                Schema::string('text_ru')->default(null),
                Schema::string('text_en')->default(null),
                Schema::integer('type')->default(null),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->default(null)
            );
    }
}
