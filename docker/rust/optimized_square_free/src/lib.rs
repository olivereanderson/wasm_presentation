use std::u128;

pub fn is_square_free(n: u128) -> bool {
    if (n % 4) == 0 {
        false
    } else if helpers::is_square_free_odd_check(n) {
        true
    } else {
        false
    }
}
pub fn convert_input(base: i32, exponent: i32, sub: i32) -> u128 {
    u128::from(base.abs() as u32).pow(exponent.abs() as u32) - u128::from(sub.abs() as u32)
}

pub(crate) mod helpers {
    pub(crate) fn is_square_free_odd_check(n: u128) -> bool {
        !(3_128..n).into_iter().step_by(2).map(|i| i.pow(2)).take_while(|i| i <= &n).any(|i| (n % i) == 0)
    }
} 