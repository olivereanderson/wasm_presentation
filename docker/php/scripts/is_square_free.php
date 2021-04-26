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

$n = gmp_sub(gmp_pow(2,47),115);
$start = hrtime(true);
isSquareFree($n);
$end = hrtime(true);
$time = ($end - $start)/1e9;
echo "completed in: " . $time . " seconds " . PHP_EOL;


