use internals::U128;
#[no_mangle]
pub extern "C" fn is_square_free(base: i32, exponent: i32, sub: i32) -> i32 {
    let n = U128::from(base.abs()).pow(U128::from(exponent.abs())) - U128::from(sub.abs());
    if internals::is_square_free(n) {
        1_i32
    } else {
        0_i32
    }
}

pub(crate) mod internals {
    use uint::construct_uint;
    construct_uint! {
        pub struct U128(2);
    }
    pub(crate) fn is_square_free(n: U128) -> bool {
        if (n % U128::from(4_u32)) == U128::from(0_u32) {
            return false;
        }
        let mut i = U128::from(3_u32);
        let mut square = i.pow(U128::from(2_u32));

        while square <= n {
            if n % square == U128::from(0) {
                return false;
            }
            i += U128::from(2_u64);
            square = i.pow(U128::from(2_u32));
        }
        true
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
