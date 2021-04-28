<?php

namespace App\Exceptions;

use Exception;

/**
 * Class ErrorException
 * @package App\Exceptions
 */
class MessageException extends Exception
{
    /**
     * @var string
     */
    private string $msg;
    /**
     * @var int
     */
    private int $statusCode;

    /**
     * ErrorException constructor.
     * @param string $msg
     * @param int $statusCode
     */
    public function __construct(string $msg, int $statusCode = 400)
    {
        parent::__construct();
        $this->msg = $msg;
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
