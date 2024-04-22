<?php

namespace Xel\Devise\Job;
use Xel\Async\Contract\JobInterface;

class test implements JobInterface
{
    public function process(): array
    {
        return [
          'Xel',
        ];
    }
}