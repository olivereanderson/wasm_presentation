use optimized_square_free;
#[no_mangle]
pub extern "C" fn is_square_free(base: i32, exponent: i32, sub: i32) -> i32 {
    if optimized_square_free::is_square_free(optimized_square_free::convert_input(base, exponent, sub)) {
        1_i32
    } else {
        0_i32
    }
}

#[cfg(test)]
mod tests {
    use super::is_square_free;
    #[test]
    fn not_square_free() {
        assert_eq!(0, is_square_free(2, 4, 0));
    }

    #[test]
    fn square_free() {
        assert_eq!(1, is_square_free(3, 2, 2));
    }
}
