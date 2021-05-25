<?php declare(strict_types=1);

require_once './vendor/autoload.php';

$timeBeforeInstantiatingTheModule = hrtime(true);
$wasmBytes = file_get_contents('./../wasm_binaries/rust_wasm_square_free.wasm');


if (false === $wasmBytes) {
    echo '> Error loading module!'.PHP_EOL;

    exit(1);
}
// Create an Engine
$engine = Wasm\Engine::new();

// Create a Store
$store = Wasm\Store::new($engine);

//echo 'Compiling module...'.PHP_EOL;
$module = Wasm\Module::new($store, $wasmBytes);

//echo 'Instantiating module...'.PHP_EOL;
$instance = Wasm\Instance::new($store, $module);


// Extracting export...
$exports = $instance->exports();

$is_square_free = (new Wasm\Extern($exports[1]))->asFunc();

$timeAfterConstruction = hrtime(true);

echo "instantiating the wasm module took: " . (string) ($timeAfterConstruction- $timeBeforeInstantiatingTheModule). " nanoseconds" . PHP_EOL;


function isSquareFreeWasm(int $base, int $exponent, int $sub) : bool
{
    global $is_square_free; 

    $baseArg = Wasm\Val::newI32($base);
    $exponentArg = Wasm\Val::newI32($exponent);
    $sub = Wasm\Val::newI32($sub);

    $args = new Wasm\Vec\Val([$baseArg->inner(), $exponentArg->inner(), $sub->inner()]);

    // echo "calling the exported function" . PHP_EOL;
    $resultWasm = $is_square_free($args);

    $result = (new Wasm\Val($resultWasm[0]))->value();

    if ($result === 1) {
        return true;
    } else {
        return false;
    }

}
$base = (int) $argv[1];
$exponent = (int) $argv[2];
$sub = (int) $argv[3];

echo "The number " . (string) $base . "^" . (string) $exponent . " - " . (string) $sub . " is " . PHP_EOL;
$timeBeforeCallingFunction = hrtime(true);
if (isSquareFreeWasm($base, $exponent, $sub) == 1){
    $timeAfterCallingFunction = hrtime(true);
   echo  " square free!" . PHP_EOL;
} else {
    echo " not square free!" . PHP_EOL;
}
echo "The function completed after " . (string) (($timeAfterCallingFunction - $timeBeforeCallingFunction)/1e9) . " seconds" . PHP_EOL;