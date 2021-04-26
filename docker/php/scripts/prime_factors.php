<?php declare(strict_types=1);

require_once "factorization_helpers.php";
function prime_factors(int $n) : array
{
    $evenFactors = evenFactors($n);
    $n = $n/(2**count($evenFactors));
    $oddFactors = [];
}


