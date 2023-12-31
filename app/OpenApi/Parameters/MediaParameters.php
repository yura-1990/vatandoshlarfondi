<?php

namespace App\OpenApi\Parameters;


use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class MediaParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('file')
                ->description('File to upload')
                ->required(false)
                ->schema(Schema::file('file'))
        ];
    }
}
