<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'discord' => [
        'server-id' => env('DISCORD_SERVER_ID'),
        'token' => env('DISCORD_BOT_TOKEN'),
        'hr_channel_id' => env('DISCORD_HR_CHANNEL_ID'),
        'member_events_channel_id' => env('DISCORD_MEMBER_EVENTS_CHANNEL_ID'),

        'webhooks' => [
            'screenshot-hub' => env('DISCORD_SCREENSHOT_HUB_WEBHOOK'),
            'human-resources' => env('DISCORD_HUMAN_RESOURCES_WEBHOOK'),
            'development-updates' => env('DISCORD_DEVELOPMENT_UPDATES_WEBHOOK'),
            'member-chat' => env('DISCORD_MEMBER_CHAT_WEBHOOK'),
        ],

        // Socialite stuff
        'client_id' => env('DISCORD_CLIENT_ID'),
        'client_secret' => env('DISCORD_CLIENT_SECRET'),
        'redirect' => env('DISCORD_REDIRECT_URI'),
        'allow_gif_avatars' => true,
        'avatar_default_extension' => 'jpg', // only pick from jpg, png, webp
    ],

];
