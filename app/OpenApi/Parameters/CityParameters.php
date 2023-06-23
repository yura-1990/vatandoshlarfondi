<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class CityParameters extends ParametersFactory
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
                ->schema(Schema::string('language')->enum('uz', 'oz', 'en', 'ru')),
            Parameter::path()
                ->name('city')
                ->description('Parameter description')
                ->required(true)
                ->schema(Schema::integer('city')),

        ];
    }
}
