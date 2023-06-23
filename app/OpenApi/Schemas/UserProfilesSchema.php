<?php

namespace App\OpenApi\Schemas;

use App\Enums\FamilyStatusEnum;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class UserProfilesSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('UserProfile')
            ->properties(
                Schema::string('first_name')->default('John')->format(Schema::TYPE_STRING),
                Schema::string('second_name')->default('Doe')->format(Schema::TYPE_STRING),
                Schema::string('last_name')->default('Doevich')->format(Schema::TYPE_STRING),
                Schema::integer('national_address')->default('Tashkent, Uzbekistan')->format(Schema::TYPE_STRING),
                Schema::integer('international_location_id')->default(1)->format(Schema::TYPE_NUMBER),
                Schema::integer('international_address_id')->default(1)->format(Schema::TYPE_STRING),
                Schema::integer('national_id')->default(1)->format(Schema::TYPE_NUMBER),
                Schema::string('birth_date')->default('01/01/1990')->format(Schema::FORMAT_DATE),
                Schema::string('gender')->default(3)->format(Schema::TYPE_NUMBER),
                Schema::string('academic_degree')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('phone_number')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('scientific_title')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('job_position')->default('Doctor')->format(Schema::TYPE_STRING),
                Schema::string('work_experience')->default(2)->format(Schema::TYPE_NUMBER),
                Schema::string('additional_info')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('achievements')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('family_status')->enum(...FamilyStatusEnum::cases())->format(Schema::TYPE_NUMBER),
                Schema::string('hobbies')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('interests')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('opinions_about_uzbekistan')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('suggestions_and_recommendations')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('timezone')->default(null)->format(Schema::TYPE_STRING),
                Schema::string('language')->default(null)->format(Schema::TYPE_STRING),
            );
    }
}
