<?php

use Go\Core\AspectKernel;
use Go\Core\AspectContainer;

/**
 * Application Aspect Kernel
 */
class ApplicationAspectKernel extends AspectKernel
{
    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     */
    protected function configureAop(AspectContainer $container)
    {
        $container->registerAspect(new NullAspect());
    }
}
