<?php

use App\Http\Middleware\Localization;

return [

    'collections' => [

        'default' => [

            'info' => [
                'title' => 'Vatandoshlar Portal BE',
                'description' => 'Vatandoshlar portal BE api documentation',
                'version' => '1.0.0',
                'contact' => [],
            ],

            'servers' => [
                [
                    'url' => env('APP_URL'),
                    'description' => "Local",
                    'variables' => [],
                ],
                [
                    'url' => env('SERVER_URL'),
                    'description' => "Server",
                    'variables' => [],
                ],
            ],

            'tags' => [],

            'security' => [
                GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement::create()->securityScheme('BearerToken'),
            ],

            // Non-standard attributes used by code/doc generation tools can be added here
            'extensions' => [
                // 'x-tagGroups' => [
                //     [
                //         'name' => 'General',
                //         'tags' => [
                //             'user',
                //         ],
                //     ],
                // ],
            ],

            // Route for exposing specification.
            // Leave uri null to disable.
            'route' => [
                'uri' => '/openapi',
                'middleware' => ['Localization'=>Localization::class],
            ],

            // Register custom middlewares for different objects.
            'middlewares' => [
                'paths' => [

                ],
                'components' => [
                    //
                ],
            ],

        ],

    ],

    // Directories to use for locating OpenAPI object definitions.
    'locations' => [
        'callbacks' => [
            app_path('OpenApi/Callbacks'),
        ],

        'request_bodies' => [
            app_path('OpenApi/RequestBodies'),
        ],

        'responses' => [
            app_path('OpenApi/Responses'),
        ],

        'schemas' => [
            app_path('OpenApi/Schemas'),
        ],

        'security_schemes' => [
            app_path('OpenApi/SecuritySchemes'),
        ],
    ],

];
