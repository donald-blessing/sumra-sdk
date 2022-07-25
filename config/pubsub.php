<?php

return [
    'default_consumer_queue' => env('DEFAULT_CONSUMER_QUEUE', ''),

    /**
     * RabbitMQ Receivers
     */
    'queue' => [
        'api_manager' => env('RABBITMQ_RECEIVER_API_MANAGER', ucfirst(env('APP_ENV')) . '.APIGatewayManager'),
        'communications' => env('RABBITMQ_RECEIVER_COMMUNICATIONS', ucfirst(env('APP_ENV')) . '.CommunicationsMS'),
        'contacts_books' => env('RABBITMQ_RECEIVER_CONTACTS', ucfirst(env('APP_ENV')) . '.ContactsBooksMS'),
        'crypto_exchange' => env('RABBITMQ_RECEIVER_CRYPTO_EXCHANGE', ucfirst(env('APP_ENV')) . '.CryptoExchangeMS'),
        'crypto_wallets' => env('RABBITMQ_RECEIVER_CRYPTO_WALLETS', ucfirst(env('APP_ENV')) . '.CryptoWalletMS'),
        'faqs' => env('RABBITMQ_RECEIVER_FAQS', ucfirst(env('APP_ENV')) . '.FAQsMS'),
        'files' => env('RABBITMQ_RECEIVER_FILES', ucfirst(env('APP_ENV')) . '.FilesMS'),
        'g_met' => env('RABBITMQ_RECEIVER_GMET', ucfirst(env('APP_ENV')) . '.G-METMS'),
        'identity_centre' => env('RABBITMQ_RECEIVER_IDENTITY', ucfirst(env('APP_ENV')) . '.IdentityCentreMS'),
        'instant_credit_lines' => env('RABBITMQ_RECEIVER_CRYPTO_INSTANT_CREDITLINES', ucfirst(env('APP_ENV')) . '.InstantCreditLineMS'),
        'launchpad' => env('RABBITMQ_RECEIVER_CRYPTO_LAUNCHPAD', ucfirst(env('APP_ENV')) . '.CryptoLaunchpadMS'),
        'news' => env('RABBITMQ_RECEIVER_NEWS', ucfirst(env('APP_ENV')) . '.NewsMS'),
        'notifications' => env('RABBITMQ_RECEIVER_NOTIFICATIONS', ucfirst(env('APP_ENV')) . '.NotificationsMS'),
        'payments' => env('RABBITMQ_RECEIVER_PAYMENTS', ucfirst(env('APP_ENV')) . '.PaymentsMS'),
        'reference_books' => env('RABBITMQ_RECEIVER_REFERENCE_BOOKS', ucfirst(env('APP_ENV')) . '.ReferenceBooksMS'),
        'referrals' => env('RABBITMQ_RECEIVER_REFERRALS', ucfirst(env('APP_ENV')) . '.ReferralsMS'),
        'subscriptions' => env('RABBITMQ_RECEIVER_SUBSCRIPTIONS', ucfirst(env('APP_ENV')) . '.SubscriptionsMS'),
        'wealth_exchange' => env('RABBITMQ_RECEIVER_WEALTH_EXCHANGE', ucfirst(env('APP_ENV')) . '.WealthExchangeMS'),
        'wealth_cards' => env('RABBITMQ_RECEIVER_WEALTH_CARDS', ucfirst(env('APP_ENV')) . '.WealthCardsMS'),
    ],
];
