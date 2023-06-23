<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class OAuthParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::path()->name('provider')
                ->description('Name Provider For OAuth')
                ->required(true)
                ->schema(Schema::string('provider')->default('google')),
        ];
    }
}
