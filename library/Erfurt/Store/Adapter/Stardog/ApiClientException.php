<?php

use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\ErrorResponse\ErrorResponseExceptionInterface;
use Guzzle\Service\Command\CommandInterface;

/**
 * ApiClientException
 *
 * @author Matthias Molitor <molitor@informatik.uni-bonn.de>
 * @since 01.03.14
 */
class Erfurt_Store_Adapter_Stardog_ApiClientException extends BadResponseException implements ErrorResponseExceptionInterface
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
     * Create an exception for a command based on a command and an error response definition.
     *
     * @param CommandInterface $command  Command that was sent
     * @param Response $response The error response
     * @return self
     */
    public static function fromCommand(CommandInterface $command, Response $response)
    {
        $inner   = BadResponseException::factory($command->getRequest(), $response);
        $code    = $response->getHeader('SD-Error-Code');
        $message = static::toMessage($code) . ':' . PHP_EOL . $response->getBody(true);
        return new static($message, $code, $inner);
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
            return 'Unknown error';
        }
        return static::$codesToMessages[$code];
    }

}
