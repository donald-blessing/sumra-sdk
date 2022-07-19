<?php

return [
    /**
     * Default empty identifier
     */
    'empty_uuid' => env('APP_EMPTY_UUID', '00000000-0000-0000-0000-000000000000'),

    /**
     * Default demo user IDs
     */
    'default_users_ids' => [
        '00000000-1000-1000-1000-000000000000',
        '00000000-2000-2000-2000-000000000000',
        '10000000-1000-1000-1000-000000000001',
        '10000001-1001-1001-1001-100000000001',
        '20000000-2000-2000-2000-000000000002',
        '20000002-2002-2002-2002-200000000002',
        '30000000-3000-3000-3000-000000000003',
        '30000003-3003-3003-3003-300000000003',
        '40000000-4000-4000-4000-000000000004',
        '40000004-4004-4004-4004-400000000004',
        '50000000-5000-5000-5000-000000000005',
        '50000005-5005-5005-5005-500000000005',
        '60000000-6000-6000-6000-000000000006',
        '60000006-6006-6006-6006-600000000006',
        '70000000-7000-7000-7000-000000000007',
        '70000007-7007-7007-7007-700000000007',
        '80000000-8000-8000-8000-000000000008',
        '80000008-8008-8008-8008-800000000008',
        '90000000-9000-9000-9000-000000000009',
        '90000009-9009-9009-9009-900000000009'
    ],

    /**
     * Pagination
     */
    'pagination_limit' => env('APP_PAGINATION_LIMIT', 10),

    /**
     * Microservices API
     */
    'api' => [
        'files' => [
            'host' => env('API_FILES_HOST', 'http://localhost:8080'),
            'version' => env('API_FILES_VERSION', '/v1')
        ],
        'identity' => [
           'host' => env('API_IDENTITY_HOST', 'http://localhost:8200'),
           'version' => env('API_IDENTITY_VERSION', '/v1')
        ],
        'app_id' => "subscriptions-ms-9009",
        //'app_id' => "waiting-lists-ms-9009",
        'referrals_ms' => env('API_REFERRALS_HOST', 'http://localhost'),
        'microservice' => env('MICROSERVICE', ''),
    ],

    /**
     * RabbitMQ Receivers
     */
    'pubsub_receiver' => [
        'api_manager' => env('RABBITMQ_RECEIVER_API_MANAGER', ucfirst(env('APP_ENV')) . '.APIGatewayManager'),
        'communications' => env('RABBITMQ_RECEIVER_COMMUNICATIONS', ucfirst(env('APP_ENV')) . '.CommunicationsMS'),
        'contacts_books' => env('RABBITMQ_RECEIVER_CONTACTS', ucfirst(env('APP_ENV')) . '.ContactsBooksMS'),
        'crypto_exchange' => env('RABBITMQ_RECEIVER_CRYPTO_EXCHANGE', ucfirst(env('APP_ENV')) . '.CryptoExchangeMS'),
        'wallets' => env('RABBITMQ_RECEIVER_WALLETS', ucfirst(env('APP_ENV')) . '.CryptoWalletMS'),
        'faqs' => env('RABBITMQ_RECEIVER_FAQS', ucfirst(env('APP_ENV')) . '.FAQsMS'),
        'files' => env('RABBITMQ_RECEIVER_FILES', ucfirst(env('APP_ENV')) . '.FilesMS'),
        'g_met' => env('RABBITMQ_RECEIVER_GMET', ucfirst(env('APP_ENV')) . '.G-METMS'),
        'identity_centre' => env('RABBITMQ_RECEIVER_IDENTITY', ucfirst(env('APP_ENV')) . '.IdentityCentreMS'),
        'instant_creditline' => env('RABBITMQ_RECEIVER_CRYPTO_INSTANT_CREDITLINE', ucfirst(env('APP_ENV')) . '.InstantCreditLineMS'),
        'launchpad' => env('RABBITMQ_RECEIVER_CRYPTO_LAUNCHPAD', ucfirst(env('APP_ENV')) . '.CryptoLaunchpadMS'),
        'news' => env('RABBITMQ_RECEIVER_NEWS', ucfirst(env('APP_ENV')) . '.NewsMS'),
        'notifications' => env('RABBITMQ_RECEIVER_NOTIFICATIONS', ucfirst(env('APP_ENV')) . '.NotificationsMS'),
        'payments' => env('RABBITMQ_RECEIVER_PAYMENTS', ucfirst(env('APP_ENV')) . '.PaymentsMS'),
        'reference_books' => env('RABBITMQ_RECEIVER_REFERENCE_BOOKS', ucfirst(env('APP_ENV')) . '.ReferenceBooksMS'),
        'referrals' => env('RABBITMQ_RECEIVER_REFERRALS', ucfirst(env('APP_ENV')) . '.ReferralsMS'),
        'subscriptions' => env('RABBITMQ_RECEIVER_SUBSCRIPTIONS', ucfirst(env('APP_ENV')) . '.SubscriptionsMS'),
    ],
];
