<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class ELibraryPaginateParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            Parameter::path()
                ->name('paginate')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::integer('paginate')),
            Parameter::query()
                ->name('search')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('search')),
            Parameter::query()
                ->name('lang')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('lang')),
            Parameter::query()
                ->name('type')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::string('type')),
            Parameter::query()
                ->name('new')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::boolean('new')),
            Parameter::query()
                ->name('popular')
                ->description('Parameter description')
                ->required(false)
                ->schema(Schema::boolean('popular')),

        ];
    }
}
