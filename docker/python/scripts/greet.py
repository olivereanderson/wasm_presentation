# Slight modification of: https://github.com/wasmerio/wasmer-python/blob/master/examples/appendices/greet.py
from wasmer import Store, Module, Instance
import os

# Instantiate the Webassembly module.
__dir__ = os.path.dirname(os.path.realpath(__file__))
module = Module(Store(), open(__dir__ + '/../wasm_binaries/rust_greeting.wasm', 'rb').read())
instance = Instance(module)

def greet(greeting: str) -> str:
    global instance
    # Write a greeting and convert it to bytes. 
    # greeting = 'Hello there, I am Python.'
    greeting_bytes = bytes(greeting,'utf-8')

    # Allocate memory for the greeting and get a pointer to it. 
    length_of_greeting_bytes = len(greeting_bytes) + 1
    input_pointer = instance.exports.allocate(length_of_greeting_bytes) 

    # Write the greeting_bytes into memory 
    memory = instance.exports.memory.uint8_view(input_pointer)
    memory[0:length_of_greeting_bytes] = greeting_bytes
    memory[length_of_greeting_bytes] = 0 # C-strings terminate by NULL.

    # Run the greet function. Give the pointer to the host.
    output_pointer = instance.exports.greet(input_pointer)

    # Read the result of the greet function.
    memory = instance.exports.memory.uint8_view(output_pointer)
    memory_length = len(memory)

    guest_greeting_bytes = []

    for i in range(memory_length):
        byte = memory[i]

        if byte == 0:
            break

        guest_greeting_bytes.append(byte)

    length_of_guest_greeting_bytes = len(guest_greeting_bytes) 

    # Deallocate the greeting bytes from the host and guest respectively. 
    instance.exports.deallocate(input_pointer, length_of_greeting_bytes)
    instance.exports.deallocate(output_pointer, length_of_guest_greeting_bytes)
    return bytes(guest_greeting_bytes).decode()


print(greet('Hello there, I am Python.'))