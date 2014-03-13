<?php

use Guzzle\Common\Exception\RuntimeException;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

/**
 * Stardog specific exception that extracts further information from the response if possible.
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 */
class Erfurt_Store_Adapter_Stardog_ApiClientException extends RuntimeException
{

    /**
     * Maps Stardog error codes to messages as documented
     * at {@link http://docs.stardog.com/http/#sd-Stardog-HTTP-Protocol}.
     *
     * @var array(string=>string)
     */
    protected static $codesToMessages = array(
        '0'  => 'Authentication error',
        '1'  => 'Authorization error',
        '2'  => 'Query evaluation error',
        '3'  => 'Unknown transaction',
        '4'  => 'Unknown database',
        '5'  => 'Database already exists',
        '6'  => 'Invalid database name',
        '7'  => 'Resource (user, role, etc) already exists',
        '8'  => 'Invalid connection parameter(s)',
        '9'  => 'Invalid database state for the request',
        '10' => 'Resource in use',
        '11' => 'Resource not found'
    );

    /**
     * Creates a new exception based on the Stardog error code.
     *
     * @param RequestInterface $request  Request
     * @param Response         $response Response received
     * @return Erfurt_Store_Adapter_Stardog_ApiClientException
     */
    public static function factory(RequestInterface $request, Response $response)
    {
        $inner   = BadResponseException::factory($request, $response);
        /* @var $header \Guzzle\Http\Message\Header */
        $header  = $response->getHeader('SD-Error-Code');
        $code    = (string)$header;
        $message = static::toMessage($code) . PHP_EOL . PHP_EOL . $response->getBody(true);
        return new static($message, (ctype_digit($code) ? (int)$code : 0), $inner);
    }

    /**
     * Maps the given Stardog error code to a message.
     *
     * @param string $code
     * @return string
     */
    protected static function toMessage($code)
    {
        if (!isset(static::$codesToMessages[$code])) {
            return $code;
        }
        return static::$codesToMessages[$code];
    }

}
