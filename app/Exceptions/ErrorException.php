<?php

namespace App\Exceptions;

use Exception;

/**
 * Class ErrorException
 * @package App\Exceptions
 */
class ErrorException extends Exception
{
    /**
     * @var string
     */
    private string $name;
    /**
     * @var int
     */
    private int $statusCode;
    /**
     * @var array
     */
    private array $params;

    /**
     * ErrorException constructor.
     * @param string $name
     * @param int $statusCode
     * @param array $params
     */
    public function __construct(string $name, int $statusCode = 400, array $params = [])
    {
        parent::__construct();
        $this->name = $name;
        $this->statusCode = $statusCode;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
