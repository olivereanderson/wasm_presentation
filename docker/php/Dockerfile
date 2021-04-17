FROM php:8.0-buster

RUN apt-get update -q && apt-get install -qq -y --no-install-recommends \
    git

RUN curl -fsSL 'https://github.com/wasmerio/wasmer-php/archive/master.tar.gz' -o wasm.tar.gz \
    && mkdir -p wasm \
    && tar -xf wasm.tar.gz -C wasm --strip-components=1 \
    && rm wasm.tar.gz \
    && ( \
        cd wasm/ext \
        && phpize \
        && ./configure --enable-wasm \
        && make -j "$(nproc)" \
        && make test \
        && make install \
        && cp ./lib/libwasmer.so /usr/lib/x86_64-linux-gnu/ \
    ) \
    && rm -r wasm \
    && docker-php-ext-enable wasm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /home/wasm_presentation/scripts
COPY ./scripts .
RUN composer require wasm/wasm
