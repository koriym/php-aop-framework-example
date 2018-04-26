<?php

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;

class NullAspect implements Aspect
{
    /**
     * @Around("execution(public Foo->intercepting(*))")
     */
    public function aroundMethodExecution(MethodInvocation $invocation)
    {
        return $invocation->proceed();
    }
}
