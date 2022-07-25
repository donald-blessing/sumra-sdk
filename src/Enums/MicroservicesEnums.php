<?php

namespace Sumra\SDK\Enums;

final class MicroservicesEnums
{
    /**
     * @var string
     */
    const  COMMUNICATIONS_MS = 'Communications MS';

    /**
     * @var string
     */
    const  CONTACTS_BOOK_MS = 'Contacts Book MS';

    /**
     * @var string
     */
    const  FILES_MS = 'Files MS';

    /**
     * @var string
     */
    const  PAYMENTS_MS = 'Payments MS';

    /**
     * @var string
     */
    const  REFERENCE_BOOKS_MS = 'Reference Books MS';

    /**
     * @var string
     */
    const  SUBSCRIPTIONS_MS = 'Subscriptions MS';

    /**
     * @var string
     */
    const  NEWS_MS = 'News MS';

    /**
     * @var string
     */
    const  FAQS_MS = 'FAQs MS';

    /**
     * @var string
     */
    const  NOTIFICATIONS_MS = 'Notifications MS';

    /**
     * @var string
     */
    const REFERRALS_MS = 1;

    /**
     * @var string
     */
    const GLOBAL_IDENTITY_CENTER = 2;

    /**
     * @param string $microservice
     * @return bool
     */
    public static function checkMicroservice(string $microservice): bool
    {
        return in_array($microservice, [
            self::REFERRALS_MS,
            self::GLOBAL_IDENTITY_CENTER
        ]);
    }

    /**
     * @return string[]
     */
    public static function getServices(): array
    {
        return [
            self:: COMMUNICATIONS_MS,
            self::CONTACTS_BOOK_MS,
            self::FILES_MS,
            self::PAYMENTS_MS,
            self::REFERENCE_BOOKS_MS,
            self::SUBSCRIPTIONS_MS,
            self::NEWS_MS,
            self::FAQS_MS,
            self::NOTIFICATIONS_MS,
        ];
    }

}