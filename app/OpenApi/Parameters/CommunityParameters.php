<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class CommunityParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()->name('region_id')
                ->description('Region')
                ->required(false)
                ->schema(Schema::integer('region_id')->default(0)),
            Parameter::query()->name('page')
                ->description('Pagination Page')
                ->required(false)
                ->schema(Schema::integer('page')->default(1)),
        ];
    }
}
