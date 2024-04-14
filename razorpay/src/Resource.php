<?php

namespace Razorpay\Api;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;

class Resource implements ArrayAccess, IteratorAggregate
{
    protected $attributes = array();

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }

    public function offsetExists($offset): bool
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetSet($offset, $value): void
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetGet($offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }


    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __isset($key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function __unset($key): void
    {
        unset($this->attributes[$key]);
    }
}
