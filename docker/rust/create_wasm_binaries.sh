#!/bin/bash
cd square_free && cargo build --target wasm32-unknown-unknown --release && wasm-gc --no-demangle target/wasm32-unknown-unknown/release/square_free.wasm -o ./square_free.gc.wasm && wasm-opt -O3 --strip-producers ./square_free.gc.wasm -o ./../wasm_binaries/square_free.wasm && cd ./..
cd rust_wasm_fib && cargo build --target wasm32-unknown-unknown --release && wasm-gc --no-demangle target/wasm32-unknown-unknown/release/rust_wasm_fib.wasm -o ./rust_fib.gc.wasm && wasm-opt -O3 --strip-producers ./rust_fib.gc.wasm -o ./../wasm_binaries/rust_fib.wasm
ls ./../wasm_binaries