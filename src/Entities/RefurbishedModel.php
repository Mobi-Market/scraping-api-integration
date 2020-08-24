<?php

declare(strict_types=1);

/*
 * This file is part of Lifeboat.
 * (c) Mobi-Market <info@mobi-market.co.uk>
 * This source file is proprietary and no license is given for its use outside
 * Mobi-Market.
 */

namespace MobiMarket\ScrapingTool\Entities;

class RefurbishedModel extends FillableEntity
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $brand;

    /**
     * @var array[]
     */
    public $models = [];

    /**
     * @var array
     */
    public $storage = [];

    /**
     * @var array[]
     */
    public $unwantedwords = [];

    /**
     * @var bool
     */
    public $status = true;
}
