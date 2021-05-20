<?php declare(strict_types=1);

function isSquareFree(int $n) : bool 
{
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

echo "The number " . (string) $argv[1] . "^" . (string) $argv[2] . " - " . (string) $argv[3] . " is " . PHP_EOL;
$timeBeforeCallingFunction = hrtime(true);
$n = pow((int) $argv[1],(int) $argv[2]) - (int) $argv[3];
if (isSquareFree($n)) {
    $timeAfterCallingFunction = hrtime(true);
    echo  " square free!" . PHP_EOL;
} else {
    echo " not square free!" . PHP_EOL;
}
echo "The function completed after " . (string) (($timeAfterCallingFunction - $timeBeforeCallingFunction)/1e9) . " seconds" . PHP_EOL;
