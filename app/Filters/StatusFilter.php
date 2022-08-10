<?php

namespace App\Filters;

class StatusFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('status_article', $value);
    }
}
