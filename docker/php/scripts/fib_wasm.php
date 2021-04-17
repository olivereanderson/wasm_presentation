<?php declare(strict_types=1);

require_once './vendor/autoload.php';

function rust_fib(int $n): int
{
    $wasmBytes = file_get_contents('./../wasm_binaries/rust_fib.wasm');


    if (false === $wasmBytes) {
        echo '> Error loading module!'.PHP_EOL;

        exit(1);
    }
    // Create an Engine
    $engine = Wasm\Engine::new();

    // Create a Store
    $store = Wasm\Store::new($engine);

    echo 'Compiling module...'.PHP_EOL;
    $module = Wasm\Module::new($store, $wasmBytes);

    echo 'Instantiating module...'.PHP_EOL;
    $instance = Wasm\Instance::new($store, $module);

    // Extracting export...
    $exports = $instance->exports();

    $fib = (new Wasm\Extern($exports[1]))->asFunc();

    $arg = Wasm\Val::newI64($n);
    $args =  new Wasm\Vec\Val([$arg->inner()]);


    echo 'Calling `rust_fib` ...'.PHP_EOL;
    $result = $fib($args);

    return (new Wasm\Val($result[0]))->value();

}

echo "The 80'th Fibonacci number is: " . (string) rust_fib(80) . PHP_EOL;

