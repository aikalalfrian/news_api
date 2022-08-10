<?php

namespace App\Filters;

class TagFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('tags', $value);
    }
}
