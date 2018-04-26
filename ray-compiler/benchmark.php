<?php

declare(strict_types=1);
/**
 * This file is part of the Ray.Aop package.
 *
 * @license http://opensource.org/licenses/MIT MIT
 */

use Ray\Compiler\DiCompiler;
use Ray\Compiler\Exception\NotCompiled;
use Ray\Compiler\ScriptInjector;

require __DIR__ . '/vendor/autoload.php';

$max = 1000 * 1000;
$tmpDir = __DIR__ . '/tmp';

initialize: {
    $t = microtime(true);
    try {
        $foo = (new ScriptInjector($tmpDir))->getInstance(\FooInterface::class);
    } catch (NotCompiled $e) {
        (new DiCompiler(new Module, $tmpDir))->compile();
        $foo = (new ScriptInjector($tmpDir))->getInstance(\FooInterface::class);
    }
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
