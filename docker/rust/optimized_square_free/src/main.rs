use optimized_square_free;
use std::env;
use std::time::SystemTime;
fn main() {
    let args: Vec<String> = env::args().collect();
    let base = args[1].parse::<i32>().unwrap();
    let exponent = args[2].parse::<i32>().unwrap();
    let sub = args[3].parse::<i32>().unwrap();
    let now = SystemTime::now();
    print!("{}^{} - {} is ... \r\n", base, exponent, sub);
    if optimized_square_free::is_square_free(optimized_square_free::convert_input(
        base, exponent, sub,
    )) {
        print!("square free \r\n");
    } else {
        print!("not square free");
    }
    print!("time elapsed: {:?} \r\n", now.elapsed().unwrap());
}
