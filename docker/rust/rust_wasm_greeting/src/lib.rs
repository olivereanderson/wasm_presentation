// Sligth modification of: https://github.com/wasmerio/wasmer-python/blob/master/examples/appendices/greet.rs
use std::ffi::{CStr, CString};
use std::mem;
use std::os::raw::{c_char, c_void};

#[no_mangle]
pub extern "C" fn allocate(size: usize) -> *mut c_void {
    let mut buffer = Vec::with_capacity(size);
    let pointer = buffer.as_mut_ptr();
    mem::forget(buffer); // Makes sure that the buffer is not destructed at the end of this scope.

    pointer as *mut c_void
}

#[no_mangle]
pub extern "C" fn deallocate(pointer: *mut c_void, capacity: usize) {
    unsafe {
        let _ = Vec::from_raw_parts(pointer, 0, capacity);
    }
}

#[no_mangle]
pub extern "C" fn greet(pointer_to_greeting_bytes: *mut c_char) -> *mut c_char {
    let greeting_from_host = unsafe { CStr::from_ptr(pointer_to_greeting_bytes) }.to_str().unwrap();
    // We assume that the last word in the host's greeting is their name. 
    let host_name = greeting_from_host
        .split_whitespace()
        .last()
        .unwrap_or(&"")
        .as_bytes();
    let mut returned_greeting_bytes = b"Hello, ".to_vec();
    returned_greeting_bytes.extend(host_name);
    returned_greeting_bytes.extend(b" I am Rust.".to_vec());

    unsafe { CString::from_vec_unchecked(returned_greeting_bytes) }.into_raw()
}
