<?php declare(strict_types=1);

function isSquareFree(int $base, int $exponent, int $sub) : bool 
{
    $n = $base**$exponent - $sub; 
    if (($n % 4) == 0) {
        return false;
    }
    $i = 3;
    $square = 9;
    while ($square <= $n) {
        if (($n % $square) == 0) {
            return false;
        }
        $i += 2;
        $square = $i**2;
    }
    return true; 
}


$base = (int) $argv[1];
$exponent = (int) $argv[2];
$sub =  (int) $argv[3];
echo "The number " . (string) $base . "^" . (string) $exponent . " - " . (string) $sub . " is " . PHP_EOL;

$timeBeforeCallingFunction = hrtime(true);
if (isSquareFree($base, $exponent, $sub)) {
    $timeAfterCallingFunction = hrtime(true);
    echo  " square free!" . PHP_EOL;
} else {
    echo " not square free!" . PHP_EOL;
}
echo "The function completed after " . (string) (($timeAfterCallingFunction - $timeBeforeCallingFunction)/1e9) . " seconds" . PHP_EOL;
