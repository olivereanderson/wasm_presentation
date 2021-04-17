<?php declare(strict_types=1);

function fib(int $n): int
{
    if ($n <= 1) {
        return n;
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

echo "The 80'th Fibonacci number is: " . (string) fib(80) . "\r\n";
