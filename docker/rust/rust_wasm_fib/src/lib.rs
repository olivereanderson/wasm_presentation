#[no_mangle]
pub extern "C" fn fib(n: i64) -> i64 {
    match n {
        0 | 1 => n,
        _ => fib(n - 1) + fib(n - 2),
    }
}
#[cfg(test)]
mod tests {
    use super::*;
    #[test]
    fn seven_first_fibonacci_numbers() {
        let sequence: Vec<i64> = (0_i64..7).into_iter().map(|i| fib(i)).collect();
        assert_eq!(sequence.as_slice(), &[0, 1, 1, 2, 3, 5, 8]);
    }
}
