<?php declare(strict_types=1);

require_once './vendor/autoload.php';

class FibonacciCalculator {
    private $engine;
    private $store;
    private $module;
    private $instance;
    private $fib;

    function __construct()
    {
        $timeBeforeInstantiatingTheModule = hrtime(true);
        $wasmBytes = file_get_contents('./../wasm_binaries/rust_fib.wasm');


        if (false === $wasmBytes) {
            echo '> Error loading module!'.PHP_EOL;

            exit(1);
        }
        // Create an Engine
        $this->engine = Wasm\Engine::new();

        // Create a Store
        $this->store = Wasm\Store::new($this->engine);

        //echo 'Compiling module...'.PHP_EOL;
        $this->module = Wasm\Module::new($this->store, $wasmBytes);

        //echo 'Instantiating module...'.PHP_EOL;
        $this->instance = Wasm\Instance::new($this->store, $this->module);


        // Extracting export...
        $exports = $this->instance->exports();

        $this->fib = (new Wasm\Extern($exports[1]))->asFunc();

        $timeAfterConstruction = hrtime(true);

        echo "construction took: " . (string) ($timeAfterConstruction- $timeBeforeInstantiatingTheModule). " nanoseconds" . PHP_EOL;
    }

    public function fib_wasm(int $n) :int
    {
        $timeBeforeArgConversion = hrtime(true);
        $arg = Wasm\Val::newI64($n);
        $args =  new Wasm\Vec\Val([$arg->inner()]);
        $timeAfterArgConversion = hrtime(true);
        echo "argument conversion took: " . (string) ($timeAfterArgConversion - $timeBeforeArgConversion) . " nanoseconds" . PHP_EOL;

        echo 'Calling `rust_fib` ...'.PHP_EOL;

        $resultWasm = ($this->fib)($args);

        $timeBeforeResultConversion = hrtime(true);
        $result = (new Wasm\Val($resultWasm[0]))->value();
        $timeAfterResultConversion = hrtime(true);

        echo "result conversion took: " . (string) ($timeAfterResultConversion - $timeBeforeResultConversion) . " nanoseconds" . PHP_EOL;

        return $result;
    }


}

$timeBeforeCallingFunction = hrtime(true);
$fibCalculator = new FibonacciCalculator();
$fib42 = $fibCalculator->fib_wasm(42);
$timeAfterCallingFunction = hrtime(true);
echo "The 42'nd Fibonacci number is: " . (string)  $fib42 . PHP_EOL;
echo "function call completed after: " . (string) ($timeAfterCallingFunction - $timeBeforeCallingFunction)/1e+9 . " seconds" . PHP_EOL;

