<?php

class Foo
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
