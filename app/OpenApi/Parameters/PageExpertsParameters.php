<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class PageExpertsParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::path()
                ->name('page')
                ->description('Page Number')
                ->required(true)
                ->schema(Schema::integer('paginate')->default(1)),
        ];
    }
}
