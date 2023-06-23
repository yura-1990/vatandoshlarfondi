<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class SightseeingParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            Parameter::query()
                ->name('language')
                ->description('Parameter description')
                ->required(true)
                ->schema(Schema::string('language')),
            Parameter::path()
                ->name('sightseeingPlace')
                ->description('Parameter description')
                ->required(true)
                ->schema(Schema::integer('sightseeingPlace')),

        ];
    }
}
