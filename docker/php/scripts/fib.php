<?php declare(strict_types=1);

function fib(int $n): int
{
    if ($n <= 1) {
        return $n;
    }
    $last_fib = 0;
    $fib = 1;
    for ($i = 1; $i < $n; $i++) {
        $update_last_fib = $fib;
        $fib += $last_fib;
        $last_fib = $update_last_fib;
    }
    return $fib;
}
$timeBeforeFunctionCall = hrtime(true);
$fib42 = fib(42);
$timeAfterFunctionCall = hrtime(true);
echo "The 42'nd Fibonacci number is: " . (string) $fib42 . PHP_EOL;

echo "function call completed after:" . (string) ($timeAfterFunctionCall - $timeBeforeFunctionCall) . " nanoseconds \r\n";
