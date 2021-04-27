<?php declare(strict_types=1);

require_once './vendor/autoload.php';


function isSquareFreeWasm(int $base, int $exponent, int $sub) : bool
{
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

    // echo "instantiating the wasm module and extracting the function took: " . (string) ($timeAfterConstruction- $timeBeforeInstantiatingTheModule). " nanoseconds" . PHP_EOL;

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
echo "The number " . (string) $argv[1] . "^" . (string) $argv[2] . " - " . (string) $argv[3] . " is " . PHP_EOL;
$timeBeforeCallingFunction = hrtime(true);
if (isSquareFreeWasm((int) $argv[1], (int) $argv[2], (int) $argv[3])) {
    $timeAfterCallingFunction = hrtime(true);
   echo  " square free!" . PHP_EOL;
} else {
    echo " not square free!" . PHP_EOL;
}
echo "The function completed after " . (string) (($timeAfterCallingFunction - $timeBeforeCallingFunction)/1e9) . " seconds" . PHP_EOL;