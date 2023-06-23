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

class CommunitySchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Community')
            ->properties(
                Schema::string('name')->default(null),
                Schema::string('title')->default(null),
                Schema::string('description')->default(null),
                Schema::string('logo')->default(null),
                Schema::string('document')->default(null),
                Schema::string('director')->default(null),
                Schema::string('director_img')->default(null),
                Schema::string('director_date')->default(null),
                Schema::string('work')->default(null),
                Schema::string('created_date')->default(null),
                Schema::string('members')->default(null),
                Schema::string('achievement')->default(null),
                Schema::string('region_id')->default(null),
                Schema::string('city_id')->default(null),
                Schema::string('user_id')->default(null),
                Schema::string('phone')->default(null),
                Schema::string('email')->default(null),
                Schema::string('address')->default(null),
                Schema::string('site')->default(null),
                Schema::string('status')->default(null),
                Schema::string('created_at')->default(null),
                Schema::string('updated_at')->default(null),
                Schema::string('region_name')->default(null),
                Schema::string('city_name')->default(null),

            );
    }
}
