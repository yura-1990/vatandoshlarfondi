<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class SightseeingPlaceParameters extends ParametersFactory
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
            Parameter::query()
                ->name('paginate')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('paginate')),
            Parameter::query()
                ->name('city')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('city')),
        ];
    }
}
