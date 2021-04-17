FROM rust:latest
RUN rustup target add wasm32-unknown-unknown
RUN cargo install wasm-gc
WORKDIR /home/wasm_presentation/rust_wasm_fib/
COPY ./rust_wasm_fib .


