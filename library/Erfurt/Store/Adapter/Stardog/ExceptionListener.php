<?php

use Guzzle\Common\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Hooks into the request life cycle and throws an exception whenever
 * an error occurs.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 */
class Erfurt_Store_Adapter_Stardog_ExceptionListener implements EventSubscriberInterface
{

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array('request.error' => array('onRequestError', -1));
    }

    /**
     * Throws a more meaningful request exception if available
     *
     * @param Event $event Event emitted
     * @throws Erfurt_Store_Adapter_Stardog_ApiClientException
     */
    public function onRequestError(Event $event)
    {
        $exception = \Erfurt_Store_Adapter_Stardog_ApiClientException::factory($event['request'], $event['response']);
        $event->stopPropagation();
        throw $exception;
    }
}
