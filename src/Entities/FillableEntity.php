<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class FillableEntity implements Arrayable
{
    public function __construct(iterable $fill = [])
    {
        foreach ($fill as $property => $value) {
            // $property = Str::snake($property);

            $this->{$property} = $value;
        }
    }

    public function toArray(): array
    {
        $raw = (array) $this;
        $out = [];

        foreach ($raw as $property => $value) {
            // $property = Str::studly($property);

            $out[$property] = $value;
        }

        return $out;
    }
}
