<?php declare(strict_types=1);

function recursive_fib(int $n) : int
{
    if ($n <=1) {
        return $n;
    }
    return recursive_fib($n - 1) + recursive_fib($n-2);
}

echo "The 80'th Fibonacci number is: " . (string) recursive_fib(80) . "\r\n";



