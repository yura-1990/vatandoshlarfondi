<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class CityGalleriesParameters extends ParametersFactory
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
                ->schema(Schema::string('language')->enum('uz', 'oz', 'ru', 'en')),
            Parameter::query()
                ->name('paginate')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('paginate')),

        ];
    }
}
