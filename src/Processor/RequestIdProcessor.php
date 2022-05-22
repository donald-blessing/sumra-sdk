<?php declare(strict_types=1);

namespace Sumra\SDK\Processor;

use Monolog\Processor\ProcessorInterface;

/**
 * Adds a unique identifier into records
 *
 * @author Simon Mönch <sm@webfactory.de>
 */
class RequestIdProcessor implements ProcessorInterface
{
    /**
     * @var string
     */
    private $requestId;

    /**
     * RequestIdProcessor constructor.
     */
    public function __construct()
    {
        $this->requestId = app('request')->header('X-Request-ID');
    }

    /**
     * @param array $record
     *
     * @return array
     */
    public function __invoke(array $record): array
    {
        $record['extra']['request_id'] = $this->requestId;

        //$record['request_id'] = $this->requestId;

        return $record;
    }

    /**
     * Getter for requestId property
     *
     * @return string
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }
}
