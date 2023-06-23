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

class City3DSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('City3D')
            ->properties(
                Schema::integer('id')->default(1),
                Schema::integer('city_id')->default(1),
                Schema::string('image')->default('http://vatandoshlar.napaautomotive.uz/storage/3Dimages/dfgxdfhgfghgfhgf.jpg'),
                Schema::string('title')->default('Something about Uzb'),
                Schema::string('download')->default('http://vatandoshlar.napaautomotive.uz/storage/3Dimages/dfgxdfhgfghgfhgf.jpg'),
                Schema::string('share')->default('http://vatandoshlar.napaautomotive.uz/storage/3Dimages/dfgxdfhgfghgfhgf.jpg'),
            );
    }
}
