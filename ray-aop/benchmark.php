<?php

declare(strict_types=1);

use Ray\Aop\Bind;
use Ray\Aop\Compiler;

require __DIR__ . '/vendor/autoload.php';

$max = 1000 * 1000;
$tmpDir = __DIR__ . '/tmp';

initialize: {
    $t = microtime(true);
    $tmpDir = __DIR__ . '/tmp';
    $compiler = new Compiler($tmpDir);
    $bind = (new Bind)->bindInterceptors(
        'intercepting',        // method name
        [new NullInterceptor]  // interceptors
    );
    $foo = $compiler->newInstance(Foo::class, [], $bind);
    echo sprintf('%-16s%.8f[μs]', 'initialize', (microtime(true) - $t) * 1000 * 1000) . PHP_EOL;
}

intercepting: {
    $t = microtime(true);
    for ($i = 0; $i < $max; $i++) {
        $foo->intercepting();
    }
    echo sprintf('%-16s%.8f[μs]', 'intercepting', microtime(true) - $t) . PHP_EOL;
}

no_intercepting: {
    $t = microtime(true);
    for ($i = 0; $i < $max; $i++) {
        $foo->original();
    }
    // should be same with native_call
    echo sprintf('%-16s%.8f[μs]', 'no_intercepting', microtime(true) - $t) . PHP_EOL;
}

native_call: {
    $foo = new \Foo();
    $t = microtime(true);
    for ($i = 0; $i < $max; $i++) {
        $foo->original();
    }
    echo sprintf('%-16s%.8f[μs]', 'native_call', microtime(true) - $t) . PHP_EOL;
}
