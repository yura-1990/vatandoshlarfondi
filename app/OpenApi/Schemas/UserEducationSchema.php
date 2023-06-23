<?php

namespace App\OpenApi\Schemas;

use App\Enums\EducationLocationTypeEnum;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class UserEducationSchema extends SchemaFactory implements Reusable
{
    /**
     * @return SchemaContract
     */
    public function build(): SchemaContract
    {
        return Schema::object('expert')
            ->properties(
                Schema::string('institution')->default('Garvard universiteti (Harvard University)'),
                Schema::string('level')->default('Oliy'),
                Schema::string('faculty')->default('Garvard huquqshunoslik'),
                Schema::string('specialization_id')->default(1)->enum([1,2,3,4]),
                Schema::string('type')->default(EducationLocationTypeEnum::UZBEKISTAN->value),
            );
    }
}
