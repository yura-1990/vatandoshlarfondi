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

class UserScientificDegreeSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('CompatriotExpert')
            ->properties(
                Schema::string('academic_degree')->default('Ilmiy daraja'),
                Schema::string('scientific_title')->default('Ilmiy Unvoni'),
                Schema::string('topic_of_scientific_article')->default('Ilmiy maqola mavzusi'),
                Schema::string('article_published_journal_name')->default('Chop etilgan jurnal nomi'),
                Schema::string('scientific_article_created_at')->default('2018-09-30'),
                Schema::string('article_url')->default('Ilmiy maqola url manzili'),
                Schema::string('article_file')->default(null)->format(Schema::FORMAT_BINARY),
                Schema::array('main_science_directions')->properties(
                    Schema::string()->default('Reading books'),
                )
            );
    }
}
