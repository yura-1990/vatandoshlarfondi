<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class FilterExpertParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            Parameter::path()
                ->name('pagination')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('pagination')),
            Parameter::query()
                ->name('country')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('country')),
            Parameter::query()
                ->name('specialization')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('specialization')),

        ];
    }
}
