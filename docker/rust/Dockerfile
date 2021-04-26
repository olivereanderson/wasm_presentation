FROM rust:latest
RUN rustup target add wasm32-unknown-unknown
RUN cargo install wasm-gc
RUN apt update && apt install binaryen
WORKDIR /home/wasm_presentation/
COPY . .
RUN ls
