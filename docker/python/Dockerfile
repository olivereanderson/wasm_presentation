FROM python:3.9-buster
RUN pip install wasmer==1.0.0 && pip install wasmer_compiler_cranelift==1.0.0
WORKDIR /home/wasm_presentation/scripts
COPY ./scripts .
