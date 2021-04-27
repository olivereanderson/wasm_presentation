<?php declare(strict_types=1);

function isSquareFree(GMP $n) : bool
{
    if(gmp_mod($n,gmp_init(4)) == 0) {
        return false;
    }
    $i = gmp_init(3);
    $square = gmp_pow($i,2);
    while ($square <= $n) {
        if (gmp_mod($n,$square) == 0) {
            return false;
        }
        $i = gmp_add($i,2);
        $square = gmp_pow($i,2);
    }
    return true;
}



echo "The number " . (string) $argv[1] . "^" . (string) $argv[2] . " - " . (string) $argv[3] . " is " . PHP_EOL;
$timeBeforeCallingFunction = hrtime(true);
$n = gmp_sub(gmp_pow((int) $argv[1],(int) $argv[2]), (int) $argv[3]);
if (isSquareFree($n)) {
    $timeAfterCallingFunction = hrtime(true);
    echo  " square free!" . PHP_EOL;
} else {
    echo " not square free!" . PHP_EOL;
}
echo "The function completed after " . (string) (($timeAfterCallingFunction - $timeBeforeCallingFunction)/1e9) . " seconds" . PHP_EOL;
