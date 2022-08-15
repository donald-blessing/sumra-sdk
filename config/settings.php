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
        'communications' => env('API_COMMUNICATIONS_URL', env('APP_URL') . '/v1/communications'),
        'contacts_books' => env('API_CONTACTS_BOOKS_URL', env('APP_URL') . '/v1/contacts-books'),
        'crypto_exchange' => env('API_CRYPTO_EXCHANGE_URL', env('APP_URL') . '/v1/exchanges'),
        'crypto_wallets' => env('API_CRYPTO_WALLETS_URL', env('APP_URL') . '/v1/wallets'),
        'faqs' => env('API_FAQS_URL', env('APP_URL') . '/v1/faqs'),
        'files' => env('API_FILES_URL', env('APP_URL') . '/v1/files'),
        'gmet' => env('API_GMET_URL', env('APP_URL') . '/v1/gmet'),
        'identity' => env('API_IDENTITY_URL', env('APP_URL') . '/v1/users'),
        'instant_credit_lines' => env('API_INSTANT_CREDIT_LINES_URL', env('APP_URL') . '/v1/credit-lines'),
        'launchpad' => env('API_LAUNCHPAD_URL', env('APP_URL') . '/v1/launchpad'),
        'news' => env('API_NEWS_URL', env('APP_URL') . '/v1/news'),
        'notifications' => env('API_NOTIFICATIONS_URL', env('APP_URL') . '/v1/notifications'),
        'payments' => env('API_PAYMENTS_URL', env('APP_URL') . '/v1/payments'),
        'reference_books' => env('API_REFERENCE_BOOKS_URL', env('APP_URL') . '/v1/reference-books'),
        'referrals' => env('API_REFERRALS_URL', env('APP_URL') . '/v1/referrals'),
        'subscriptions' => env('API_SUBSCRIPTIONS_URL', env('APP_URL') . '/v1/subscriptions'),
//        'wealth_exchange' => env('API_WEALTH_EXCHANGE_URL', env('APP_URL') . '/'),
//        'wealth_cards' => env('API_WEALTH_CARDS_URL', env('APP_URL') . '/'),
    ],

    //'app_id' => "waiting-lists-ms-9009",
    'app_id' => "subscriptions-ms-9009",
];
