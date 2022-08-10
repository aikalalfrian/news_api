<?php

namespace App\Filters;

class TopicFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('topic', $value);
    }
}
