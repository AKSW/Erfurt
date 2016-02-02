<?php

use Guzzle\Common\Event;
use Guzzle\Common\Exception\RuntimeException;
use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Hooks into the request life cycle and throws a detailed exception whenever
 * an error occurs.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 13.03.14
 */
class Erfurt_Store_Adapter_Neo4J_ExceptionListener implements EventSubscriberInterface
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
     * @throws \Guzzle\Common\Exception\RuntimeException
     */
    public function onRequestError(Event $event)
    {
        $event->stopPropagation();
        $exception = BadResponseException::factory($event['request'], $event['response']);
        /* @var $response \Guzzle\Http\Message\Response */
        $response = $event['response'];
        $response->isContentType('application/json');
        $details = Zend_Json::decode($response->getBody(true));
        $message = '';
        if (isset($details['exception']) && isset($details['fullname']) && isset($details['stacktrace'])) {
            $message   = $details['exception'] . ' (' . $details['fullname'] . ')' . PHP_EOL . PHP_EOL
                       . implode(PHP_EOL, $details['stacktrace']) . PHP_EOL . PHP_EOL;
        }
        $message = $message
                 . 'Request: ' . PHP_EOL
                 . $exception->getRequest() . PHP_EOL . PHP_EOL
                 . 'Response: ' . PHP_EOL
                 . $response;
        throw new RuntimeException($message, $response->getStatusCode(), $exception);
    }

}
