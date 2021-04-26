<?php declare(strict_types=1);

function evenFactors(int $n) : array
{
    $evenFactors = [];
    while ($n % 2 == 0) {
        $evenFactors[] = 2;
        $n = $n/2;
    }
    return $evenFactors;
}

function nextOddFactor(int $n, $lastOddFactor) : int
{
    for($i=$lastOddFactor; $i**2 <= $n; $i+=2) {
        if (($n % $i) == 0) {
            return $i;
        }
    }
    return $n;
}

function largestExponent(int $n, int $base)
{
    $exponent = 1;
    while (($n % $base**$exponent) == 0) {
        $exponent += 1;
    }
    return $exponent;
}

$x1 = 2**17 - 5;
$x2 = 2**32 - 17;
$x = $x1**$x2;
echo isSquareFree($x, 3);