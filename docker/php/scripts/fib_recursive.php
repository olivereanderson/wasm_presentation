<?php declare(strict_types=1);

function recursive_fib(int $n) : int
{
    if ($n <=1) {
        return $n;
    }
    return recursive_fib($n - 1) + recursive_fib($n-2);
}

$timeBeforeFunctionCall = hrtime(true);
$fib42 = recursive_fib(42);
$timeAfterFunctionCall = hrtime(true);
echo "The 42'nd Fibonacci number is: " . (string) $fib42 .  "\r\n";
echo "The function completed after: " . (string) ($timeAfterFunctionCall - $timeBeforeFunctionCall)/1e+9 . " seconds" . PHP_EOL;

