<?php

namespace App\OpenApi\Schemas;

use App\Enums\CompatriotTypeEnum;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class UserCompatriotExpertSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('UserCompatriotExpert')
            ->properties(
                Schema::string('id')->default(null),
                Schema::string('academic_degree')->default(null),
                Schema::string('scientific_title')->default(null),
                Schema::string('main_science_directions')->default(null),
                Schema::string('topic_of_scientific_article')->default(null),
                Schema::string('scientific_article_created_at')->format(Schema::FORMAT_DATE)->default(null),
                Schema::string('article_published_journal_name')->default(null),
                Schema::string('article_url')->default(null),
                Schema::string('article_file')->default(null),
                Schema::integer('type')->default(CompatriotTypeEnum::EXPERT->value),
                Schema::string('suggestions')->default('taklifi'),
                Schema::string('additional_information')->default('Qo`shimcha malumotlar'),
                Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->default(null),
                Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->default(null)
            );
    }
}
