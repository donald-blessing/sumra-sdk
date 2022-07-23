<?php

namespace Sumra\SDK\Enums;

final class ServicesEnums
{
    const  COMMUNICATIONS_MS = 'Communications MS';
    const  CONTACTS_BOOK_MS = 'Contacts Book MS';
    const  FILES_MS = 'Files MS';
    const  PAYMENTS_MS = 'Payments MS';
    const  REFERENCE_BOOKS_MS = 'Reference Books MS';
    const  SUBSCRIPTIONS_MS = 'Subscriptions MS';
    const  NEWS_MS = 'News MS';
    const  FAQS_MS = 'FAQs MS';
    const  NOTIFICATIONS_MS = 'Notifications MS';

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