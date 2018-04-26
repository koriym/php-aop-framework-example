<?php

class Foo implements FooInterface
{
    public function intercepting()
    {
        return $this;
    }

    public function original()
    {
        return $this;
    }
}
