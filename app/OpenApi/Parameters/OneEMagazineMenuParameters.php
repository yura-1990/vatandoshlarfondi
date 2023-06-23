<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class OneEMagazineMenuParameters extends ParametersFactory
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
            Parameter::path()
                ->name('EMagazineMenu')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('EMagazineMenu')),

        ];
    }
}
