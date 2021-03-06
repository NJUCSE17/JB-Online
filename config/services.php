<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'github' => [
        'active'        => !is_null(env('GITHUB_CLIENT_ID')),
        'client_id'     => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect'      => env('GITHUB_CALLBACK_URL'),
    ],

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'   => App\User::class,
        'key'     => env('STRIPE_KEY'),
        'secret'  => env('STRIPE_SECRET'),
        'webhook' => [
            'secret'    => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'discourse' => [
        'middleware' => ['web', 'auth', 'verified', 'activated'],
        'route'      => 'sso/discourse',
        'secret'     => env('DISCOURSE_SECRET'),
        'suppress_welcome_message' => 'true',
        'url'  => env('DISCOURSE_URL'),
        'user' => [
            'access'      => null,
            'add_groups'  => null,
            'admin'       => null,
            'avatar_url'  => null,
            'avatar_force_update' => false,
            'bio'         => null,
            'email'       => 'email',
            'external_id' => 'student_id',
            'moderator'   => null,
            'name'        => 'name',
            'remove_groups' => null,
            'require_activation' => false,
            'username'    => 'email',
        ],
    ],

];
