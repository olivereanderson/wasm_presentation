use std::iter;
use std::convert::TryInto;

pub fn is_square_free(n: i64) -> bool {
    // Enough to test 4 followed by all odd squares that are less than n.
    let n = n.abs();
    !iter::once(2i64)
        .chain((3..n).into_iter().step_by(2))
        .map(|i| i.pow(2))
        .take_while(|i| i <= &n)
        .any(|i| (n % i) == 0)
}
pub fn convert_input(base: i32, exponent: i32, sub: i32) -> i64 {
    (base as i64).pow(exponent.try_into().unwrap()) - (sub as i64)
}

#[cfg(test)]
mod tests {
    use super::*;
    #[test]
    fn not_square_free() {
        assert!(!is_square_free(4));
        assert!(!is_square_free(9));
        assert!(!is_square_free(144));
    }

    #[test]
    fn square_free() {
        assert!(is_square_free(2));
        assert!(is_square_free(21));
        assert!(is_square_free(2_u128.pow(5) - 1));
    }
}
