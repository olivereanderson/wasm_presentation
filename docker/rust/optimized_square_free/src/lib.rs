use std::iter;
use std::u128;

pub fn is_square_free(n: u128) -> bool {
    // Enough to test 4 followed by all odd squares that are less than n.
    !iter::once(2_u128)
        .chain((3..n).into_iter().step_by(2))
        .map(|i| i.pow(2))
        .take_while(|i| i <= &n)
        .any(|i| (n % i) == 0)
}
pub fn convert_input(base: i32, exponent: i32, sub: i32) -> u128 {
    u128::from(base.abs() as u32).pow(exponent.abs() as u32) - u128::from(sub.abs() as u32)
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
