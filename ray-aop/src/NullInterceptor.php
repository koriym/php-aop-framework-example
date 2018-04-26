<?php

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

class NullInterceptor implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        return $invocation->proceed(); // do nothing
    }
}
