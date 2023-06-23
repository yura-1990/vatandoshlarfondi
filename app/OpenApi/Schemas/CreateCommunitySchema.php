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

class CreateCommunitySchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Community')->properties(
            Schema::string('name')->default(null),
            Schema::string('title')->default(null),
            Schema::string('description')->default(null),
            Schema::string('logo')->default(null),
            Schema::string('document')->default(null),
            Schema::string('director')->default(null),
            Schema::string('director_img')->default(null),
            Schema::string('director_date')->default(null),
            Schema::string('work')->default(null),
            Schema::string('created_date')->default('2023-04-27'),
            Schema::integer('members')->default(0),
            Schema::string('achievement')->default(null),
            Schema::integer('region_id')->default(null),
            Schema::integer('city_id')->default(null),
            Schema::string('phone')->default(null),
            Schema::string('email')->default(null),
            Schema::string('address')->default(null),
            Schema::string('site')->default(null),
            Schema::string('status')->default(null),
            Schema::array('attachments')->default(["path/img.jpg"]),
        );
    }
}
