<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool;

use Illuminate\Support\Facades\Facade;

class ScrapingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ScrapingRestApi::class;
    }
}
