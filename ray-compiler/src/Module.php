<?php

use Ray\Di\AbstractModule;

class Module extends AbstractModule
{
    public function configure()
    {
        $this->bind(FooInterface::class)->to(Foo::class);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->startsWith('intercepting'),
            [NullInterceptor::class]
        );
    }
}
