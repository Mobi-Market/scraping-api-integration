<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool\Exceptions;

use Throwable;

class UnexpectedResponse extends ScrapingBaseException
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 1000, $previous);
    }
}
