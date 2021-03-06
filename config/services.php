<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model'  => App\Membership::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'kickbox' => [
        'secret' => env('KICKBOX_SECRET'),
    ],

    'workplace' => [
        'scim_url' => env('WORKPLACE_SCIM_URL'),
        'api_token' => env('WORKPLACE_API_TOKEN'),
        'community_id' => env('WORKPLACE_COMMUNITY_ID'),
    ]

];
