<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool\Entities;

class ApiAuth
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $password;

    /**
     * Create entity instance from array.
     */
    public static function fromArray(array $auth): self
    {
        $entity = new self();

        $entity->username   = $auth['username'];
        $entity->password   = $auth['password'];

        return $entity;
    }
}
