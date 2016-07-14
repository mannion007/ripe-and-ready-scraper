<?php

namespace RipeAndReadyTests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use \PHPUnit\Framework\TestCase;

/**
 * A base class containing generic functions that are useful for multiple tests
 */
class BaseUnit extends TestCase
{
    /**
     * @param $object
     * @param string $method
     * @param array $arguments
     * @return mixed
     * Helper method which enables protected (or private) methods to be invoked for testing using reflection
     */
    protected function invokeProtectedMethod($object, string $method, array $arguments = [])
    {
        $class = new \ReflectionClass(get_class($object));
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        if (!empty($arguments)) {
            return $method->invokeArgs($object, $arguments);
        }

        return $method->invoke($object);
    }

    /**
     * @param $object
     * @param string $name
     * @return mixed
     * Helper method which enables protected (or private) properties to be accessed for testing using reflection
     */
    protected function getProtectedProperty($object, string $name)
    {
        $property = new \ReflectionProperty($object, $name);
        $property->setAccessible(true);
        return $property->getValue($object);
    }

    /**
     * @param int $responseStatus
     * @param string $responseBody
     * @return Client
     */
    protected function defineMockClient(int $responseStatus, string $responseBody):Client
    {
        $mock = new MockHandler([
            new Response(
                $responseStatus,
                ['Content-Type' => 'text/html'],
                $responseBody
            )
        ]);

        return new Client(['handler' => HandlerStack::create($mock)]);
    }
}
