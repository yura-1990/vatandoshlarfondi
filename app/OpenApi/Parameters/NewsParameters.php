<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class NewsParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            Parameter::header()
                ->name('language')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('language')),
            Parameter::query()
                ->name('type')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('type')),
            Parameter::query()
                ->name('page')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('page')),
            Parameter::query()
                ->name('per_page')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('per_page')),
            Parameter::query()
                ->name('tag')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('tag')),

        ];
    }
}
