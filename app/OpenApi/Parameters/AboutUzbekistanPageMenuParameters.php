<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class AboutUzbekistanPageMenuParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::path()
                ->name('aboutUzbekistanPageMenu')
                ->description('Parameter description')
                ->required(true)
                ->schema(Schema::integer('aboutUzbekistanPageMenu')),
        ];
    }
}
