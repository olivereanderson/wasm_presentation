use wasm_bindgen::prelude::*;
#[wasm_bindgen]
pub fn greet(greeting: String) -> String {
    let host_name = greeting.split_whitespace().last().unwrap_or("");
    let mut return_greeting = "Hello, ".to_string();
    return_greeting.push_str(host_name);
    return_greeting.push_str(" I am Rust");
    return_greeting
}

