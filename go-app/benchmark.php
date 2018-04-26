<?php

require __DIR__ . '/vendor/autoload.php'; // use composer

$tmpDir = __DIR__ . '/tmp';
$max = 1000 * 1000;

compile: {
    $t = microtime(true);
    // Initialize an application aspect container
    $applicationAspectKernel = ApplicationAspectKernel::getInstance();
    $applicationAspectKernel->init([
        'debug'        => false, // use 'false' for production mode
        'appDir'       => __DIR__ , // Application root directory
        'cacheDir'     => $tmpDir, // Cache directory
        // Include paths restricts the directories where aspects should be applied, or empty for all source files
        'includePaths' => [
            __DIR__ . '/src'
        ]
    ]);
    echo sprintf('%-16s%.8f[μs]', 'compile', (microtime(true) - $t) * 1000 * 1000) . PHP_EOL;
}

intercepting: {
    $foo = new Foo();
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

native: {
    $foo = new Foo;
    $t = microtime(true);
    for ($i = 0; $i < $max; $i++) {
        $foo->original();
    }
    // should be same with native_call
    echo sprintf('%-16s%.8f[μs]', 'native', microtime(true) - $t) . PHP_EOL;
}
