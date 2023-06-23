<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class OneAboutEMagazineParameters extends ParametersFactory
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
                ->required(false)
                ->schema(Schema::string('language')),
            Parameter::path()
                ->name('aboutEMagazine')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('aboutEMagazine')),

        ];
    }
}
